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
// ::::::::::::::
// 1. creo las rutas
// Route::get('/', function () {
//     return view('principal');
// });
Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

    Route::group(['middleware'=>['auth']],function(){

        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');//cerrar seccion

        Route::get('/dashboard', 'DashboardController');

        Route::post('/notification/get', 'NotificationController@get');

        Route::get('/main', function () {
            return view('contenido/contenido');
        })->name('main');
        
        Route::group(['middleware' => ['Almacenero']], function () {
            
    
        });

        Route::group(['middleware' => ['Vendedor']], function () {

        });

        Route::group(['middleware' => ['Administrador']], function () {
            Route::get('/examen', 'ExamenController@index');
            Route::post('/examen/registrar', 'ExamenController@store');
            Route::put('/examen/actualizar', 'ExamenController@update');
            Route::put('/examen/desactivar', 'ExamenController@desactivar');
            Route::put('/examen/activar', 'ExamenController@activar');
            Route::get('/examen/selectExamen', 'ExamenController@selectExamen');

            Route::get('/textoLibre', 'TextoController@index');
            Route::post('/textoLibre/registrar', 'TextoController@store');
            Route::put('/textoLibre/actualizar', 'TextoController@update');
            Route::post('/textoLibre/eliminar','TextoController@destroy');

            Route::get('/radio', 'RadioController@index');
            Route::post('/radio/registrar', 'RadioController@store');
            Route::put('/radio/actualizar', 'RadioController@update');
            Route::post('/radio/eliminar','RadioController@destroy');

            Route::get('/multiple', 'MultipleController@index');
            Route::post('/multiple/registrar', 'MultipleController@store');
            Route::put('/multiple/actualizar', 'MultipleController@update');
            Route::post('/multiple/eliminar','MultipleController@destroy');

            

        });
    });

// Route::get('/home', 'HomeController@index')->name('home');
