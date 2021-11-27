<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('recibecomp')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|p_voucher']], function(){
              Route::get('/comprobrecibe-list', 'RecibeComp\CompRecibeController@Voucherlist')->name('recibecomp.crear'); 
              Route::get('listacomprobrecibe', ['uses' => 'RecibeComp\CompRecibeController@cuentasContable', 'as' => 'recibecomp.listacuentas']);
              Route::get('savecomprobrecibe', ['uses' => 'RecibeComp\CompRecibeController@guardarRecibo', 'as' => 'recibecomp.savesvoucher']);
              Route::get('detallefactura', ['uses' => 'RecibeComp\CompRecibeController@buscarDetalle', 'as' => 'recibecomp.buscardetalle']);
              Route::get('buscarsocios', ['uses' => 'RecibeComp\CompRecibeController@buscarSocio', 'as' => 'recibecomp.buscarsocios']);
              Route::get('updatecomprobrecibe', ['uses' => 'RecibeComp\CompRecibeController@actualizarVoucher', 'as' => 'recibecomp.updatevoucher']);
              Route::get('partner', ['uses' => 'RecibeComp\CompRecibeController@consultaSocios', 'as' => 'recibecomp.socios']);
              Route::get('cuentaauto', ['uses' => 'VoucherCheck\VoucherCheckController@CuentasProveedor', 'as' => 'vouchers.autoaccount']);

              Route::get('xlsingresoegreso', ['uses' => 'Reportes\ExcelGenerateController@IngresoEgresoExcel', 'as' => 'recibecomp.comprobante']);
              Route::get('pdfingresoegreso', ['uses' => 'RecibeComp\CompRecibeController@descargarPDF', 'as' => 'recibecomp.comprobantepdf']);
              Route::get('eliminarrecibo', ['uses' => 'RecibeComp\CompRecibeController@EliminarFactura', 'as' => 'recibecomp.deletefact']);
              Route::get('aprobarrecibo', ['uses' => 'RecibeComp\CompRecibeController@AprobarFactura', 'as' => 'recibecomp.aprobarfact']);
       });
       
});
