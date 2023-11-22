<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\Request;
use Illuminate\Validation\Rule;

class cargadescargadetalleFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'iddepartamento',
            'idcargadescarga'=> 'required',
            'idpastel'=> 'required',
            'cantidad', 
            'precio',
            'subtotal'
        ];
    }
}