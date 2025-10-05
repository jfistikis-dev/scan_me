<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SalesModel;
use App\Models\SalesRowModel;

class SalesController extends BaseController
{
	public function index()
	{
		//
		return view('salesMainScreen');
		
	}

	public function store () {

        $salesItems = json_decode( $this->request->getPost( "salesItems"), true ); // true as array
        $salesTotal = json_decode( $this->request->getPost( "salesTotal") );



        $salesModel = new SalesModel();
        $salesModel->insert([
            "user_id"       => 0,
            "customer_id"   => 0,
            "payment_id"    => 0,
            "sum"           => $salesTotal
        ]);

        $sales_id   = $salesModel->getInsertID();

        $salesRowModel  = new SalesRowModel();

        foreach ($salesItems as $salesItem ) {
            $salesRowModel->insert ([

                "sales_id"      => $sales_id,
                "product_id"    => $salesItem['product_id'],
                "quantity"      => $salesItem['quantity'],
                "price"         => $salesItem['price'],
                "sum"           => $salesItem['sum']

            ]);
        }
        echo "1";


    }
}
