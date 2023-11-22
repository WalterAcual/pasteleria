<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\tipocargadescargaController;

class tipocargadescargamodelo extends Model
{
    protected $table = 'tipocargadescarga';
    protected $fillabe = [
        'idtipocargadescarga',
        'descripciontipocargadescarga'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idtipocargadescarga';
}
