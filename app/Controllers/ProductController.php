<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProductController extends BaseController
{
    public function index()
    {
        //
    }

// generate a barcode based on existing supplier and his brand
    public function ajaxBarcodeCreate () {


        $country = "99";    // an imaginary country
        $manufct = "12345"; // an imaginary manufacturer

        //search db for the our last assigned barcode
        $productModel  = new \App\Models\ProductModel();
        $product        = $productModel
            ->like('barcode',  "99", "after")
            ->orderBy('barcode', 'DESC')
            ->first();

        $finalNum = "";

        if ($product == null) { $finalNum = '00000'; }
        else {

            // since barcode start with 99 .. it's our barcode! an EAN type!
            // increment barcode by one!

            $number = str_split( substr( $product['barcode'], 7, 5) );
            // advance by one


            for ( $i = 4; $i >= 0 ; $i-- ) {
                if ( $i== 4 ) $number[ $i ] = intval( $number[ $i ] ) + 1;

                if ( intval( $number[ $i ] ) >= 10 ) {
                    $number[ $i ] = 0;
                    $number[ ($i-1) ] = intval( $number[ ($i-1) ] ) + 1;
                }
                $finalNum = $number[ $i ] . $finalNum;
            }
        }
        // construct the barcode without the last digit ( checkbit!)
        $finalNum = $country . $manufct . $finalNum;

        //------------------- CALCULATING LAST DIGIT OF EAN CODE ----------------
        $odd_sum    = $finalNum[0] + $finalNum[2] + $finalNum[4] + $finalNum[6] + $finalNum[8] + $finalNum[10];
        $even_sum   = $finalNum[1] + $finalNum[3] + $finalNum[5] + $finalNum[7] + $finalNum[9] + $finalNum[11];
        $even_sum   *= 3;
        $total_sum  = $even_sum + $odd_sum;
        $next_ten   = (ceil($total_sum/10))*10;
        $digit      = $next_ten - $total_sum;
        //------------------------------------------------------------------------
        return $finalNum . $digit ;

    }

    public function ajaxBarcodeSearch ( $barcode ) {


        $productModel   = new \App\Models\ProductModel();
        $product        = $productModel
            ->select( "products.*, products.id as product_id, suppliers.id as supplier_id, suppliers.name as supplier, brands.name as brand, brands.id as brand_id, category_rows.name as categoryItem")
            ->where("barcode", $barcode)
            ->join ( "suppliers", "products.supplier_id = suppliers.id" )
            ->join ( "brands", "products.brand_id = brands.id" )
            ->join ( "category_rows", "products.categoryrow_id = category_rows.id" )
            ->first();

        if ($product == null) { return null; }
        else { print_R ( json_encode( ( $product ) ) );  }


    }

    public function ajaxAutocompleteSearch ( ) {

        $search_string = $this->request->getVar("term") ;
        $productModel  = new \App\Models\ProductModel();
        $products      = $productModel
            ->like('description', $search_string )
            ->orderBy('description', 'ASC')
            ->findAll();

        $output = array();
        if ( !empty($products  ) ) {
            foreach ( $products as $product ) {


                $temp_array = array();
                $temp_array['value'] =  $product['description'];
                $temp_array['label'] = '<img class="img-thumbnail" src="'. base_url( $product['image'] ).'" width="120" />'.$product['description'];
                $output[] = $temp_array;
            }
        }
        else {
            $output['value'] = '';
            $output['label'] = 'Δεν βρέθηκαν αρχεία ';
        }

        print_R ( json_encode($output) );
    }




}
