<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('accountstatus')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-accountstatus']], function(){
              Route::get('/accountstatus-list', 'AccountStatus\AccountStatusController@AccountStatuslist')->name('accountstatus.crear');
              Route::get('/buscarsocio', 'AccountStatus\AccountStatusController@buscarSocio')->name('accountstatus.buscar');
              Route::get('/estadocuenta', 'AccountStatus\AccountStatusController@estadoCuenta')->name('accountstatus.estadocuenta');

              Route::get('xlscobros', ['uses' => 'Reportes\ExcelGenerateController@estadoCobros', 'as' => 'accountstatus.comprobantecobro']);
              Route::get('xlsdeuda', ['uses' => 'Reportes\ExcelGenerateController@estadoDeudas', 'as' => 'accountstatus.comprobantedeuda']);
       });
       
});
