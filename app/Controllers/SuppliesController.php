<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BrandModel;
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
        $data['title']      = "scan-ME :: Αγορά / Προσθηκη προϊόντος";
        
        return view('suppliesMainScreen', $data);

    }

    public function store()
    {
        
        $validation         = service('validation');
        $convertData        = ['measuring_unit_id', 'stock', 'reorder_quantity', 'buying_price', 'selling_price', 'quantity', 'wholesale_discount'];
        $remember_me_array  = ["supplier_id", "brand_id", "measuring_unit_id", "description","reorder_quantity","selling_price","buying_price","wholesale_discount"];


        $rules = [
            'barcode'           => 'required',
            'supplier_id'       => 'required|numeric',
            'brand_id'          => 'required|numeric',
            'measuring_unit_id' => 'required|numeric',
                        
            'description'       => 'required',

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
            return $this->response->setJSON( ['error' => $validation->getErrors()] );
        }

        
        // save the product        
        (new ProductModel())->__saveProductRaw ( $data );
        
        // create a new product log
        (new ProductLogModel())->__saveProductLogRaw( $data, PRODUCT_LOG_TYPE_BUYING );
        
       
        // deal with remember me fields
        foreach ( $remember_me_array as $item ) {
            
            isset ( $data[ $item . '-remember-me-checkbox' ] ) ? 
                    session()->setFlashdata ( $item . '-remember-me', $data[ $item ] ) : 
                    session()->remove( $item . '-remember-me' );
        
        }

       return $this->response->setJSON( ['success' => 'To προϊόν αποθηκεύτηκε επιτυχώς.'] );


    }

   

}
