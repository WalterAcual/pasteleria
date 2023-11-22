<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\cargadescargaController;

class cargadescargadetallemodelo extends Model
{
    protected $table = 'cargadescargadetalle';
    protected $fillabe = [
        'idcargadescargadetalle',
        'idcargadescarga',
        'idpastel',
        'cantidad',
        'precio',
        'subtotal'
        ];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idcargadescargadetalle';

    Public function cargadescarga(){
        return $this->belongsTo('App\Models\cargadescargamodelo','idcargadescarga');
    }
    Public function pastel(){
        return $this->belongsTo('App\Models\pastelmodelo','idpastel');
    }
}