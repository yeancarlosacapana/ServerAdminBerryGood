<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table 		= 	'categoria';
    protected $primaryKey	=	'cod_categoria' ;
    public $timestamps		=	false;

    public function parent()
    {
    	return $this->belongsTo(self::class,'id_parent');
    }
    public function children()
    {
    	return $this->hasMany(self::class,'id_parent');
    }
}
