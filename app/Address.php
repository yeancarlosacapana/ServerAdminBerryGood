<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table 		= 	'direccion';
    protected $primaryKey	=	'cod_distrito' ;
    public $timestamps		=	false;

}
