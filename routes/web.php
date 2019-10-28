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