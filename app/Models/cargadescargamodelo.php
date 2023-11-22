<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\cargadescargaController;

class cargadescargamodelo extends Model
{
    protected $table = 'cargadescarga';
    protected $fillabe = [
        'idcargadescarga',
        'idtipocargadescarga',
        'idcliente',
        'fecha',
        'total',
        'idestado'
        ];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idtipocargadescarga';

    Public function cliente(){
        return $this->belongsTo('App\Models\clientemodelo','idcliente');
    }
    Public function tipocargadescarga(){
        return $this->belongsTo('App\Models\tipocargadescargaamodelo','idtipocargadescarga');
    }
    Public function estado(){
        return $this->belongsTo('App\Models\estadomodelo','idestado');
    }
}