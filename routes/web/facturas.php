<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de mantenimiento
Route::prefix('vouchers')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|p_voucher']], function(){
              Route::get('/vouchers-list', 'VoucherCheck\VoucherCheckController@Voucherlist')->name('vouchers.crear'); 
              Route::get('listavouchers', ['uses' => 'VoucherCheck\VoucherCheckController@cuentasContable', 'as' => 'vouchers.listacuentas']);
              Route::get('savevouchers', ['uses' => 'VoucherCheck\VoucherCheckController@guardarFactura', 'as' => 'vouchers.savesvoucher']);
              Route::get('detallefactura', ['uses' => 'VoucherCheck\VoucherCheckController@buscarDetalle', 'as' => 'vouchers.buscardetalle']);
              Route::get('buscarsocios', ['uses' => 'VoucherCheck\VoucherCheckController@buscarSocio', 'as' => 'vouchers.buscarsocios']);
              Route::get('updatevouchers', ['uses' => 'VoucherCheck\VoucherCheckController@actualizarVoucher', 'as' => 'vouchers.updatevoucher']);
              Route::get('cuentaauto', ['uses' => 'VoucherCheck\VoucherCheckController@CuentasProveedor', 'as' => 'vouchers.autoaccount']);
              Route::get('partner', ['uses' => 'VoucherCheck\VoucherCheckController@consultaSocios', 'as' => 'vouchers.socios']);
              Route::get('xlsingresoegreso', ['uses' => 'Reportes\ExcelGenerateController@IngresoEgresoExcel', 'as' => 'vouchers.comprobante']);
              Route::get('pdfingresoegreso', ['uses' => 'VoucherCheck\VoucherCheckController@descargarPDF', 'as' => 'vouchers.comprobantepdf']);

              Route::get('eliminarfactura', ['uses' => 'VoucherCheck\VoucherCheckController@EliminarFactura', 'as' => 'vouchers.deletefact']);
              Route::get('aprobarfactura', ['uses' => 'VoucherCheck\VoucherCheckController@AprobarFactura', 'as' => 'vouchers.aprobarfact']);
       });
       
});
