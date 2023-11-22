<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\tipocargadescargaFormRequest; //request validacion
use App\Models\tipocargadescargamodelo;
use DB;

class tipocargadescargaController extends Controller
{
    //Valida usuario logueado
    public function __construct()
    {
        $this -> middleware('auth'); //redirecciona a Login
    }

    //Consulta
    public function index(Request $request){
        if ($request){  
            $query = trim($request->get('searchText'));
            $tipocargadescarga =DB::table('tipocargadescarga')
            ->where('descripciontipocargadescarga','LIKE', '%'.$query.'%')   
            ->orderBy('descripciontipocargadescarga', 'asc')->paginate(10);
            return view ('catalogos.tipocargadescarga.index', ["tipocargadescarga"=>$tipocargadescarga, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("catalogos.tipocargadescarga.create");
    }

    //Guardar el objeto a BD para validar
    public function store(tipocargadescargaFormRequest $request){
            //nuevo objeto
        $tipocargadescargamodelo= new tipocargadescargamodelo;
        $tipocargadescargamodelo->descripciontipocargadescarga=$request->get('descripciontipocargadescarga');
        $tipocargadescargamodelo->save(); //Guardar o almacenar
        return Redirect::to('catalogos/tipocargadescarga'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idtipocargadescarga){
        return view ('catalogos.tipocargadescarga.show', ["tipocargadescarga"=>tipocargadescargamodelo::findorfail($idtipocargadescarga)]); //muestra por id de Categoria
    }

    public function edit($idtipocargadescarga){
        return view ('catalogos.tipocargadescarga.edit', ["tipocargadescarga"=>tipocargadescargamodelo::findorfail($idtipocargadescarga)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(tipocargadescargaFormRequest $request, $idtipocargadescarga){
        $tipocargadescarga=tipocargadescargamodelo::findorfail($idtipocargadescarga);
        $tipocargadescarga->descripciontipocargadescarga=$request->get('descripciontipocargadescarga');
        $tipocargadescarga->update();
        return Redirect::to('catalogos/tipocargadescarga');
    }
     
    //Eliminar
    public function destroy($idtipocargadescarga){
        tipocargadescargamodelo::destroy($idtipocargadescarga);    
        return Redirect('catalogos/tipocargadescarga');
    }

}