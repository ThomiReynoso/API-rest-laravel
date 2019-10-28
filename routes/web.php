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

//*********RUTAS DE PRUEBA ************

Route::get('/', function () {
    return view('welcome');
});

Route::get('/prueba/{nombre?}', function ( $nombre = null) {
    $texto = '<h2> Texto desde una ruta </h2 >';
    //concateno 
    $texto .= 'Nombre: ' . $nombre;
    
    //Retorno una vista, a la cual le paso parametros por un hash table, para que imprima x pantalla
    return view('prueba', array(
        'texto' => $texto
    ));
});

//llamo al metodo/action "index" del PruebaController
Route::get('/animales', 'PruebaController@index');

Route::get('/test-orm', 'PruebaController@testOrm'); 


//***********RUTAS DE LA API**************
    
    /* METODOS HTTP COMUNES
     * 
     * GET:     Conseguir datos o recursos
     * POST:    Guardar datos o recursos o hacer logica (mas seguro, ya que los datos no se ven
     *          desde la URL, sino que van por el formulario)
     * PUT:     Actualizar recursos o datos
     * DELETE:  Eliminar datos o recursos

     **Las API Rest usan solo GET y POST.
     **Las API RestFull usan TODOS los metdos descriptos    */


    //Rutas de prueba
    Route::get('/usuario/pruebas', 'UserController@pruebas');
    Route::get('/categoria/pruebas', 'CategoryController@pruebas');
    Route::get('/entrada/pruebas', 'PostController@pruebas');

    //Rutas del controlador de usuario
    Route::post('/api/register', 'UserController@register');
    Route::post('/api/login', 'UserController@login');
    
    