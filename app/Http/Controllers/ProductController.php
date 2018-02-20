<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Config;
use App\Product;

use App\Imagen;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
    	$producto = DB::table('producto')
    	->leftjoin('categoria','producto.cod_categoria','categoria.cod_categoria')
        ->leftjoin('imagen','producto.cod_producto','imagen.cod_producto')
        ->select('producto.cod_producto',
                    'producto.desc_producto',
                    'producto.nombre_producto',
                    'producto.precio',
                    'producto.stock',
                    'producto.tiempo_entrega',
                    'categoria.cod_categoria',
                    'categoria.nombre_categoria',
                    'categoria.id_parent',
                    DB::raw('(select cod_imagen from imagen where cod_producto = producto.cod_producto limit 1) as id_image')
                )
    	->get();
        foreach ($producto as $key=>$item) {
                     $producto[$key]->url= Config::get('constants.images.url').$item->id_image.'.jpg';      
                    }
    	return response()->json($producto,200);
    }
    public function create()
    {

    }
    public function store(Request $request)
    {
    	$eProducto = $request;
    	$mProducto = new Product();
        $mProducto->nombre_producto = $eProducto["nombre_producto"];
    	$mProducto->tiempo_entrega = Carbon::now()->toDateString();
        $mProducto->desc_producto = $eProducto["desc_producto"];
        $mProducto->precio = $eProducto['precio'];
        $mProducto->stock = $eProducto['stock'];
        $mProducto->cod_categoria = $eProducto['cod_categoria'];
    	$mProducto->save();
        $sImage = $eProducto['imagen'];

        $this->addImage($sImage,$mProducto->cod_producto);
    	return response()->json($mProducto,200);
    }
    public function addImage($sImage,$cod_producto)
    {
        $mImage = new Imagen();
        $mImage->cod_producto = $cod_producto;
        $mImage->save();

        $file_name = $mImage->cod_imagen.'.jpg';
        @list($type, $sImage) = explode(';', $sImage);
            @list(, $sImage) = explode(',', $sImage); 
        if($sImage != ""){ // storing image in storage/app/public Folder 
                \Storage::disk('public')->put($file_name,base64_decode($sImage)); 
        }
        /*$this->fileSaveToStorage($sImage,$file_name);*/

    }
    public function show($id)
    {

    }
    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {
        $rProduct = $request;
        $product = Product::find($id);
        $product->nombre_producto = $rProduct["nombre_producto"];
        $product->precio = $rProduct['precio'];
        $product->stock = $rProduct['stock'];
        $product->cod_categoria = $rProduct['cod_categoria'];
        $product->desc_producto = $rProduct['desc_producto'];
        $product->tiempo_entrega = $rProduct['tiempo_entrega'];
        $product->save();

        Storage::delete($rProduct['id_image']+'.jpg');
        $file_name = $request['id_image'].'.jpg';
        @list($type, $request['imagen']) = explode(';', $request['imagen']);
            @list(, $request['imagen']) = explode(',', $request['imagen']); 
        if($request['imagen'] != ""){ // storing image in storage/app/public Folder 
                \Storage::disk('public')->put($file_name,base64_decode($request['imagen'])); 
        }
        /*$this->fileSaveToStorage($id,$file_name);*/

    }
    public function destroy($id)

    {
        
        
        $imagem = Imagen::where('cod_producto' ,'=', $id)->first();
        Storage::disk('public')->delete($imagem->cod_image +'.jpg');
        $imagem->delete();
        Product::destroy($id);
    }

    public function fileSaveToStorage($base64,$file_name)
    {
        
    }
}

