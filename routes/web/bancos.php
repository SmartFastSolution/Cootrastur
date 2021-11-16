<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('banks')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-banks']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/bank-list', 'Banks\BankController@Banklist')->name('banks.crear'); //ruta tipo planes index
       });
       
});
