<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Auth/login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', 'HomeController@index');
Route::get('/logout','Auth\LoginController@logout')->name('logout');
Route::get('/{slug?}', 'HomeController@index'); //para controlar rutas ingresadas por usuario no existentes

Route::resource('admin/usuario', 'UsuarioController');
Route::resource('/admin/dash', 'DashbController');
// Route::get('admin/dash', 'App\Http\Controllers\DashbController@index');

//catalogos
Route::resource('catalogos/categoria', 'categoriaController');
Route::resource('catalogos/subcategoria', 'subcategoriaController');
Route::resource('catalogos/tipocargadescarga', 'tipocargadescargaController');

//proveedor
Route::resource('cargadescarga/proveedor', 'proveedorController');

//COMPRA
Route::resource('cargadescarga/cargadescargacompra', 'cargadescargacompraController');
Route::get('listacargadescargadetallecompra/{idcargadescarga}','cargadescargadetallecompraController@cargadescargadetalledata');
Route::get('cargadescarga/cargadescargacompra/listacargadescargadetallecompra/{idcargadescarga}','cargadescargadetallecompraController@cargadescargadetalledata');
Route::post('/postdetallecompra','cargadescargadetallecompraController@agregardetallecompra');
Route::post('/postdetallecompra','cargadescargadetallecompraController@edit');
Route::post('/postquitardetallecompra','cargadescargadetallecompraController@borrardetallecompra');
Route::post('/postaplicardetallecompra','cargadescargadetallecompraController@aplicarcompra');
Route::post('/postanulardetallecompra','cargadescargadetallecompraController@anularcompra');

//VENTA
Route::resource('cargadescarga/cargadescargapedido', 'cargadescargapedidoController');
Route::get('listacargadescargadetallepedido/{idcargadescarga}','cargadescargadetallepedidoController@cargadescargadetalledataventa');
Route::get('cargadescarga/cargadescargapedido/listacargadescargadetallepedido/{idcargadescarga}','cargadescargadetallepedidoController@cargadescargadetalledataventa');
Route::post('/postdetalleventa','cargadescargadetallepedidoController@agregardetalleventa');
Route::post('/postdetalleventaedit','cargadescargadetallepedidoController@edit');
Route::post('/postquitardetalleventa','cargadescargadetallepedidoController@borrardetalleventa');
Route::post('/postaplicardetalleventa','cargadescargadetallepedidoController@aplicarventa');
Route::post('/postanulardetalleventa','cargadescargadetallepedidoController@anularventa');



Route::post('/postimprimirordencompra','ordencompradetalleController@imprimirordencompra');

//cliente
Route::resource('cargadescarga/cliente', 'clienteController');
//ordenes compra
//Route::resource('ordenescompra/ordencompra', 'ordencompraController');

//Product
Route::put('cargadescarga/pastel',[App\Http\Controllers\pastelController::class, 'getSubCategory']);
Route::resource('cargadescarga/pastel', 'pastelController');
Route::post('/postajax','pastelController@post');


//Security
Route::resource('seguridad/segrol', 'segrolController');
Route::resource('seguridad/empleado', 'empleadoController');
Route::resource('seguridad/segusuario', 'segusuarioController');
Route::resource('seguridad/segusuariorol', 'segusuariorolController');
Route::resource('seguridad/segmenu', 'segmenuController');
Route::resource('seguridad/segopcion', 'segopcionController');
Route::resource('seguridad/segopcionrol', 'segopcionrolController');

Route::get('/admin', function(){
    return 'pasteleria!!!';
});



//REPORTE
Route::resource('panelreporte/panelreporte', 'reporteController');
Route::post('/postimprimircargadescargapastel','reporteController@imprimircargadescargapastel');

