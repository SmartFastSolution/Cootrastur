<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('supplier')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-proveedores']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/supplier-list', 'Supplier\SupplierController@Supplierlist')->name('supplier.tipo.crear'); //ruta tipo planes index
       });
       
});
