<?php

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

/*Route::get('/', function () {
    return view('test');
});
*/

Auth::routes();

Route::middleware(['auth',])->group(function () {

  Route::get('/', 'HomeController@index')->name('home');
  Route::get('user-autocomplete', 'UserController@autocomplete');

  Route::resource('user', 'UserController');
  Route::resource('logins', 'LoginController');
  Route::resource('permission', 'PermissionController');

   /***************************************************************************
  ***********************************Productos********************************
  ****************************************************************************/
  Route::post('/productos/familiaProductos/nueva', 'ProductoController@nuevaFamiliaProducto');

	Route::get('/productos', 'ProductoController@index');
	Route::get('/productos/movimientos', 'ProductoController@movimientos');

	Route::get('/productos/buscar', 'ProductoController@buscar');		
	Route::get('/productos/imprimir/{producto}', 'ProductoController@imprimir');
	Route::get('/productos/nuevo', 'ProductoController@nuevo');
	Route::post('/productos/nuevo', 'ProductoController@guardar');
	Route::post('/productos/editar', 'ProductoController@editar');
	Route::post('/productos/borrar', 'ProductoController@borrar');
	Route::get('/productos/detalle/{codigo}', 'ProductoController@detalle');
	Route::post('/productos/{codigo}/configuracion', 'ProductoController@configuracion');
	Route::post('/productos/{codigo}/ModificarStock', 'ProductoController@movimientoModificarStock');
	Route::get('/productos/{codigo}/NotifStockMin', 'ProductoController@NotifStockMin');
	Route::get('/productos/detalles', 'ProductoController@detallada');


	
	/***************************************************************************
	***********************************Pedidos*****************************
	****************************************************************************/
    Route::resource('pedidos/detalle','PedidosDetalleController');
	Route::get('pedido/detalle/entregados','PedidosDetalleController@entregados');
	Route::get('pedidos/detalle/{pedido}/print','PedidosDetalleController@print');
	Route::get('/pedidos', 'CartDetailController@index');

	/***************************************************************************
	***********************************Proveedores******************************
	****************************************************************************/

	



	Route::resource('/cart', 'CartDetailController');
Route::post('/order', 'CartController@update');

});
