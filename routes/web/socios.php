<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('partner')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-socios']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/partner-list', 'Partner\PartnerController@Partnerlist')->name('partner.crear'); //ruta tipo planes index
              Route::get('partnerXLSX', ['uses' => 'Partner\PartnerController@importarSocios1', 'as' => 'partner.import']);
              Route::get('cuentasSocios', ['uses' => 'Partner\PartnerController@buscarCuentas', 'as' => 'partner.cuentas']);
       });
       
});
