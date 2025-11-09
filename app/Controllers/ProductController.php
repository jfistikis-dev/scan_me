<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ProductLogModel;

class ProductController extends BaseController
{
    public function index()
    {
        //
    }


    public function ajaxBarcodeSearch () {

        $barcode = $this->request->getVar( "barcode" );
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


}
