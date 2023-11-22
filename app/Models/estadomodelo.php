<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\estadoController;

class estadomodelo extends Model
{
    protected $table = 'estado';
    protected $fillabe = [
        'idestado',
        'descripcionestado'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idestado';
}
