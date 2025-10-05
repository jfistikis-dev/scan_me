<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SupplierController extends BaseController
{
    public function index()
    {
        //
        return $this->getSupplierList ();
    }

    public function store () {

        if (!$this->validate([
            'supplierName' => 'required',
        ])) {
            return  $this->validator->getErrors() ;
        } else {

            $supplierModel = new \App\Models\SupplierModel();
            $recFound = $supplierModel->where ("name", $this->request->getVar('supplierName') )->findAll();

            if ( $recFound == null ) { // this supplier name not found so ... insert
                $supplierModel->insert( ["name" => $this->request->getVar('supplierName') ]);
            }

            return $this->getSupplierList ();

        }

    }

    public function destroy () {

        if (!$this->validate([
            'supplierName' => 'required',
        ])) {
            return  $this->validator->getErrors() ;
        } else {

            $supplierModel = new \App\Models\SupplierModel();
            $supplierModel->where('name', $this->request->getVar('supplierName') )->delete();

            return $this->getSupplierList ();
        }
    }

    public function sort () {

        // a typical string would be .. :
        //item[]=8&item[]=1&item[]=10&item[]=7&item[]=9&item[]=11&item[]=12

        $sort           = explode("&", str_replace( "item[]=", "",  $this->request->getPost( "sortString"))) ;
        $supplierModel  = new \App\Models\SupplierModel();

        for ( $i=0; $i < count ($sort); $i++ ) {
            $supplier = $supplierModel->find( $sort[ $i ] );

            $supplierModel->save ( [
                "id"    => $supplier['id'],
                'sort'  => $i,

            ] );
        }


        // return nothing ... sorting was performed!

    }

    public function search () {

        $supplierName = $this->request->getVar("supplierName");

        $supplierModel = new \App\Models\SupplierModel();
        if ( strlen( $supplierName ) <= 0 )
             print_r( json_encode( $supplierModel->select(["id", "name"])->orderBy("sort", "ASC")->findAll() ) );
        else print_r( json_encode( $supplierModel->select(["id", "name"])->like('name', $supplierName )->orderBy("sort", "ASC")->findAll() ) );
    }

    private function getSupplierList () {

        $supplierModel = new \App\Models\SupplierModel();
        print_r( json_encode( $supplierModel->select(["id", "name"])->orderBy("sort", "ASC")->findAll() ) );
    }


}
