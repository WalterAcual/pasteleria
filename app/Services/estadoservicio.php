<?php

namespace App\Services;

use App\Models\estadomodelo;

class estadoservicio
{
    public function get()
    {
        $estado = estadomodelo::get();
        $estadoArray[''] = 'Seleccionar';
        foreach ($estado as $tcargadescarga) {
            $estadoArray[$tcargadescarga->idestado] = $tcargadescarga->descripcionestado;
        }
        return $estadoArray;
    }
}