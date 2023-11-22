<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\pastelFormRequest; //request validacion
use App\Models\pastelmodelo;
use App\Models\categoriamodelo;
use App\Models\subcategoriamodelo;
use App\Models\pasteltatusModel;
use App\Models\pastelDetailStoreModel;

use DB;
use Carbon\Carbon;


class pastelController extends Controller
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
            $_categoria = trim($request->get('_categoria'));
            $_subcategoria = trim($request->get('_subcategoria'));
            $pastel = null;
            $pastel = DB::table('pastel')
            ->leftJoin('categoria','pastel.idcategoria', '=','categoria.idcategoria')
            ->leftJoin('subcategoria','pastel.idsubcategoria', '=','subcategoria.idsubcategoria')
            ->select('pastel.idpastel', 'pastel.ingrediente', 'pastel.descripcionpastel',
                    DB::raw('FORMAT(pastel.pcosto,2) as pcosto'),  DB::raw('FORMAT(pastel.pventa,2) as pventa'), 'pastel.stock', 'pastel.ventas', 'pastel.existencia', 'pastel.estado',
                    'pastel.idcategoria', 'categoria.descripcion', 'pastel.idsubcategoria', 
                    'subcategoria.descripcionsubcategoria', )
            ->where('pastel.descripcionpastel','LIKE', '%'.$query.'%')   
            ->where('pastel.estado','=', '1');
            if (!empty($_categoria)){
                $pastel = $pastel->whereRaw('pastel.idcategoria = '.$_categoria);
            } 
            if (!empty($_subcategoria)){
                $pastel = $pastel->whereRaw('pastel.idsubcategoria = '.$_subcategoria);
                dd("categoria ".$_subcategoria);
            }   
            $pastel = $pastel->orderBy('pastel.idpastel', 'asc')->paginate(10);
            return view ('cargadescarga.pastel.index', ["pastel"=>$pastel, "searchText"=>$query, "_categoria"=>$_categoria, "_subcategoria" =>$_subcategoria]);
        }
    }

    public function viewRender(Request $request)
    {
        $viewRender = view('viewRend')->render();
    return response()->json(array('success' => true, 'html'=>$viewRender));
    }

    public function create(){	
        return view("cargadescarga.pastel.create");
    }

    //Guardar el objeto a BD para validar
    public function store(pastelFormRequest $request){
        //nuevo objeto
        $pastelmodelo= new pastelmodelo;
        //$pastelmodelo->idpastel=$request->get('idpastel');
        $pastelmodelo->ingrediente=$request->get('ingrediente');
        $pastelmodelo->descripcionpastel=$request->get('descripcionpastel');
        $pastelmodelo->pcosto=$request->get('pcosto');
        $pastelmodelo->pventa=$request->get('pventa');
        $pastelmodelo->stock=$request->get('stock');
        $pastelmodelo->ventas=$request->get('ventas');
        $pastelmodelo->existencia=$request->get('existencia');
        $pastelmodelo->idcategoria=$request->get('idcategoria');
        $pastelmodelo->idsubcategoria=$request->get('idsubcategoria');
        $pastelmodelo->estado='1';
        $pastelmodelo->save(); //Guardar o almacenar
        $latestidpastel = $pastelmodelo->idpastel;
        $pathPhoto ='';
        if($request->hasFile('photo'))
        {
            $file=$request->file('photo');  //rutadonde movere      //metodo para poner nombre de archivo
            $file->move(public_path(). '/images/imagespastel/', $latestidpastel .'_'.  time() .'_'. $file->getClientOriginalName());
            $pathPhoto = '/images/imagespastel/'. $latestidpastel .'_'.  time() .'_'. $file->getClientOriginalName();
        }else{
            $pathPhoto ='';
        }
        DB::table('pastel')->where('idpastel', $latestidpastel)->update(array('photo' => $pathPhoto));  
        return Redirect::to('cargadescarga/pastel'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idpastel){
        return view ('cargadescarga.pastel.show', ["pastel"=>pastelmodelo::findorfail($idpastel)]); //muestra por id de Categoria
    }

    public function edit($idpastel){
        return view ('cargadescarga.pastel.edit', ["pastel"=>pastelmodelo::findorfail($idpastel)]);//paramtero recibido id
    }

   
    //Actualizar el objeto formulario
    public function update(pastelFormRequest $request, $idpastel){
        // dd($request->get('existencia'),$request->get('idcategoria'),$request->get('idsubcategoria'));
        // dd($request->get('idsubcategoria'));
        // die();
        $pastelmodelo=pastelmodelo::findorfail($idpastel);
        $pastelmodelo->ingrediente=$request->get('ingrediente');
        $pastelmodelo->descripcionpastel=$request->get('descripcionpastel');
        $pastelmodelo->pcosto=$request->get('pcosto');
        $pastelmodelo->pventa=$request->get('pventa');
        $pastelmodelo->stock=$request->get('stock');
        $pastelmodelo->ventas=$request->get('ventas');
        $pastelmodelo->existencia=$request->get('existencia');
        $pastelmodelo->idcategoria=$request->get('idcategoria');
        $pastelmodelo->idsubcategoria=$request->get('idsubcategoria');
        $pastelmodelo->estado='1';
       
        if($request->hasFile('photo'))
        {
            //$file->move(public_path(). '/images/imagespastel/', $idpastel .'_'.  time() .'_'. $file->getClientOriginalName());
            //$pastelmodelo->photo= '/images/imagespastel/'. $idpastel .'_'.  time() .'_'. $file->getClientOriginalName();
        }
        $pastelmodelo->update();
        return Redirect::to('cargadescarga/pastel');
    }
     
    //Eliminar
    public function destroy($idpastel){
        $estado = '0';
        DB::table('pastel')->where('idpastel', $idpastel)->update(array('estado' => $estado));  
        return Redirect('cargadescarga/pastel');
    }

    //Llena select o combo sub categorias
    public function getSubCategoria(Request $request){
        if(isset($request->texto)){
            $subCategorias = subcategoriamodelo::whereidcategoria($request->texto)->get();
            return response()->json(
                [
                    'lista' => $subCategorias,
                    'success' => true
                ]);
        }else{
            return response()->json(
            [
                'success' => false
            ]);
        }
        //return  view ('cargadescarga.pastel.create', compact("subcategorias"));
    }

    public function getSubCategoria1(Request $request){
        if($request->ajax()){
            $subCategoria = subCategoryModel::where('idcategoria', $request->idcategoria)->get();
            foreach($subCategoria as $subcategoria){
                $invSubCategoriesArray[$subcategoria->idsubcategoria] = $subcategoria->descripctionSubCategory;
            }
            return response()->json(invSubCategoriesArray);
        }
    }

    public function getSubCategoria2($idcategoria){
        $subcategoria =DB::table('subcategoria')
            ->where('idcategoria', '=', $idcategoria)
            ->orderBy('descripcion', 'asc')
            ->get();

        return response()->json(array('success' => true, 'data' => $subcategoria));
        }

        public function post(Request $request){
            $subcategoria = DB::table('subcategoria')
            ->leftJoin('categoria','subcategoria.idcategoria', '=','categoria.idcategoria')
            ->select('subcategoria.idcategoria', 'categoria.descripcion', 'subcategoria.idsubcategoria', 
            'subcategoria.descripcionsubcategoria')
            ->where('subcategoria.idcategoria','=', $request->message)   
            ->orderBy('subcategoria.descripcionsubcategoria', 'asc')
            ->get();

            $response = array(
                'status' => 'success',
                'lista' => $subcategoria,
            );
            return response()->json($response); 
         }

    }