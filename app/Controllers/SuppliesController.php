<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BrandModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceRowModel;
use App\Models\MeasuringUnitModel;
use App\Models\ProductModel;
use App\Models\ProductLogModel;
use App\Models\SupplierModel;

class SuppliesController extends BaseController
{
/**
 * Index page of the supplies view.
 * 
 * This function is responsible for displaying the main page of the supplies view.
 * It will display a list of all the suppliers and allow the user to select one of them.
 * 
 * @return \CodeIgniter\View\View The rendered view of the index page of the supplies view.
 */
    public function index() : string
    {
        //
        helper(['form', 'url']);
                
        $data['suppliers']  = ( new SupplierModel() )->select(["id", "name"])->orderBy("name", "ASC")->findAll();
        $data['brands']     = ( new BrandModel() )->select(["id", "name"])->orderBy("name", "ASC")->findAll();
        $data['m_units']    = ( new MeasuringUnitModel() )->select(["id", "name"])->orderBy("name", "ASC")->findAll();
        
        return view('suppliesMainScreen', $data);

    }

    public function store()
    {
        
        $validation         = service('validation');
        $convertData        = ['measuring_unit_id', 'stock', 'reorder_quantity', 'buying_price', 'selling_price', 'quantity', 'wholesale_discount'];
        $remember_me_array  = ["supplier_id", "brand_id", "measuring_unit_id", "name","reorder_quantity","selling_price","buying_price","wholesale_discount"];


        $rules = [
            'barcode'           => 'required',
            'supplier_id'       => 'required|numeric',
            'brand_id'          => 'required|numeric',
            'measuring_unit_id' => 'required|numeric',
                        
            'name'              => 'required',

            'stock'             => 'required|regex_match[/^-?[0-9]*\.?[0-9]+$/]',
            'reorder_quantity'  => 'required|regex_match[/^-?[0-9]*\.?[0-9]+$/]',
            'buying_price'      => 'required|regex_match[/^-?[0-9]*\.?[0-9]+$/]',
            'selling_price'     => 'required|regex_match[/^-?[0-9]*\.?[0-9]+$/]',
            'quantity'          => 'required|regex_match[/^-?[0-9]*\.?[0-9]+$/]',
            'wholesale_discount'=> 'required|regex_match[/^-?[0-9]*\.?[0-9]+$/]'

        ];
        
        $data = $this->request->getPost();
        foreach ( $convertData as $value ) {
            $data[ $value ]    = str_replace(',', '.', $this->request->getPost($value));
            $data[ $value ]    = $this->request->getPost($value)  == "" ? "0" : $this->request->getPost($value ); 

        }
       
        if (! $this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->back()->withInput();
        }

        
        // get existing product
        $productModel       = new ProductModel();
        $productLogModel    = new ProductLogModel();
        $product            = $productModel->where('barcode', $data['barcode'])->first();

        // update stock
        $data['stock'] = floatval($data['stock'] ) + floatval($data['quantity'] );
        $quantity = floatval($data['quantity'] );
        unset ( $data['quantity']);
        
        // save/update data 
        $product != null ? $productModel->set($data)->where('id', $product['id'])->update() : $productModel->insert($data); 

        //create a log
        if ( $product != null ) {
            $data['type_id']    = PRODUCT_LOG_TYPE_BUYING;
            $data['product_id'] = $product['id'] ; 
            $data['quantity']   = $quantity;
            $data['old_stock']  = $product['stock'];
            $data['new_stock']  = $data['stock'];

            $productLogModel->insert($data);
        }
        
       
        // deal with remember me fields
        foreach ( $remember_me_array as $item ) {
            
            isset ( $data[ $item . '-remember-me-checkbox' ] ) ? 
                    session()->setFlashdata ( $item . '-remember-me', $data[ $item ] ) : 
                    session()->remove( $item . '-remember-me' );
        
        }

        session()->setFlashdata('success', 'To προϊόν αποθηκεύτηκε επιτυχώς.' );
        $this->response->redirect( base_url('/supplies') );


    }

    public function ajaxGetList($entity)
    { // get a list of values for any of : [supplier, brand, technique]

        switch ($entity) {

            case "supplier" :
                {


                }
                break;

            case "brand" :
                {

                    $brand = new BrandModel();
                    return json_encode($brand->findAll());

                }

            case "technique" :
                {
                    return "pipes!";
                }
                break;

        }


    }

    public function ajaxSearchList($entity)
    { // get a list of values for any of : [supplier, brand, technique]

        switch ($entity) {

            case "supplier" :
                {

                    $supplierModel = new \App\Models\SupplierModel();
                    print_R(json_encode($supplierModel->select("name")->like("name", $this->request->getVar("keyphrase"))->findAll()));

                }
                break;

            case "brand" :
                {

                    $brand = new BrandModel();
                    return json_encode($brand->findAll());

                }

            case "technique" :
                {
                    return "pipes!";
                }
                break;

        }


    }

   



}
