<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('parameter')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-parameter']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/parameter-list', 'AccountParameter\AccountParameterController@Parameterlist')->name('parameter.crear'); //ruta tipo planes index
              Route::get('listaccount', ['uses' => 'AccountParameter\AccountParameterController@buscarCuentas', 'as' => 'parameter.buscarcuenta']);

       });
       
});
