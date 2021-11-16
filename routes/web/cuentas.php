<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('account')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-cuentas']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/account-list', 'AccountPlan\AccountPlanController@Accountlist')->name('account.crear'); //ruta tipo planes index
              Route::get('accountXLSX', ['uses' => 'AccountPlan\AccountPlanController@importarAccount1', 'as' => 'account.import']);
       });
       
});
