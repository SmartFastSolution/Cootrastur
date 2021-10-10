<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('charges')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-cobros']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/charges-list', 'Charges\ChargesController@Chargeslist')->name('charges.crear'); //ruta tipo planes index
       });
       
});
