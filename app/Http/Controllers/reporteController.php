<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\invTradeMarkFormRequest; //request validacion
use App\Models\invTradeMarkModel;
use DB;
use DateTime;
use PDF;

class reporteController extends Controller
{
    //Valida usuario logueado
    public function __construct()
    {
        $this -> middleware('auth'); //redirecciona a Login
    }

    //Consulta
    public function index(Request $request){
        if ($request){  
            return view ('panelreporte.panelreporte.index');
        }
    }

    // Generate PDF descarga pastel
    public function imprimircargadescargapastel(Request $request) {
        $answer = "";
        $listapastel =DB::table('pastel')
            ->select('pastel.idpastel',  'pastel.ingrediente', 'pastel.descripcionpastel',
            DB::raw('FORMAT(pastel.pcosto,2) as pcosto'),  DB::raw('FORMAT(pastel.pventa,2) as pventa'), 
            'pastel.stock', 'pastel.ventas', 'pastel.existencia',
            'pastel.photo', 'pastel.estado')
            ->where('pastel.estado','=', '1')->get();
            $fechadescarga = '';
            $estadodescarga = '';
            
            $fechaImpresion = date('d/m/Y');
            $nombrelistado = "cargadescarga pastel";
            $data = compact('listapastel','fechaImpresion', 'nombrelistado');
            $pdf = PDF::loadView('reportes.cargadescargapastel', $data);
            $path = public_path('pdf/');
            $fileName =  'cargadescargapastel_' . time() .'.pdf';
            $pdf->save($path . '/' . $fileName);
            $pdf = public_path('pdf/'.$fileName);
            $answer =  response()->download($pdf);
        return $answer;
      }

}