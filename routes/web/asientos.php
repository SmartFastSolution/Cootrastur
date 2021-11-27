<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('seat')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-seat']], function(){
              Route::get('/seat-list', 'AccountPlan\JourmalEntryController@JourmalEntrylist')->name('seat.crear'); 
              Route::get('listaccount', ['uses' => 'AccountPlan\JourmalEntryController@cuentasContable', 'as' => 'account.listacuentas']);
              Route::get('saveseat', ['uses' => 'AccountPlan\JourmalEntryController@guardarAsiento', 'as' => 'account.saveseat']);
              Route::get('detalleasiento', ['uses' => 'AccountPlan\JourmalEntryController@buscarDetalle', 'as' => 'account.buscardetalle']);
              Route::get('actualizarasiento', ['uses' => 'AccountPlan\JourmalEntryController@actualizarAsiento', 'as' => 'account.updateseat']);
              Route::get('pdfasientos', ['uses' => 'AccountPlan\JourmalEntryController@descargarPDF', 'as' => 'account.asientopdf']);

              Route::get('eliminarasiento', ['uses' => 'AccountPlan\JourmalEntryController@EliminarAsiento', 'as' => 'account.deleteseat']);
              Route::get('aprobarasiento', ['uses' => 'AccountPlan\JourmalEntryController@AprobarAsiento', 'as' => 'account.aprobarseat']);
       });
       
});
