<?php

namespace App\Services;

use App\Models\subcategoriamodelo;
use DB;

class segopcionServicio
{
    public function get($idrol)
    {
        $segopcionrol =DB::table('segopcion')->distinct()
        ->leftJoin('segopcionrol','segopcion.idopcion', '=','segopcionrol.idopcion')
        ->leftJoin('segmenu','segopcion.idmenu', '=','segmenu.idmenu')
        ->select('segopcionrol.idrol', 'segopcion.idmenu', 
                'segmenu.descripcionmenu', 'segmenu.iconomenu', 'segmenu.orden')
        ->where('segopcionrol.idrol','=', $idrol)  
        ->where('segopcion.estado','=', '1')
        ->orderBy('segmenu.orden', 'asc')->get();
        return $segopcionrol;
    }
}