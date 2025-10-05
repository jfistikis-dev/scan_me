<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CategoryController extends BaseController
{
    public function index()
    {
        //
        return $this->getCategoryList ();
    }

    public function store () {

        if (!$this->validate([
            'techniqueName' => 'required',
        ])) {
            return  $this->validator->getErrors() ;
        } else {


            $categoryModel = new \App\Models\CategoryModel();
            $recFound = $categoryModel->where ("name", $this->request->getVar('techniqueName') )->findAll();

            if ( empty ( $recFound )  ) { // this technique name not found so ... insert
                $categoryModel->insert( ["name" => $this->request->getVar('techniqueName') ]);
            }

            return $this->getCategoryList ();

        }

    }

    public function destroy () {

        if (!$this->validate([
            'categoryName' => 'required',
        ])) {
            return  $this->validator->getErrors() ;
        } else {

            $techniqueModel = new \App\Models\CategoryModel();
            $techniqueModel->where('name', $this->request->getVar('techniqueName') )->delete();

            return $this->getTechniqueList ();
        }
    }

    public function sort () {

        // a typical string would be .. :
        //item[]=8&item[]=1&item[]=10&item[]=7&item[]=9&item[]=11&item[]=12

        $sort           = explode("&", str_replace( "item[]=", "",  $this->request->getPost( "sortString"))) ;
        $techniqueModel  = new \App\Models\CategoryModel();

        for ( $i=0; $i < count ($sort); $i++ ) {
            $technique = $techniqueModel->find( $sort[ $i ] );

            $techniqueModel->save ( [
                "id"    => $technique['id'],
                'sort'  => $i,

            ] );
        }


        // return nothing ... sorting was performed!

    }

    public function search () {

        $categoryItemName   = $this->request->getVar("categoryName");

        $categoryModel      = new \App\Models\CategoryModel();
        $categoryRowModel  = new \App\Models\CategoryRowModel();
        $categories         = $categoryModel->findAll();

        if ( strlen(  $categoryItemName ) <= 0 ) {

            foreach ( $categories as $category ) {
                $result[ $category ['name']] = $categoryRowModel
                    ->select(["id", "name"])
                    ->where( "category_id", $category ['id'] )
                    ->orderBy("sort ASC" )
                    ->findAll();
            }

        }
        else {
            foreach ( $categories as $category ) {
                $result[ $category ['name']] = $categoryRowModel
                    ->select(["id", "name"])
                    ->where( "category_id", $category ['id'] )
                    ->like('name',  $categoryItemName )
                    ->orderBy("sort ASC" )
                    ->findAll();
            }

        }

        print_r(  json_encode( $result ) );
    }

    private function getCategoryList () {

        $categoryModel = new \App\Models\CategoryModel();
        print_r( json_encode( $categoryModel->select(["category_id", "name"])->orderBy("sort", "ASC")->findAll() ) );
    }
}
