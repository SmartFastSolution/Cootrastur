<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sri\SriController;
use App\Http\Controllers\IngresoComprobanteController;

Route::view('/admin/ingreso_facturas/sri', 'admin.ingreso_facturas.sri.index')->name('admin.ingreso_facturas.sri.index');
Route::post('/admin/procesarComprobanteSRI',[SriController::class,'procesarComprobanteSRI'])->name('admin.procesarComprobanteSRI');

Route::view('/admin/ingreso_facturas/ingreso_manual', 'admin.ingreso_facturas.ingreso_manual.index')->name('admin.ingreso_facturas.ingreso_manual.index');
Route::get('/admin/ingreso_facturas/listar_tipo_transaccion', [IngresoComprobanteController::class,'listarTipoTransaccion'])->name('admin.ingreso_facturas.listar_tipo_transaccion');
