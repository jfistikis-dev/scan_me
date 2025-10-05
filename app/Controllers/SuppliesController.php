<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BrandModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceRowModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;

class SuppliesController extends BaseController
{
    public function index()
    {
        //
        helper(['form', 'url']);
        $data['invoiceType'] = 0;
        
        $data['suppliers'] = ( new SupplierModel() )->select(["id", "name"])->orderBy("name", "ASC")->findAll();


        return view('suppliesMainScreen', $data );

    }

    // edit - store
    // update

    public function store()
    {

        // First of all save the product
        $productModel   = new ProductModel();
        $product_id     = $productModel->saveProduct( $this->request->getPost() );


        // If smth went wrong the the product_id is an array with errors!!
        if ( is_array( $product_id )) { return view('suppliesMainScreen', $product_id); }


        // Save the product in case user wants to retrieve it..
        $this->session->set( "last_product_id", $product_id );
		//d ( $product_id );
        //dd ( $this->request->getPost() );
        $product_array = $this->request->getPost() ;

        /*
         * We have 3 options here
         *
         * 1. We are talking about altering - inserting products -- [invoiceType = 0]
         *      a. Products is new - no product_id posted
         *      b. product is old - product_id posted
         *
         * 2. We are talking about inserting a new invoice -- [invoiceType = 1]
         *      a. Products is new - no product_id posted
         *      b. product is old - product_id posted
         *
         * 3. We are talking about updating a new invoice -- [invoiceType = 0, invoice_id = **]
         *      a. Products is new - no product_id posted
         *      b. product is old - product_id posted
         */


        $invoiceType        = $this->request->getPost( "invoiceType");

        switch ($invoiceType ) {

            // no invoice .. just altering - inserting products -- already taken care of!!
            case 1: break;

            // inserting a new invoice
            case 2:
                // create invoice
                $invoiceModel = new InvoiceModel();
                $invoiceModel->insert( [
                    "supplier_id"           => $product_array['supplier_id'],
                    "wholesale_discount"    => $product_array['wholesale_discount'],
                    "wholesale_price"       => $product_array["wholesale_price"]
                ]);
                $invoice_id = $invoiceModel->getInsertID();

                // create invoice row
                $invoiceRowModel    = new InvoiceRowModel();
                $sum                = floatval ($product_array["quantity"] )  * floatval ($product_array["wholesale_price"] );
                $sum                -= ($sum * floatval($product_array["wholesale_discount"]) /100) ;


                $invoiceRowModel->insert ([

                    "invoice_id"        => $invoice_id,
                    "product_id"        => $product_id,
                    "quantity"          => $product_array["quantity"],
                    "retail_price"      => $product_array["retail_price"],
                    "wholesale_price"   => $product_array["wholesale_price"],
                    "discount"          => $product_array["wholesale_discount"],
                    "sum"               => $sum
                ]);
                $invoiceRowId = $invoiceRowModel->getInsertID();


                // get invoice data
                $data ['invoice'] = $invoiceModel->select( "*, suppliers.*, suppliers.id as supplier_id")
                    ->join( "suppliers", "suppliers.id = invoices.supplier_id")
                    ->find($invoice_id);


                $data['invoiceRows'] = $invoiceRowModel
                    ->join("products", "products.id = invoice_rows.product_id")
                    ->find( $invoiceRowId );
                break;


            // updating an old open invoice
            case 3:

                // update the invoice adding this product as well !!

                break;

        }

        helper(['form', 'url']);

        $data[ "invoiceType"] = $invoiceType;
        return view('suppliesMainScreen', $data );



    }

    public function ajaxGetLastProduct () {

        $lastProductId = $this->session->get( "last_product_id" );
		
        if ($lastProductId != null ) {

            $productModel = new ProductModel();
            $product        = $productModel
                ->select( "products.*, products.id as product_id, suppliers.id as supplier_id, suppliers.name as supplier, brands.name as brand, brands.id as brand_id, category_rows.name as categoryItem")
                ->join ( "suppliers", "products.supplier_id = suppliers.id" )
                ->join ( "brands", "products.brand_id = brands.id" )
                ->join ( "category_rows", "products.categoryrow_id = category_rows.id" )
				->where ( 'products.id', $lastProductId)
                ->first();

            return print_R ( json_encode( $product ) );

        } else return null;

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

    public function ajaxAddToList($entity)
    {

        switch ($entity) {

            case "supplier" :
                {

                    $supplierModel = new \App\Models\SupplierModel();
                    $newItemName = $this->request->getVar('newItemName');


                    //print_R ( json_encode( $supplierModel->select("name")->like( "name", $this->request->getVar("keyphrase") )->findAll() ))   ;

                }
                break;

            case "brand" :
                {
                }
                break;
            case "technique" :
                {
                }
                break;

        }
    }



}
