<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Category;
use App\SubCategory;
class CategoryController extends Controller
{
   public function index()
    {
    	$category = Category::with('children')
   		->get();

    	return response()->json($category,200);
    }
    public function create()
    {

    }
    public function store(Request $request)
    {
    	
    	$eCategoria = $request;
		$mCategoria = new Category();
		$mCategoria->nombre_categoria = $eCategoria["nombre_categoria"];
		$mCategoria->id_parent = $eCategoria["id_parent"];
		$mCategoria->save();	
    	

    	return response()->json($mCategoria,200);
    }
    public function show($id)
    {

    }
    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {

    }
    public function destroy($id)

    {
    	
    }
}
