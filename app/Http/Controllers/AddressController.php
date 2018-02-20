<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use DB;

class AddressController extends Controller
{
    public function index()
    {
    	$distrito = DB::table('direccion')
    	->get();
    	return response()->json($distrito,200);
    }
    public function create()
    {

    }
    public function store(Request $request)
    {
    	$eDistrito = $request ;
    	$mDistrito = new Address();
    	$mDistrito->nombre_distrito = $eDistrito["nombre_distrito"] ;
    	$mDistrito->costo_envio = $eDistrito["costo_envio"];
    	$mDistrito->habilitado = 'A';
    	$mDistrito->save();

    	return response()->json($mDistrito,200);
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
    	Address::destroy($id);   	
    }
}
