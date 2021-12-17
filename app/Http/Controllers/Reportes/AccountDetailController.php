<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Servicios\Service;
use App\Servicios\Tiposervicio;
use App\Traits\ServiceTrait;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Validator;
use DB;
use Carbon\Carbon;
use Auth;

class AccountDetailController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function detallelist(){
        
        return view('cruds.reportes.detallecuenta');
    }

    public function buscarcuenta(Request $request){
        
        $account = $request->code;
        $cuenta= DB::table('account_plan')->where('code_account',$account)->where('status', 'activo')->first();
        if(!isset($cuenta)){
            $cuenta= DB::table('account_plan')->where('key_account',$account)->where('status', 'activo')->first();
            $clave = $cuenta->code_account;
        }else{
            $clave = $cuenta->key_account;
        }
        if(isset($clave)){
            return $clave;
        }else{
            return "ERROR";
        }
    }

    public function DetalleCuenta(Request $request){
        $fecha1 = $request->fechaini;
        $fecha2 = $request->fechafin;
        $account = $request->cuenta;
        $codigo = $request->codigo;
        $fechaReporte=Carbon::now();
        $data = [];
        $usuario = Auth::user()->name;
        $total = 0;
        $acumulacion=0;
        $totaldebito = 0;
        $totalcredito = 0;
        //return $banco;2938
        $cuenta=DB::table('account_plan')->where('code_account',$account)->where('key_account',$codigo)->where('status', 'activo')->first();
        if(!isset($cuenta)){
            $cuenta=DB::table('account_plan')->where('code_account',$codigo)->where('key_account',$account)->where('status', 'activo')->first();
        }
            $asientos = DB::table('account_detail')
                                    ->select('account_detail.id_header as id',DB::raw('account_detail.value_debito as debito,account_detail.value_credito as credito'))
                                    ->leftJoin('account_header', 'account_detail.id_header', '=', 'account_header.id')
                                    ->where('account_header.status',"CONTABILIZADO")
                                    ->whereBetween('account_header.date_voucher',[$fecha1,$fecha2])
                                    ->where('account_detail.code_account',$account)
                                    ->where('account_detail.key_account',$codigo);
            
            $movimientos = DB::table('voucher_detail')
                                    ->select('voucher_detail.id_vheader as id',DB::raw('voucher_detail.value_debito as debito,voucher_detail.value_credito as credito'))
                                    ->leftJoin('voucher_header', 'voucher_detail.id_vheader', '=', 'voucher_header.id')
                                    ->where('voucher_header.status',"APROBADO")
                                    ->whereBetween('voucher_header.date_registre',[$fecha1,$fecha2])
                                    ->where('voucher_detail.code_account',$account)
                                    ->where('voucher_detail.key_account',$codigo)
                                    ->union($asientos)
                                    ->get();

            if(count($movimientos) == 0){
                $asientos = DB::table('account_detail')
                    ->select('account_detail.id_header as id',DB::raw('account_detail.value_debito as debito,account_detail.value_credito as credito'))
                    ->leftJoin('account_header', 'account_detail.id_header', '=', 'account_header.id')
                    ->where('account_header.status',"CONTABILIZADO")
                    ->whereBetween('account_header.date_voucher',[$fecha1,$fecha2])
                    ->where('account_detail.code_account',$codigo)
                    ->where('account_detail.key_account',$account);
                                    
                $movimientos = DB::table('voucher_detail')
                    ->select('voucher_detail.id_vheader as id',DB::raw('voucher_detail.value_debito as debito,voucher_detail.value_credito as credito'))
                    ->leftJoin('voucher_header', 'voucher_detail.id_vheader', '=', 'voucher_header.id')
                    ->where('voucher_header.status',"APROBADO")
                    ->whereBetween('voucher_header.date_registre',[$fecha1,$fecha2])
                    ->where('voucher_detail.code_account',$codigo)
                    ->where('voucher_detail.key_account',$account)
                    ->union($asientos)
                    ->get();
            }
            foreach ($movimientos as $orden) {
                $description ="";
                $importe = 0;
                $cheque = "";
                $fecha= "";
                $numeroComprobante=0;
                $concepto = DB::table('account_header')->where('id', $orden->id)->first();
                if(isset($concepto)){
                    $description = $concepto->header_description;
                    $fecha = $concepto->date_voucher;
                    $numeroComprobante= $concepto->number_voucher;
                }else{
                    $concepto1 = DB::table('voucher_header')->where('id', $orden->id)->first();
                    $description = $concepto1->detail_voucher;
                    $fecha = $concepto1->date_registre;
                    $numeroComprobante= $concepto1->number_voucher;
                    if(isset($concepto1->number_check)){
                        $cheque = $concepto1->number_check;
                    }
                    
                }
                $importe = $orden->debito + $orden->credito;
                $acumulacion = $acumulacion + $importe ;
                $data [] = [
                    'col0' => $fecha,
                    'col1' => $numeroComprobante,
                    'col2' => $description,
                    'col3' => $orden->debito,
                    'col4' => $orden->credito,
                    'col5' => $acumulacion,
                    'col6' => $cheque,
                ];
                $totaldebito = $totaldebito+$orden->debito;
                $totalcredito = $totalcredito+$orden->credito;
                
            }
            $nombreCuenta=$cuenta->description;
            $view = \View::make('Reportes.reporteDetallecuenta',compact(['data','fechaReporte','totaldebito','totalcredito','nombreCuenta','fecha1','fecha2','usuario','codigo','account']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream($nombreCuenta.'.pdf');
        //return $pdf->download("Comprobante ".$cabecera->number_voucher.'.pdf');
        //return $data;
    }


}
