<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table 		= 	'producto';
    protected $primaryKey	=	'cod_producto' ;
    public $timestamps		=	false;
}
