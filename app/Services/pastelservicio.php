<?php

namespace App\Services;

use App\Models\pastelmodelo;

class pastelservicio
{
    public function get()
    {
        $pastelmodelo = pastelmodelo::where('pastel.estado','=', '1')->get();
        $pastelArray[''] = 'Seleccionar';
        foreach ($pastelmodelo as $product) {
            $pastelArray[$product->idpastel] = $product->descripcionpastel;
        }
        return $pastelArray;
    }
}