<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\InvoiceRowModel;

class InvoiceController extends BaseController
{
    public function index()
    {
        //
    }

    public function search( $supplier_id )
    {
        $invoiceModel   = new \App\Models\invoiceModel();
        $invoices       = $invoiceModel->where( "supplier_id", $supplier_id)->findAll();
        print_r ( json_encode( $invoices ));

    }

    public function ajaxGetlastinvoices( )
    {
        $invoiceModel   = new \App\Models\invoiceModel();
        $invoices       = $invoiceModel
            ->select( "invoices.*, suppliers.name as name, DATE_FORMAT(invoices.updated_at, '%d/%m/%y') as date ")
            ->join ( "suppliers", "invoices.supplier_id = suppliers.id" )
            ->orderBy("date asc")
            ->findAll( 6, 0);
        print_r ( json_encode( $invoices ));

    }

    public function ajaxGetInvoice( $invoiceId )
    {

        $invoiceModel    = new \App\Models\InvoiceModel();
        $data["invoice"] = $invoiceModel
            ->select("invoices.*, invoices.id as invoice_id, suppliers.*, suppliers.name as supplier_name, DATE_FORMAT(invoices.created_at, '%m/%d/%Y') as invoice_date")
            ->join( "suppliers", "invoices.supplier_id = suppliers.id ")
            ->where(['invoices.id' => $invoiceId])
            ->distinct()
            ->find();

        $invoiceRowModel    = new \App\Models\InvoiceRowModel();
        $data["products"]   = $invoiceRowModel
            ->select( "invoice_rows.*, invoice_rows.id as row_id, products.*, brands.name as brand_name ")
            ->join( "products", "products.id = invoice_rows.product_id")
            ->join( "brands", "brands.id = products.brand_id")
            ->where(['invoice_id' => $invoiceId])
            ->find();

        print_r (  json_encode( $data ) );

    }

    public function ajaxUpdateInvoiceDiscount( $invoice_id )
    {

        $invoiceModel   = new InvoiceModel();
        $invoiceModel->update( $invoice_id, ["discount" => $this->request->getPost("discount")]);

        $this->calculateInvoiceSum ( $invoice_id );

        return print_R ( json_encode( $invoiceModel->where(['id' => $invoice_id ])->first() ) );

    }

    public function ajaxRemoveInvoiceProduct( $row_id )
    {

        $invoiceRowModel    = new InvoiceRowModel();
        $row                = $invoiceRowModel->find ( $row_id );
        $invoice_id         = $row ["invoice_id"];

        $invoiceRowModel->delete(['id' => $row_id]);

        $this->calculateInvoiceSum ( $invoice_id );

        $invoiceModel   = new InvoiceModel();
        $invoice        = $invoiceModel->where(['id' => $invoice_id ])->first();

        return print_R ( json_encode($invoice) );

    }

    private function calculateInvoiceSum ( $invoiceId ) {

        // get all products that exist in the invoice...

        $invoiceRowModel    = new InvoiceRowModel();
        $products           = $invoiceRowModel->where("invoice_id",  $invoiceId )->findAll( );

        $final_sum = 0;

        foreach ( $products as $product  ) {

            $product_sum = floatval( $product["wholesale_price"] ) *  floatval( $product["quantity"] );
            $product_sum -= floatval($product_sum * $product["discount"] / 100 );

            $final_sum += $product_sum;

        }

        // update the invoice cost's...
        $invoiceModel   = new \App\Models\InvoiceModel();
        $invoice        = $invoiceModel->where(['id' => $invoiceId])->first();

        $final_sum -= floatval( $final_sum * $invoice["discount"] / 100 );

        $invoiceModel->save ( ["id" => $invoiceId, "cost" => $final_sum]);

        return $final_sum;

    }


/*
    public function create ( $supplier_id ) {
        $invoiceModel   = new \App\Models\invoiceModel();
        $invoiceModel->insert( ['supplier_id' =>$supplier_id ]);
        return $invoiceModel->getInsertID();
    }*/



}
