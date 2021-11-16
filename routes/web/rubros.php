<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('itempercentage')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-cobros']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/itempercentage-list', 'ItemPercentage\ItemPercentageController@ItemPercentagelist')->name('itempercentage.crear'); //ruta tipo planes index
       });
       
});
