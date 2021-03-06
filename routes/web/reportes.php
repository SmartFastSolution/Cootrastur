<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de reportes
Route::prefix('reportes')->group(function(){

    Route::group(['middleware'=>['role_or_permission:super-admin|reportes']], function(){
        //RUTAS DE REPORTES
        Route::get('/reporte-usuarios', 'Reportes\ReporteController@ReporteEdad')->name('reportes.usuario'); //reporte por edad usuarios
        Route::get('/reporte-usuarios-ciudad', 'Reportes\ReporteController@ReporteCiudad')->name('reportes.usuario.ciudad'); //reporte por edad usuarios
        Route::get('/reporte-generos', 'Reportes\ReporteController@ReporteGenero')->name('reportes.genero'); //reporte por genero usuarios
        Route::get('/reporte-usuario-telefono', 'Reportes\ReporteController@ReporteTelefono')->name('reportes.usuario.telefono'); //reporte por telefono usuarios
        Route::get('/reporte-usuario-email', 'Reportes\ReporteController@ReporteEmail')->name('reportes.usuario.email'); //reporte por telefono usuarios

        Route::get('/balance', 'Reportes\BalanceGeneralController@balancelist')->name('reportes.indexbalance'); 
        Route::get('/balancegeneral', 'Reportes\ExcelGenerateController@balanceGeneral')->name('reportes.verblance'); 

        Route::get('/balanceresultado', 'Reportes\BalanceResultadoController@balanceResult')->name('reportes.indexresult'); 
        Route::get('/balanceresultadoexcel', 'Reportes\ExcelGenerateController@balancePerdidaGanancia')->name('reportes.verresult'); 

        Route::get('/conciliacion', 'Reportes\ConciliacionBancariaController@conciliacionlist')->name('reportes.indexconciliacion'); 
        Route::get('/conciliacionexcel', 'Reportes\ExcelGenerateController@ConciliacionBanco')->name('reportes.verconciliacion');

        Route::get('/cobrosacum', 'Reportes\CobrosAcumuladosController@cobrosacumlist')->name('reportes.indexcobros'); 
        Route::get('/cobrosacumexcel', 'Reportes\ExcelGenerateController@CobrosAcumExcel')->name('reportes.vercobrosa');

        Route::get('/detalle-cuenta', 'Reportes\AccountDetailController@detallelist')->name('reportes.indexdetailaccount'); 
        Route::get('/buscarCuenta', 'Reportes\AccountDetailController@buscarcuenta')->name('reportes.buscarcuenta');
        Route::get('/detalle-cuenta-pdf', 'Reportes\AccountDetailController@DetalleCuenta')->name('reportes.verdetallecuenta');
        Route::get('/detalle-cuenta-excel', 'Reportes\ExcelGenerateController@AccountDetailExcel')->name('reportes.verdetallecuentaexcel'); 

        Route::get('/detalle-socio', 'Reportes\SociosGeneralesController@SociosGeneraleslist')->name('reportes.indexsociogeneral'); 
        Route::get('/reportesocio', 'Reportes\SociosGeneralesController@GeneralSocio')->name('reportes.sociodetalle');
        //Route::get('/detalle-cuenta-excel', 'Reportes\AccountDetailController@DetalleCuenta')->name('reportes.verdetallecuenta');
 });


});
