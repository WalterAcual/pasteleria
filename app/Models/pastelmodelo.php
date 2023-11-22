<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\pastelController;

class pastelmodelo extends Model
{
    protected $table = 'pastel';
    protected $fillabe = [
        'idpastel',
        'ingrediente',
        'descripcionpastel',
        'pcosto',
        'pventa',
        'stock',
        'ventas',
        'existencia',
        'photo',
        'idcategoria',
        'idsubcategoria',
        'estado',
        ];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idpastel';

    Public function category(){
        return $this->belongsTo('App\Models\categoriamodelo','idcategoria');
    }
    Public function subcategory(){
        return $this->belongsTo('App\Models\subcategoriamodelo','idsubcategoria');
    }
}