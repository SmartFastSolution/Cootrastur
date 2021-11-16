<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('cobrosconfig')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-cobros']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/cobrosconfig-list', 'ManteCharges\MantChargesController@Mantenimientolist')->name('cobrosconfig.crear'); //ruta tipo planes index
       });
       
});
