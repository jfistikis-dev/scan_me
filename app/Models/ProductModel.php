<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'products';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    //protected $returnType           =  \App\Entities\ProductEntity::class;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [

        "supplier_id","brand_id","categoryrow_id","description","barcode","stock",
        "wholesale_price","retail_price","wholesale_discount","discount_on_sales",
        "image","minimum_quantity", "reorder_quantity"

        ];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    public function saveProduct ( $productPostData ) {



        $invoiceType        = $productPostData[ "invoiceType"];
        

        if ( $invoiceType == 1) {
            if (!$this->validate([
                'barcode'           => "numeric",
                'supplier_id'       => 'required|numeric',
                'brand_id'          => 'required|numeric',
                'categoryrow_id'    => 'required|numeric',
                'description'       => 'required', // any other cuts the greek letters
                'retail_price'      => 'required|numeric',
                'minimum_quantity'  => 'required|numeric',
                'reorder_quantity'  => 'required|numeric',
                'stock'             => 'required|numeric'

            ])) {
                return ['errors' => $this->validator->getErrors()] ;
            }
        }

        if ( $invoiceType >= 2) {
            if (!$this->validate([
                'barcode'           => "numeric",
                'supplier_id'       => 'required|numeric',
                'brand_id'          => 'required|numeric',
                'categoryrow_id'    => 'required|numeric',
                'description'       => 'required', // any other cuts the greek letters
                'wholesale_price'   => 'required|numeric',
                'retail_price'      => 'required|numeric',
                'minimum_quantity'  => 'required|numeric',
                'reorder_quantity'  => 'required|numeric',
                'quantity'          => 'required|numeric',
                'stock'             => 'required|numeric'

            ])) {
                return ['errors' => $this->validator->getErrors()] ;
            }
        }


        if ( isset ($productPostData[ "product_id"]) )
             $product_id    = $productPostData[ "product_id"];
        else $product_id    = "";


        $barcode            = $productPostData["barcode"];
        $productModel       = new ProductModel();
        $product            = array (); // fill array according to fields of product model

        foreach ( $productModel->allowedFields as $productField ) {
            if ( isset ($productPostData[ $productField]) ) $product [ $productField ] = $productPostData[ $productField];
        }

        // create & save image!
        if ( isset ($productPostData['imageData']) && strlen ($productPostData['imageData']) > 3 ) {

            $imageData      = $productPostData['imageData'];
            $filePointer    = fopen("public/images/product/" . $barcode . ".png", 'wb');
            fwrite( $filePointer, base64_decode(substr($imageData, strpos($imageData, ",") + 1)));
            fclose( $filePointer );
        }

        // update image ...
        $product["image"]       = "public/images/product/" . $barcode . ".png";

        
		// update discount_on_sales ...
        if (  isset ($productPostData["discount_on_sales"]) && $productPostData["discount_on_sales"] != "") 
				$product["discount_on_sales"] =  "1"; 
		else 	$product["discount_on_sales"] =  "0";
		

        // we are updating an old product ?
        if ($product_id > 0) { $productModel->update($product_id, $product ); }

        // we are inserting a new product
        else {

            $productModel->insert( $product );
            $product_id =  $productModel->getInsertID();

        }

        return $product_id;
        
    }
}
