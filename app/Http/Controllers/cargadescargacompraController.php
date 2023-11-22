<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\cargadescargaFormRequest; //request validacion
use App\Models\cargadescargamodelo;
use App\Models\categoriamodelo;
use App\Models\subcategoriamodelo;

use DB;
use Carbon\Carbon;


class cargadescargacompraController extends Controller
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
            $_estado = trim($request->get('_estado'));
            $cargadescarga = null;
            $cargadescarga = DB::table('cargadescarga')
            ->leftJoin('tipocargadescarga','cargadescarga.idtipocargadescarga', '=','tipocargadescarga.idtipocargadescarga')
            ->leftJoin('estado','cargadescarga.idestado', '=','estado.idestado')
            ->leftJoin('cliente','cargadescarga.idcliente', '=','cliente.idcliente')
            ->select('cargadescarga.idcargadescarga', 'cargadescarga.fecha', DB::raw('FORMAT(cargadescarga.total,2) as total'),
                    'cargadescarga.idtipocargadescarga', 'tipocargadescarga.descripciontipocargadescarga', 'cargadescarga.idcliente','cliente.nombrecliente',
                    'cargadescarga.idestado', 'estado.descripcionestado')
            ->where('estado.descripcionestado','LIKE', '%'.$query.'%');
            if (!empty($_estado)){
                $cargadescarga = $cargadescarga->whereRaw('cargadescarga.idestado = '.$_estado);
            }   
            $cargadescarga->whereRaw('cargadescarga.idtipocargadescarga = 1');
            $cargadescarga = $cargadescarga->orderBy('cargadescarga.idcargadescarga', 'desc')->paginate(10);
            return view ('cargadescarga.cargadescargacompra.index', ["cargadescarga"=>$cargadescarga, "searchText"=>$query,  "_estado" =>$_estado]);
        }
    }

    public function viewRender(Request $request)
    {
        $viewRender = view('viewRend')->render();
    return response()->json(array('success' => true, 'html'=>$viewRender));
    }

    public function create(){	
        return view("cargadescarga.cargadescargacompra.create");
    }

    //Guardar el objeto a BD para validar
    public function store(cargadescargaFormRequest $request){
        //nuevo objeto
        $cargadescargamodelo= new cargadescargamodelo;
        //$cargadescargamodelo->iddepartamento="";
        $cargadescargamodelo->idtipocargadescarga="1";
        $cargadescargamodelo->idtipopago="1";
        //$cargadescargamodelo->idcliente="";
        $fechacargadescarga = date('Y/m/d');
        $cargadescargamodelo->fecha=$fechacargadescarga;
        $cargadescargamodelo->total="0.00";
        $cargadescargamodelo->idestado="1";
        $cargadescargamodelo->save(); //Guardar o almacenar
        return Redirect::to('cargadescarga/cargadescargacompra'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idcargadescarga){
        return view ('cargadescarga.cargadescargacompra.show', ["cargadescarga"=>cargadescargamodelo::findorfail($idcargadescarga)]); //muestra por id de Categoria
    }

    public function edit($idcargadescarga){
        return view ('cargadescarga.cargadescargacompra.edit', ["cargadescarga"=>cargadescargamodelo::findorfail($idcargadescarga)]);//paramtero recibido id
    }

   
    //Actualizar el objeto formulario
    public function update(cargadescargaFormRequest $request, $idcargadescarga){
        $cargadescargamodelo=cargadescargamodelo::findorfail($idcargadescarga);
        //$cargadescargamodelo->iddepartamento="";
        //$cargadescargamodelo->idtipocargadescarga="1";
        
        //$cargadescargamodelo->idcliente="";
        //$cargadescargamodelo->fecha=$request->get('fecha');
        $cargadescargamodelo->total=$request->get('total');
        $cargadescargamodelo->idestado=$request->get('idestado');
        $cargadescargamodelo->update();
        return Redirect::to('cargadescarga/cargadescargacompra');
    }
     
    //Eliminar
    public function destroy($idcargadescarga){
        $estado = '1';
        DB::table('cargadescarga')->where('idcargadescarga', $idcargadescarga)->update(array('idestado' => $estado));  
        return Redirect('cargadescarga/cargadescargacompra');
    }

    //Llena select o combo sub categorias
    public function getProveedor(Request $request){
        if(isset($request->texto)){
            $proveedor = proveedormodelo::whereidcategoria($request->texto)->get();
            return response()->json(
                [
                    'lista' => $proveedor,
                    'success' => true
                ]);
        }else{
            return response()->json(
            [
                'success' => false
            ]);
        }
    }

    
    }