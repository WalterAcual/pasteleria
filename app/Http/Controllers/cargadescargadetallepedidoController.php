<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\cargadescargadetalleFormRequest; //request validacion
use App\Models\cargadescargadetallemodelo;
use App\Models\cargadescargamodelo;
use App\Models\pastelmodelo;

use DB;
use Carbon\Carbon;


class cargadescargadetallepedidoController extends Controller
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
            $_pastel = trim($request->get('_pastel'));
            $cargadescargadetalle = null;
            $cargadescargadetalle = DB::table('cargadescargadetalle')
            ->leftJoin('pastel','cargadescargadetalle.idpastel', '=','pastel.idpastel')
            ->select('cargadescargadetalle.idcargadescargadetalle', 'cargadescargadetalle.idcargadescarga', 'cargadescargadetalle.idpastel',
                    'pastel.descripcionpastel', 'cargadescargadetalle.cantidad', 'cargadescargadetalle.precio', 'cargadescargadetalle.subtotal')
            ->where('pastel.descripcionpastel','LIKE', '%'.$query.'%');
            if (!empty($_pastel)){
                $cargadescargadetalle = $cargadescargadetalle->whereRaw('cargadescargadetalle.idpastel = '.$_pastel);
            }  
            $cargadescargadetalle = $cargadescargadetalle->orderBy('cargadescargadetalle.idpastel', 'asc')->paginate(10);
            return view ('cargadescarga.cargadescargadetalle.index', ["cargadescargadetalle"=>$cargadescargadetalle, "searchText"=>$query, "_pastel"=>$_pastel]);
        }
    }

    public function viewRender(Request $request)
    {
        $viewRender = view('viewRend')->render();
    return response()->json(array('success' => true, 'html'=>$viewRender));
    }

    public function create(){	
        return view("cargadescarga.cargadescargadetalle.create");
    }

    //Guardar el objeto a BD para validar
    public function store(cargadescargadetalleFormRequest $request){
        //nuevo objeto
        $cargadescargadetallemodelo= new cargadescargadetallemodelo;
        $cargadescargadetallemodelo->idcargadescarga=$request->get('idcargadescarga');
        $cargadescargadetallemodelo->idpastel=$request->get('idpastel');
        $cargadescargadetallemodelo->cantidad=$request->get('cantidad');
        $cargadescargadetallemodelo->precio=$request->get('precio');
        $cargadescargadetallemodelo->subtotal=$request->get('subtotal');
        $cargadescargadetallemodelo->save(); //Guardar o almacenar
        return Redirect::to('cargadescarga/cargadescargadetalle'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idcargadescargadetalle){
        return view ('cargadescarga.cargadescargadetalle.show', ["cargadescargadetalle"=>cargadescargadetallemodelo::findorfail($idcargadescargadetalle)]); //muestra por id de Categoria
    }
   
    //Actualizar el objeto formulario
    public function update(cargadescargaFormRequest $request, $idcargadescargadetalle){
        $cargadescargadetallemodelo=cargadescargadetallemodelo::findorfail($idcargadescargadetalle);
        $cargadescargadetallemodelo->idcargadescarga=$request->get('idcargadescarga');
        $cargadescargadetallemodelo->idpastel=$request->get('idpastel');
        $cargadescargadetallemodelo->cantidad=$request->get('cantidad');
        $cargadescargadetallemodelo->precio=$request->get('precio');
        $cargadescargadetallemodelo->subtotal=$request->get('subtotal');
        $cargadescargadetallemodelo->update();
        return Redirect::to('cargadescarga/cargadescargadetalle');
    }
     
    //Eliminar
    public function destroy($idcargadescargadetalle){
        cargadescargadetallemodelo::destroy($idcargadescargadetalle);    
        return Redirect('cargadescarga/cargadescargadetalle');
    }

    //Llena select o combo pastel
    public function getpastel(Request $request){
        if(isset($request->texto)){
            $pastel = pastelmodelo::whereidpastel($request->texto)->get();
            return response()->json(
                [
                    'lista' => $pastel,
                    'success' => true
                ]);
        }else{
            return response()->json(
            [
                'success' => false
            ]);
        }
    }



    public function edit(Request $request){
        $cargadescargadetallemodelo = new cargadescargadetallemodelo;
        //dd($request->get('idcargadescarga'));
        $idcargadescarga = $request->get('idcargadescarga');
        $cargadescargadetallemodelo->idcargadescarga=$request->get('idcargadescarga');
        $cargadescargadetallemodelo->idpastel=$request->get('idpastel');
        $cargadescargadetallemodelo->cantidad=$request->get('cantidad');
        $cargadescargadetallemodelo->precio=$request->get('precio');
        $cargadescargadetallemodelo->subtotal=$request->get('subtotal');
        $cargadescargadetallemodelo->save(); //Guardar o almacenar
        

        $cargadescargadetalle = null;
        $cargadescargadetalle = DB::table('cargadescargadetalle')
        ->leftJoin('pastel','cargadescargadetalle.idpastel', '=','pastel.idpastel')
        ->leftJoin('cargadescarga','cargadescargadetalle.idcargadescarga', '=','cargadescarga.idcargadescarga')
        
        ->leftJoin('cliente','cargadescarga.idcliente', '=','cliente.idcliente')
        ->select('cargadescargadetalle.idcargadescargadetalle', 'cargadescargadetalle.idcargadescarga', 'cargadescargadetalle.idpastel',
                'pastel.descripcionpastel', 'cargadescargadetalle.cantidad', 'cargadescargadetalle.precio', 
                'cargadescargadetalle.subtotal', DB::raw('DATE_FORMAT(cargadescarga.fecha, "%d/%m/%Y") AS fecha'), 
                'cargadescarga.idestado', 'cliente.nombrecliente')
        ->where('cargadescargadetalle.idcargadescarga','=', $idcargadescarga);
        $cargadescargadetalle = $cargadescargadetalle->orderBy('cargadescargadetalle.idpastel', 'asc')->paginate(10);

        $fechacargadescarga = '';
        $message = ''; 
        $nombreproveedor = "";
        $nombrecliente = "";
        $idestado = 0;
        foreach ($cargadescargadetalle as $detalle) {
            $fechacargadescarga =  $detalle->fecha;
           
            $idestado =  $detalle->idestado;
            $nombrecliente =  $detalle->nombrecliente;

        }
        $msgbox = '';
        $data = array(
            'fechacargadescarga'=>$fechacargadescarga,
            'idcargadescarga'=>$idcargadescarga,
            'idestado'=> $idestado,
            'nombrecliente'=> $nombrecliente,
        ); 
        
        return view ('cargadescarga.cargadescargapedido.listacargadescargadetallepedido', ["cargadescargadetalle"=>$cargadescargadetalle, "searchText" =>$idcargadescarga])->with($data);
    }

    //BORRAR DETALLE DE COMPRA
    public function borrardetalleventa(Request $request){
        $cargadescargadetallemodelo = new cargadescargadetallemodelo;
        $idcargadescargadetalle=$request->get('idcargadescargadetalle');
        $cargadescargadetallemodelo = cargadescargadetallemodelo::find($idcargadescargadetalle); 
        $cargadescargadetallemodelo->delete();

        $cargadescargadetalle = null;
        $cargadescargadetalle = DB::table('cargadescargadetalle')
        ->leftJoin('pastel','cargadescargadetalle.idpastel', '=','pastel.idpastel')
        ->leftJoin('cargadescarga','cargadescargadetalle.idcargadescarga', '=','cargadescarga.idcargadescarga')
        
        ->leftJoin('cliente','cargadescarga.idcliente', '=','cliente.idcliente')
        ->select('cargadescargadetalle.idcargadescargadetalle', 'cargadescargadetalle.idcargadescarga', 'cargadescargadetalle.idpastel',
                'pastel.descripcionpastel', 'cargadescargadetalle.cantidad', 'cargadescargadetalle.precio', 
                'cargadescargadetalle.subtotal', DB::raw('DATE_FORMAT(cargadescarga.fecha, "%d/%m/%Y") AS fecha'), 
                'cargadescarga.idestado', 'cliente.nombrecliente')
        ->where('cargadescargadetalle.idcargadescarga','=', $idcargadescarga);
        $cargadescargadetalle = $cargadescargadetalle->orderBy('cargadescargadetalle.idpastel', 'asc')->paginate(10);

        $fechacargadescarga = '';
        $message = ''; 
        $nombreproveedor = "";
        $nombrecliente = "";
        $idestado = 0;
        foreach ($cargadescargadetalle as $detalle) {
            $fechacargadescarga =  $detalle->fecha;
           
            $idestado =  $detalle->idestado;
            $nombrecliente =  $detalle->nombrecliente;

        }
        $msgbox = '';
        $data = array(
            'fechacargadescarga'=>$fechacargadescarga,
            'idcargadescarga'=>$idcargadescarga,
            'msg'=> $msgbox,
            'idestado'=> $idestado,
            'nombrecliente'=> $nombrecliente,
        );
        
        return view ('cargadescarga.cargadescargapedido.listacargadescargadetallepedido', ["cargadescargadetalle"=>$cargadescargadetalle, "searchText" =>$idcargadescarga])->with($data);
    }

    public function cargadescargadetalledataventa($idcargadescarga){
        //dd($idcargadescarga);
        if (isset($idcargadescarga)){  
            $cargadescargadetalle = null;
            $cargadescargadetalle = DB::table('cargadescargadetalle')
            ->leftJoin('pastel','cargadescargadetalle.idpastel', '=','pastel.idpastel')
            ->leftJoin('cargadescarga','cargadescargadetalle.idcargadescarga', '=','cargadescarga.idcargadescarga')
            
            ->leftJoin('cliente','cargadescarga.idcliente', '=','cliente.idcliente')
            ->select('cargadescargadetalle.idcargadescargadetalle', 'cargadescargadetalle.idcargadescarga', 'cargadescargadetalle.idpastel',
                    'pastel.descripcionpastel', 'cargadescargadetalle.cantidad', 'cargadescargadetalle.precio', 
                    'cargadescargadetalle.subtotal', DB::raw('DATE_FORMAT(cargadescarga.fecha, "%d/%m/%Y") AS fecha'), 
                    'cargadescarga.idestado', 'cliente.nombrecliente')
            ->where('cargadescargadetalle.idcargadescarga','=', $idcargadescarga);
            $cargadescargadetalle = $cargadescargadetalle->orderBy('cargadescargadetalle.idpastel', 'asc')->paginate(10);
            
            $cargadescarga = null;
            $cargadescarga = DB::table('cargadescarga')
            
            ->leftJoin('cliente','cargadescarga.idcliente', '=','cliente.idcliente')
            
            ->leftJoin('tipocargadescarga','cargadescarga.idtipocargadescarga', '=','tipocargadescarga.idtipocargadescarga')
            ->leftJoin('estado','cargadescarga.idestado', '=','estado.idestado')
            ->select('cargadescarga.idcargadescarga', 'cargadescarga.fecha', 'cargadescarga.total',
                
                'cargadescarga.idtipocargadescarga', 'tipocargadescarga.descripciontipocargadescarga',
                'cargadescarga.idestado', 'estado.descripcionestado','cliente.nombrecliente')
            ->where('cargadescarga.idcargadescarga','=', $idcargadescarga);
            $cargadescarga = $cargadescarga->orderBy('cargadescarga.idtipocargadescarga', 'asc')->paginate(10);
            
    
            $fechacargadescarga = '';
            $message = ''; 
            $nombreproveedor = "";
            $nombrecliente = "";
            $idestado = 0;
            foreach ($cargadescarga as $detalle) {
                $fechacargadescarga =  $detalle->fecha;
                $idestado =  $detalle->idestado;
                $nombrecliente =  $detalle->nombrecliente;
            }
            $msgbox = '';
            $data = array(
                'fechacargadescarga'=>$fechacargadescarga,
                'idcargadescarga'=>$idcargadescarga,
                'idestado'=> $idestado,
                'nombrecliente'=> $nombrecliente,
            );
            //return Redirect::to('cargadescarga/cargadescargacompra/listacargadescargadetallecompra/'.$idcargadescarga);
            return view ('cargadescarga.cargadescargapedido.listacargadescargadetallepedido', ["cargadescargadetalle"=>$cargadescargadetalle, "searchText" =>$idcargadescarga])->with($data);
        }
    }

    public function cargadescargadetalledataventaedit($idcargadescarga){
        //dd($idcargadescarga);
        if (isset($idcargadescarga)){  
            $cargadescargadetalle = null;
            $cargadescargadetalle = DB::table('cargadescargadetalle')
            ->leftJoin('pastel','cargadescargadetalle.idpastel', '=','pastel.idpastel')
            ->leftJoin('cargadescarga','cargadescargadetalle.idcargadescarga', '=','cargadescarga.idcargadescarga')
            
            ->leftJoin('cliente','cargadescarga.idcliente', '=','cliente.idcliente')
            ->select('cargadescargadetalle.idcargadescargadetalle', 'cargadescargadetalle.idcargadescarga', 'cargadescargadetalle.idpastel',
                    'pastel.descripcionpastel', 'cargadescargadetalle.cantidad', 'cargadescargadetalle.precio', 
                    'cargadescargadetalle.subtotal', DB::raw('DATE_FORMAT(cargadescarga.fecha, "%d/%m/%Y") AS fecha'), 
                    'cargadescarga.idestado', 'cliente.nombrecliente')
            ->where('cargadescargadetalle.idcargadescarga','=', $idcargadescarga);
            $cargadescargadetalle = $cargadescargadetalle->orderBy('cargadescargadetalle.idpastel', 'asc')->paginate(10);
    
            $fechacargadescarga = '';
            $message = ''; 
            $nombreproveedor = "";
            $nombrecliente = "";
            $idestado = 0;
            foreach ($cargadescargadetalle as $detalle) {
                $fechacargadescarga =  $detalle->fecha;
                $idestado =  $detalle->idestado;
                $nombrecliente =  $detalle->nombrecliente;
            }
            $msgbox = '';
            $data = array(
                'fechacargadescarga'=>$fechacargadescarga,
                'idcargadescarga'=>$idcargadescarga,
                'idestado'=> $idestado,
                'nombrecliente'=> $nombrecliente,
            );
            //return Redirect::to('cargadescarga/cargadescargacompra/listacargadescargadetallecompra/'.$idcargadescarga);
            return view ('cargadescarga.cargadescargapedido.listacargadescargadetallepedido', ["cargadescargadetalle"=>$cargadescargadetalle, "searchText" =>$idcargadescarga])->with($data);
        }
    }

    public function agregardetalleventa(Request $request){
        $cargadescargadetallemodelo = new cargadescargadetallemodelo;
        //dd($request->get('idcargadescarga'));
        $idcargadescarga = $request->get('idcargadescarga');
        $cargadescargadetallemodelo->idcargadescarga=$request->get('idcargadescarga');
        $cargadescargadetallemodelo->idpastel=$request->get('idpastel');
        $cargadescargadetallemodelo->cantidad=$request->get('cantidad');
        $idprodu=$request->get('idpastel');
        $pastel = DB::table('pastel')
        ->select('pastel.idpastel', 'pastel.ingrediente', 'pastel.descripcionpastel',
                'pastel.pcosto', 'pastel.pventa', 'pastel.stock', 'pastel.ventas', 'pastel.existencia', 'pastel.estado')
        ->where('pastel.idpastel','=', $idprodu)->get();
        $pventa = 0;
        $subtotal = 0;
        foreach ($pastel as $prodd) {
            $pventa =  $prodd->pventa;
        }
        $cantidad = $request->get('cantidad');
        $subtotal = $pventa * $cantidad;
        $cargadescargadetallemodelo->precio=$pventa;
        $cargadescargadetallemodelo->subtotal=$subtotal;
        $cargadescargadetallemodelo->save(); //Guardar o almacenar
        return Redirect::to('cargadescarga/cargadescargadetallepedido'); //retorna al usuario a listado de grados a URL	

        $responseData = array(
            'status' => 'success',
            'lista' => $idcargadescarga,
        );

        $cargadescargadetalle = null;
        $cargadescargadetalle = DB::table('cargadescargadetalle')
        ->leftJoin('pastel','cargadescargadetalle.idpastel', '=','pastel.idpastel')
        ->leftJoin('cargadescarga','cargadescargadetalle.idcargadescarga', '=','cargadescarga.idcargadescarga')
        
        ->leftJoin('cliente','cargadescarga.idcliente', '=','cliente.idcliente')
        ->select('cargadescargadetalle.idcargadescargadetalle', 'cargadescargadetalle.idcargadescarga', 'cargadescargadetalle.idpastel',
                'pastel.descripcionpastel', 'cargadescargadetalle.cantidad', 'cargadescargadetalle.precio', 
                'cargadescargadetalle.subtotal', DB::raw('DATE_FORMAT(cargadescarga.fecha, "%d/%m/%Y") AS fecha'), 
                'cargadescarga.idestado', 'cliente.nombrecliente')
        ->where('cargadescargadetalle.idcargadescarga','=', $idcargadescarga);
        $cargadescargadetalle = $cargadescargadetalle->orderBy('cargadescargadetalle.idpastel', 'asc')->paginate(10);
        $fechacargadescarga = '';
            $message = ''; 
            $nombreproveedor = "";
            $nombrecliente = "";
            $idestado = 0;
            foreach ($cargadescargadetalle as $detalle) {
                $fechacargadescarga =  $detalle->fecha;
                $idestado =  $detalle->idestado;
                $nombrecliente =  $detalle->nombrecliente;
            }
            $msgbox = '';
            $data = array(
                'fechacargadescarga'=>$fechacargadescarga,
                'idcargadescarga'=>$idcargadescarga,
                'idestado'=> $idestado,
                'nombrecliente'=> $nombrecliente,
            );
        return view ('cargadescarga.cargadescargapedido.listacargadescargadetallepedido', ["cargadescargadetalle"=>$cargadescargadetalle, "searchText" =>$idcargadescarga])->with($data);
     }

    //APLICAR DETALLE DE COMPRA
    public function aplicarventa(Request $request){
        $idcargadescarga=$request->get('idcargadescarga');
        $detallepastel = null;
        $detallepastel = DB::table('cargadescargadetalle')
        ->select('cargadescargadetalle.idcargadescargadetalle', 'cargadescargadetalle.idcargadescarga', 'cargadescargadetalle.idpastel',
               'cargadescargadetalle.cantidad', 'cargadescargadetalle.precio', 'cargadescargadetalle.subtotal')
        ->where('cargadescargadetalle.idcargadescarga','=', $request->get('idcargadescarga'))->get();
        $totalcargadescarga = 0;
        $idpro = 0;
        //dd("id tra " . $idcargadescarga);
        //dd(($detallepastel));
        //dump($detallepastel);
        //dd();
        //(var_dump($cargadescargadetallepastel));
        foreach ($detallepastel as $detpro) {
            $cantidad = 0;
            $precio = 0;
            $subtotal = 0;
            $idpro = $detpro->idpastel;
            //dd($idpro);
            $cantidad =  $detpro->cantidad;
            $precio =  $detpro->precio;
            $subtotal =  $detpro->subtotal;
            $totalcargadescarga = $totalcargadescarga + $subtotal;
            $pastel = DB::table('pastel')
            ->select('pastel.idpastel', 'pastel.ingrediente', 'pastel.descripcionpastel',
                    'pastel.pcosto', 'pastel.pventa', 'pastel.stock', 'pastel.ventas', 'pastel.existencia', 'pastel.estado')
            ->where('pastel.idpastel','=', $idpro)->get();
            foreach ($pastel as $prod) {
                $pcosto = 0;
                $ventas = 0;
                $existencia = 0;
                $idpastelactualizar =  $prod->idpastel;
                //dd($pcosto);
                $ventas =  $prod->ventas;
                $existencia =  $prod->existencia;
                $pastelmodelo=pastelmodelo::findorfail($idpastelactualizar);
                $pastelmodelo->pcosto=$precio;
                $ventas = $ventas + $cantidad;
                $pastelmodelo->ventas=$ventas;  
                $existencia = $existencia - $cantidad;
                $pastelmodelo->existencia=$existencia;
                $pastelmodelo->update();
            }

        } //FIN FOR DETALLE DE pastel
      
        DB::table('cargadescarga')->where('idcargadescarga', $idcargadescarga)->update(array('total' => $totalcargadescarga, 'idestado' => "2"));  

        $cargadescargadetalle = null;
        $cargadescargadetalle = DB::table('cargadescargadetalle')
        ->leftJoin('pastel','cargadescargadetalle.idpastel', '=','pastel.idpastel')
        ->leftJoin('cargadescarga','cargadescargadetalle.idcargadescarga', '=','cargadescarga.idcargadescarga')
        
        ->leftJoin('cliente','cargadescarga.idcliente', '=','cliente.idcliente')
        ->select('cargadescargadetalle.idcargadescargadetalle', 'cargadescargadetalle.idcargadescarga', 'cargadescargadetalle.idpastel',
                'pastel.descripcionpastel', 'cargadescargadetalle.cantidad', 'cargadescargadetalle.precio', 
                'cargadescargadetalle.subtotal', DB::raw('DATE_FORMAT(cargadescarga.fecha, "%d/%m/%Y") AS fecha'), 
                'cargadescarga.idestado', 'cliente.nombrecliente')
        ->where('cargadescargadetalle.idcargadescarga','=', $idcargadescarga);
        $cargadescargadetalle = $cargadescargadetalle->orderBy('cargadescargadetalle.idpastel', 'asc')->paginate(10);

        $fechacargadescarga = '';
        $message = ''; 
        $nombreproveedor = "";
        $nombrecliente = "";
        $idestado = 0;
        foreach ($cargadescargadetalle as $detalle) {
            $fechacargadescarga =  $detalle->fecha;
           
            $idestado =  $detalle->idestado;
            $nombrecliente =  $detalle->nombrecliente;

        }
        $msgbox = '';
        $data = array(
            'fechacargadescarga'=>$fechacargadescarga,
            'idcargadescarga'=>$idcargadescarga,
            'msg'=> $msgbox,
            'idestado'=> $idestado,
            'nombrecliente'=> $nombrecliente,
        );
        
        return view ('cargadescarga.cargadescargapedido.listacargadescargadetallepedido', ["cargadescargadetalle"=>$cargadescargadetalle, "searchText" =>$idcargadescarga])->with($data);
    }


     //APLICAR DETALLE DE COMPRA
     public function anularventa(Request $request){
        $idcargadescarga=$request->get('idcargadescarga');
        $detallepastel = null;
        $detallepastel = DB::table('cargadescargadetalle')
        ->leftJoin('cargadescarga','cargadescargadetalle.idcargadescarga', '=','cargadescarga.idcargadescarga')
        ->select('cargadescargadetalle.idcargadescargadetalle', 'cargadescargadetalle.idcargadescarga', 'cargadescargadetalle.idpastel',
               'cargadescargadetalle.cantidad', 'cargadescargadetalle.precio', 'cargadescargadetalle.subtotal', 'cargadescarga.idestado')
        ->where('cargadescargadetalle.idcargadescarga','=', $request->get('idcargadescarga'))->get();
        $totalcargadescarga = 0;
        $idpro = 0;
        $idestado = 0;
        foreach ($detallepastel as $detpro) {
            $cantidad = 0;
            $precio = 0;
            $subtotal = 0;
            $idpro = $detpro->idpastel;
            //dd($idpro);
            $cantidad =  $detpro->cantidad;
            $precio =  $detpro->precio;
            $subtotal =  $detpro->subtotal;
            $idestado =  $detpro->idestado;
            $totalcargadescarga = $totalcargadescarga + $subtotal;

            if($idestado == 2){
                $pastel = DB::table('pastel')
                ->select('pastel.idpastel', 'pastel.ingrediente', 'pastel.descripcionpastel',
                        'pastel.pcosto', 'pastel.pventa', 'pastel.stock', 'pastel.ventas', 'pastel.existencia', 'pastel.estado')
                ->where('pastel.idpastel','=', $idpro)->get();
                foreach ($pastel as $prod) {
                    $pcosto = 0;
                    $ventas = 0;
                    $existencia = 0;
                    $idpastelactualizar =  $prod->idpastel;
                    //dd($pcosto);
                    $ventas =  $prod->ventas;
                    $existencia =  $prod->existencia;
                    $pastelmodelo=pastelmodelo::findorfail($idpastelactualizar);
                    $ventas = $ventas - $cantidad;
                    $existencia = $existencia + $cantidad;
                    $pastelmodelo->ventas=$ventas;
                    $pastelmodelo->existencia=$existencia;
                    $pastelmodelo->update();
                }
            }
        } //FIN FOR DETALLE DE pastel
      
        DB::table('cargadescarga')->where('idcargadescarga', $idcargadescarga)->update(array('total' => $totalcargadescarga, 'idestado' => "3"));  


        $cargadescargadetalle = null;
        $cargadescargadetalle = DB::table('cargadescargadetalle')
        ->leftJoin('pastel','cargadescargadetalle.idpastel', '=','pastel.idpastel')
        ->leftJoin('cargadescarga','cargadescargadetalle.idcargadescarga', '=','cargadescarga.idcargadescarga')
        
        ->leftJoin('cliente','cargadescarga.idcliente', '=','cliente.idcliente')
        ->select('cargadescargadetalle.idcargadescargadetalle', 'cargadescargadetalle.idcargadescarga', 'cargadescargadetalle.idpastel',
                'pastel.descripcionpastel', 'cargadescargadetalle.cantidad', 'cargadescargadetalle.precio', 
                'cargadescargadetalle.subtotal', DB::raw('DATE_FORMAT(cargadescarga.fecha, "%d/%m/%Y") AS fecha'), 
                'cargadescarga.idestado', 'cliente.nombrecliente')
        ->where('cargadescargadetalle.idcargadescarga','=', $idcargadescarga);
        $cargadescargadetalle = $cargadescargadetalle->orderBy('cargadescargadetalle.idpastel', 'asc')->paginate(10);

        $fechacargadescarga = '';
        $message = ''; 
        $nombreproveedor = "";
        $nombrecliente = "";
        $idestado = 0;
        foreach ($cargadescargadetalle as $detalle) {
            $fechacargadescarga =  $detalle->fecha;
           
            $idestado =  $detalle->idestado;
            $nombrecliente =  $detalle->nombrecliente;

        }
        $msgbox = '';
        $data = array(
            'fechacargadescarga'=>$fechacargadescarga,
            'idcargadescarga'=>$idcargadescarga,
            'msg'=> $msgbox,
            'idestado'=> $idestado,
            'nombrecliente'=> $nombrecliente,
        );
        
        return view ('cargadescarga.cargadescargapedido.listacargadescargadetallepedido', ["cargadescargadetalle"=>$cargadescargadetalle, "searchText" =>$idcargadescarga])->with($data);
    }

    
    }