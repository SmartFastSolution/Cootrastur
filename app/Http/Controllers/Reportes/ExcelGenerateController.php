<?php

namespace App\Http\Controllers\Reportes;
use DB;
use Excel;
use App\User;
use App\Exports\IngresoEgresoExport;
use App\Exports\EstadoCobrosExport;
use App\Exports\EstadoDeudaExport;
use App\Exports\BlanceGeneralExport;
use App\Exports\BlanceResultadoExport;
use App\Exports\ConciliacionBancariaExport;
use App\Exports\CobrosAcumuladosExport;
use App\Exports\DetallecuentaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Response;



class ExcelGenerateController extends Controller
{

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */

    public function CobrosAcumExcel(Request $request){
        return (new CobrosAcumuladosExport($request->fechaini,$request->fechafin,$request->partner))->download('Cobros Acumulados.xlsx');
    }
    public function ConciliacionBanco(Request $request){
        return (new ConciliacionBancariaExport($request->fechaini,$request->fechafin,$request->banco))->download('Conciliacion Bancaria.xlsx');
    }

    public function balancePerdidaGanancia(Request $request){
        return (new BlanceResultadoExport($request->fechaini,$request->fechafin))->download('Balance Pérdidas y Ganancias.xlsx');
    }

     public function balanceGeneral(Request $request){
        return (new BlanceGeneralExport($request->fechaini,$request->fechafin))->download('Balance General.xlsx');
    }

    public function estadoCobros(Request $request){
        $comprobante = DB::table('partner')->where('id', $request->comp)->first();
        return (new EstadoCobrosExport($request->comp,$request->fechaini,$request->fechafin))->download('Estado Cobro '.$comprobante->name_partner.'.xlsx');
    }

    public function estadoDeudas(Request $request){
        $comprobante = DB::table('partner')->where('id', $request->comp)->first();
        return (new EstadoDeudaExport($request->comp,$request->fechaini,$request->fechafin))->download('Estado Deuda '.$comprobante->name_partner.'.xlsx');
    }

    public function IngresoEgresoExcel(Request $request){
        $comprobante = DB::table('voucher_header')->where('id', $request->comp)->first();
        return (new IngresoEgresoExport($request->comp))->download('Comprobante '.$comprobante->number_voucher.'.xlsx');
    }

    public function AccountDetailExcel(Request $request){
        $comprobante = DB::table('account_plan')->where('code_account', $request->cuenta)->where('key_account', $request->codigo)->first();
        if(!isset($comprobante)){
            $comprobante = DB::table('account_plan')->where('code_account', $request->codigo)->where('key_account', $request->cuenta)->first();
        }
        $nombreCuenta = rtrim(ltrim($comprobante->description," ")," ");
        return (new DetallecuentaExport($request->fechaini,$request->fechafin,$request->cuenta,$request->codigo))->download('Detalle de '.$nombreCuenta.'.xlsx');
    }

}
