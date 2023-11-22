<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\Request;
use Illuminate\Validation\Rule;

class pastelFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ingrediente'=>'max:50' ,
            'descripcionpastel'=>'required', 'max:1500' ,
            'pcosto'=> 'required', 
            'pventa'=> 'required', 
            'idcategoria'=> 'required', //llave foranea
            'idsubcategoria', //llave foranea
            'estado',
        ];
    }
}