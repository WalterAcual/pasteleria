<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\estadoFormRequest; //request validacion
use App\Models\estadomodelo;
use DB;

class estadoController extends Controller
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
            $estado =DB::table('estado')
            ->where('descripcionestado','LIKE', '%'.$query.'%')   
            ->orderBy('descripcionestado', 'asc')->paginate(10);
            return view ('catalogos.estado.index', ["estado"=>$estado, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("catalogos.estado.create");
    }

    //Guardar el objeto a BD para validar
    public function store(estadoFormRequest $request){
            //nuevo objeto
        $estadomodelo= new estadomodelo;
        $estadomodelo->descripcionestado=$request->get('descripcionestado');
        $estadomodelo->save(); //Guardar o almacenar
        return Redirect::to('catalogos/estado'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idestado){
        return view ('catalogos.estado.show', ["estado"=>estadomodelo::findorfail($idestado)]); //muestra por id de Categoria
    }

    public function edit($idestado){
        return view ('catalogos.estado.edit', ["estado"=>estadomodelo::findorfail($idestado)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(estadoFormRequest $request, $idestado){
        $estado=estadomodelo::findorfail($idestado);
        $estado->descripcionestado=$request->get('descripcionestado');
        $estado->update();
        return Redirect::to('catalogos/estado');
    }
     
    //Eliminar
    public function destroy($idestado){
        estadomodelo::destroy($idestado);    
        return Redirect('catalogos/estado');
    }

}