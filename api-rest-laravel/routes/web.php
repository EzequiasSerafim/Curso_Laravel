<?php

Route::get('/welcome', function () {
    return view('welcome');
});

//---------------- Rutas de Pruebas ----------------
Route::get('/pruebas/{nombre?}', function($nombre = null) {
    $texto = '<h2> Texto Teste de rutas</h2>';
    $texto .= 'Nombre: '.$nombre;
    return view('pruebas', array(
        'texto' => $texto
    ));
});


Route::get('/testin','PruebasController@index');
Route::get('/testinn','PruebasController@testeOrm');
Route::get('/pruebasC','CategoryController@pruebas');
Route::get('/pruebasU','UserController@pruebas');
Route::get('/pruebasP','PostController@pruebas');
//---------------- Rutas de Pruebas ----------------


/*Metodos HTTP mas comunes
 
 * GET: Conseguir datos o recursos
 * POST: Guardar datos o recursos o hacer logica desde un formulario
 * PUT: Actualizar datos o recursos
 * DELETE: Eliminar datos o recursos
 
 */

//---------------- Rutas del Controlador de usuarios----------------

Route::post('usuario/registro', 'UserController@register');
Route::post('usuario/login', 'UserController@login');

//---------------- Rutas del Controlador de usuarios----------------