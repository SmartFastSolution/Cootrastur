<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('retentions')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-retention']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/retention-list', 'Configuration\ConfigurationRetentionController@Retentionlist')->name('retentions.crear'); //ruta tipo planes index 
              Route::get('cuentasretention', ['uses' => 'Configuration\ConfigurationRetentionController@buscarCuentas', 'as' => 'retentions.cuentas']);
       });
       
});
