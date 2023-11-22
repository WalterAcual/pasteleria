<?php

namespace App\Services;

use App\Models\tipocargadescargamodelo;

class tipocargadescargaservicio
{
    public function get()
    {
        $tipocargadescarga = tipocargadescargamodelo::get();
        $tipocargadescargaArray[''] = 'Seleccionar';
        foreach ($tipocargadescarga as $tcargadescarga) {
            $tipocargadescargaArray[$tcargadescarga->idcategoria] = $tcargadescarga->descripciontipocargadescarga;
        }
        return $tipocargadescargaArray;
    }
}