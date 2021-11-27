<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('advances')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-advances']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/advances-list', 'AdvancesLoan\AdvancesController@Advanceslist')->name('advances.crear'); //ruta tipo planes index 
              Route::get('advancesloan', ['uses' => 'AdvancesLoan\AdvancesController@buscarCuentas', 'as' => 'advances.cuentas']);
              Route::get('pdfprestamos', ['uses' => 'AdvancesLoan\AdvancesController@DetallePrestamo', 'as' => 'advances.prestamopdf']);
       });
       
});
