<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ProductLogModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends BaseController
{
    public function index(): string    {
        $data['title'] = "scan-ME :: Λίστα προϊόντων";
        return view('productsMainScreen', $data);
    }


    public function ajaxBarcodeSearch ( $barcode ) {

        $product = (new ProductModel())->getProductByBarcode( $barcode );
        
        if ( $product ) {
            $data[ 'data' ] = $product;
            $data[ 'log' ]  = (new ProductLogModel())
                    ->select('product_logs.*, measuring_units.name as measuring_unit_name')
                    ->join( "measuring_units", "measuring_units.id = product_logs.measuring_unit_id", "left" )
                    ->where( "product_id", $product[ 'id' ] )
                    ->orderBy( "id", "DESC" )
                    ->findAll( 15, 0 );
        } else {
            $data[ 'data' ] = null;
            $data[ 'log' ]  = null;
        }

        return $this->response->setJSON( $data );
        
    }
    
    public function ajaxList()
    {
        $request = service('request');
        $post = $request->getPost();

        $model = new ProductModel();

        // DataTables params
        $draw = intval($post['draw'] ?? 0);
        $start = intval($post['start'] ?? 0);
        $length = intval($post['length'] ?? 10);

        // Ordering
        $orderColIndex = $post['order'][0]['column'] ?? null;
        $orderDir = $post['order'][0]['dir'] ?? 'asc';
        $columns = $post['columns'] ?? [];

        // Global search for 'name' only (requirement)
        $searchValue = $post['search']['value'] ?? '';

        // Base query
        $builder = $model->builder();
        $builder->select('products.id, products.barcode, products.measuring_unit_id, products.description, products.stock, products.reorder_quantity, products.buying_price');
        $builder->select( 'measuring_units.name as measuring_unit');
        $builder->join('measuring_units', 'measuring_units.id = products.measuring_unit_id', 'left');
        

        // total records
        $recordsTotal = $builder->countAllResults(false); // don't reset

        // apply search: only name column per requirement
        if (!empty($searchValue)) {
            $builder->groupStart()
                    ->like('products.description', $searchValue)
                    ->orLike('barcode', $searchValue)
                    ->groupEnd();
        }

        // records after filtering
        $recordsFiltered = $builder->countAllResults(false);

        // apply ordering (map column index to column name)
        if ($orderColIndex !== null && isset($columns[$orderColIndex]['data'])) {
            $colName = $columns[$orderColIndex]['data'];
            // protect against invalid columns
            $allowed = ['id','barcode','measuring_unit_id','description','stock','reorder_quantity','buying_price'];
            if (in_array($colName, $allowed)) {
                $builder->orderBy($colName, $orderDir);
            }
        } else {
            $builder->orderBy('id', 'desc');
        }

        // limit
        if ($length != -1) {
            $builder->limit($length, $start);
        }

        $rows = $builder->get()->getResultArray();

        $data = [];
        foreach ($rows as $r) {
            $data[] = [
                'id'                => $r['id'],
                'barcode'           => $r['barcode'],
                'measuring_unit'    => $r['measuring_unit'],
                'description'       => $r['description'],
                'stock'             => $r['stock'],
                'reorder_quantity'  => $r['reorder_quantity'],
                'buying_price'      => $r['buying_price'],
            ];
        }

        return $this->response->setJSON([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function destroy( $id ){
        
        // delete log ... 
        (new ProductLogModel())->where('product_id', $id )->delete();
        
        // delete product..
        (new ProductModel())->delete($id);
        
        return $this->response->setJSON(['success' => 'To προϊόν διαγράφηκε με επιτυχία!']);
    }

    // Export current filtered results to Excel
    public function export()
    {
        $request = service('request');
        $search = $request->getGet('search') ?? '';

        $model = new ProductModel();
        $builder = $model->builder();
        $builder->select('products.id, products.barcode, products.measuring_unit_id, products.description, products.stock, products.reorder_quantity, products.buying_price, products.selling_price');
        $builder->select( 'measuring_units.name as measuring_unit');
        $builder->select( 'brands.name as category_name');
        
        $builder->join('measuring_units', 'measuring_units.id = products.measuring_unit_id', 'left');
        $builder->join('brands', 'brands.id = products.brand_id', 'left');
        

        if (!empty($search)) {
            $builder->like('name', $search);
        }

        $rows = $builder->orderBy('id','desc')->get()->getResultArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // header
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Barcode');
        $sheet->setCellValue('C1', 'Περιγραφή');
        $sheet->setCellValue('D1', 'Κατηγορία');
        $sheet->setCellValue('E1', 'Στοκ');
        $sheet->setCellValue('F1', 'Μ.Μέτρησης');
        $sheet->setCellValue('G1', 'Ποσό αναπ/λιας');
        $sheet->setCellValue('H1', 'Τιμή αγοράς');
        $sheet->setCellValue('I1', 'Τιμή πώλησης');

        $rowNum = 2;
        foreach ($rows as $r) {
            $sheet->setCellValue("A{$rowNum}", $r['id']);
            $sheet->setCellValue("B{$rowNum}", $r['barcode']);
            $sheet->setCellValue("C{$rowNum}", $r['description']);
            $sheet->setCellValue("D{$rowNum}", $r['category_name']);
            $sheet->setCellValue("E{$rowNum}", $r['stock']);
            $sheet->setCellValue("F{$rowNum}", $r['measuring_unit']);
            $sheet->setCellValue("G{$rowNum}", $r['reorder_quantity']);
            $sheet->setCellValue("H{$rowNum}", $r['buying_price']);
            $sheet->setCellValue("I{$rowNum}", $r['selling_price']);
            $rowNum++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'people_export_' . date('Ymd_His') . '.xlsx';

        // send to browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

}
