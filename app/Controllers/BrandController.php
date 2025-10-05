<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BrandController extends BaseController
{
    public function index( $supplier_id )
    {
        //
        return $this->getBrandList ( $supplier_id );
    }

    public function store ( $supplier_id  ) {

        if (!$this->validate([

            'brandName'     => 'required|alpha_numeric_space',
        ])) {
            print_r ( $this->validator->getErrors() );
        } else {


            $brandModel = new \App\Models\BrandModel();
            $recFound = $brandModel->where ("name", $this->request->getVar('brandName') )->where("supplier_id", $this->request->getVar('supplier_id'))->findAll();

            if ( empty ( $recFound )  ) { // this brand name not found so ... insert
                $brandModel->insert( ["name" => $this->request->getVar('brandName'), "supplier_id" =>  $supplier_id ]);
            }

            return $this->getBrandList ( $supplier_id );

        }

    }

    public function destroy ( $supplier_id ) {

        if (!$this->validate([
            'brandName' => 'required',
        ])) {
            return  $this->validator->getErrors() ;
        } else {

            $brandModel = new \App\Models\BrandModel();
            $brandModel->where('name', $this->request->getVar('brandName') )->delete();

            return $this->getBrandList ( $supplier_id );
        }
    }

    public function sort () {

        // a typical string would be .. :
        //item[]=8&item[]=1&item[]=10&item[]=7&item[]=9&item[]=11&item[]=12

        $sort           = explode("&", str_replace( "brand[]=", "",  $this->request->getPost( "sortString"))) ;
        $brandModel  = new \App\Models\BrandModel();

        for ( $i=0; $i < count ($sort); $i++ ) {
            $brand = $brandModel->find( $sort[ $i ] );

            $brandModel->save ( [
                "id"    => $brand['id'],
                'sort'  => $i,

            ] );
        }


        // return nothing ... sorting was performed!

    }

    private function getBrandList ( $supplier_id ) {

        $brandModel = new \App\Models\BrandModel();
        print_r( json_encode( $brandModel->select(["id", "name"])->where("supplier_id", $supplier_id)->orderBy("sort", "ASC")->findAll() ) );
    }
}
