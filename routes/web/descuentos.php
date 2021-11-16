<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('discount')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-discount']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/discount-list', 'Configuration\ConfigurationDiscountController@Discountlist')->name('discount.crear'); //ruta tipo planes index 
              Route::get('cuentasDescuento', ['uses' => 'Configuration\ConfigurationDiscountController@buscarCuentas', 'as' => 'discount.cuentas']);
       });
       
});
