<?php

namespace App\Services;

use App\Models\subcategoriamodelo;
use DB;

class segopcionrolRolServicio
{
    public function get($idrol,$idmenu)
    {
        $segopcionrol =DB::table('segopcionrol')
        ->leftJoin('segrol','segopcionrol.idrol', '=','segrol.idrol')
        ->leftJoin('segopcion','segopcionrol.idopcion', '=','segopcion.idopcion')
        ->leftJoin('segmenu','segopcion.idmenu', '=','segmenu.idmenu')
        ->select('segopcionrol.idopcionrol', 'segopcionrol.idrol', 'segrol.descripcionrol',
                'segopcionrol.idopcion', 'segopcion.descripcionopcion', 
                'segopcion.ruta','segopcion.iconoopcion', 'segopcionrol.estado',
                'segopcion.idmenu', 'segmenu.descripcionmenu','segmenu.iconomenu')
        ->where('segopcionrol.idrol','=', $idrol)  
        ->where('segopcion.idmenu','=', $idmenu)  
        ->where('segopcionrol.estado','=', '1')
        ->orderBy('segmenu.orden', 'asc')->get();
        return $segopcionrol;
    }
}