<?php

namespace App\Http\Controllers\AccountStatus;

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

class AccountStatusController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function AccountStatuslist(){
        return view('cruds.AccountSatusSocios.EstadoCuenta.index');
    }

    public function buscarSocio(Request $request){
        $idSocio = $request->id;
        $data = DB::table('partner')->where('id',$idSocio)->get();
        return $data; 
    }

    public function estadoCuenta(Request $request){
        $idSocio = $request->socio;
        $fecha_ini = $request->fecha1;
        $fecha_fin = $request->fecha2;
        $pagos = [];
        $datafactura = DB::table('voucher_header')->whereBetween('date_voucher',[$fecha_ini,$fecha_fin])->where('status','APROBADO')->where('id_proveedor',$idSocio)->get();
        $result = $datafactura->toArray();
        foreach ($result as $cabecera){
            $detalle = DB::table('voucher_detail')->where('id_vheader', $cabecera->id)->get();
            $resultdetalle = $detalle->toArray();
            $prestamo = 0;
            $anticipo = 0;
            $cuotaAd = 0;
            $certificado = 0;
            $dolar = 0;
            $union = 0;
            $ahorro = 0;
            $varias = 0;
            $multas = 0;
            $gestion = 0;
            $fondo = 0;
            $multas = 0;
            $cuotaIng = 0;
            $puntoEmi = 0;
            $gestionCobran=0;
            foreach ($resultdetalle as $detallepagos){
                $flag = "Y";
                $cuentasCobro1 = DB::table('charges')->where('key_account', $detallepagos->key_account)->where('code_account', $detallepagos->code_account)->where('status',"activo")->first();
                if(isset($cuentasCobro1)){
                    $flag = "N";
                    if($cuentasCobro1->type_cobros != "" || $cuentasCobro1->type_cobros != null ){
                        if($cuentasCobro1->type_cobros == "1"){
                            $cuotaAd = $detallepagos->value_credito;
                        }else if($cuentasCobro1->type_cobros == "2"){
                            $certificado = $detallepagos->value_credito;
                        }else if($cuentasCobro1->type_cobros == "3"){
                            $dolar = $detallepagos->value_credito;
                        }else if($cuentasCobro1->type_cobros == "4"){
                            $union = $detallepagos->value_credito;
                        }else if($cuentasCobro1->type_cobros == "5"){
                            $ahorro = $detallepagos->value_credito;
                        }else if($cuentasCobro1->type_cobros == "6"){
                            $fondo = $detallepagos->value_credito;
                        }else if($cuentasCobro1->type_cobros == "7"){
                            $cuotaIng = $detallepagos->value_credito;
                        }else if($cuentasCobro1->type_cobros == "8"){
                            $multa = $detallepagos->value_credito;
                        }else if($cuentasCobro1->type_cobros == "9"){
                            $puntoEmi = $detallepagos->value_credito;
                        }else if($cuentasCobro1->type_cobros == "10"){
                            $gestionCobran = $detallepagos->value_credito;
                        }

                    }
                    
                }
                /*$cuentasmulta = DB::table('configuration_discount')->where('key_account', $detallepagos->key_account)->where('code_account', $detallepagos->code_account)->where('status',"activo")->where('code_discount',"10")->first();
                if(isset($cuentasmulta)){
                    $flag = "N";
                    $multas = $detallepagos->value_credito;
                }
                $cuentasmulta = DB::table('configuration_discount')->where('key_account', $detallepagos->key_account)->where('code_account', $detallepagos->code_account)->where('status',"activo")->where('code_discount',"4")->first();
                if(isset($cuentasmulta)){
                    $flag = "N";
                    $puntoEmi = $detallepagos->value_credito;
                }*/
                $cuentasCobro = DB::table('advances_loan')->where('key_account', $detallepagos->key_account)->where('code_account', $detallepagos->code_account)->where('id_partner',$idSocio)->where('status','Aprobado')->first();
                if(isset($cuentasCobro)){
                    $flag = "N";
                    if($cuentasCobro->type_prestamo == "P"){
                        $prestamo = $detallepagos->value_credito;
                    }else{
                        $anticipo = $detallepagos->value_credito;
                    }
                }
                $cuentaPaga = DB::table('bank')->where('key_account', $detallepagos->key_account)->where('code_account', $detallepagos->code_account)->first();
                if(isset($cuentaPaga)){
                    $flag = "N";
                    $pagos[]=[
                        'comprobante' => $cabecera->number_voucher,
                        'date_registre' => $cabecera->date_registre,
                        'pago' => $cabecera->total_value,
                        'cuenta' => $cuentaPaga->description,
                        'prestamo' => 0,
                        'anticipo' => 0,
                        'tabla'=>"P",
                    ];
                }
                if($flag == "Y"){
                    $varias = number_format($varias + $detallepagos->value_credito , 2, '.', "");
                }

            }
            $pagos[]=[
                'comprobante' => $cabecera->number_voucher,
                'date_registre' => $cabecera->date_registre,
                'pago' => 0,
                'cuenta' =>"",
                'prestamo' => $prestamo,
                'anticipo' => $anticipo,
                'total' =>number_format($anticipo + $prestamo + $cuotaAd + $certificado + $dolar + $union + $ahorro + $varias + $fondo + $cuotaIng + $multas + $puntoEmi, 2, '.', ""),
                'tabla'=>"C",
                'cuotaAd' =>$cuotaAd,
                'certificado' => $certificado,
                'dolar' => $dolar,
                'union' =>$union,
                'ahorro'=> $ahorro,
                'varias' => $varias,
                'fondo' =>  $fondo,
                'cuotaIng' =>$cuotaIng,
                'multas' => $multas,
                'puntoEmi' =>$puntoEmi,
                'gestion'=>$gestionCobran,
            ];
        }
        $dataPendiente = DB::table('partner_aditional_detail')->select('number_voucher','date_registre')->whereBetween('date_registre',[$fecha_ini,$fecha_fin])->where('status','PENDIENTE')->where('id_partner',$idSocio)->groupBy('number_voucher','date_registre')->get();
        //return $dataPendiente;
        $resultDeudas = $dataPendiente->toArray();
        
        $aux = 1;
        $separarFecha = explode("/", Carbon::parse($fecha_ini)->format('Y/m/d'));
        $separarFecha2 = explode("/",Carbon::parse($fecha_fin)->format('Y/m/d'));
        $mesVlidacion = (int)$separarFecha[1];
        $totalDeudaAuto= count($dataPendiente);
        //return $dataPendiente;
        
        foreach ($resultDeudas as $deudas){
            
            $cuotaAd = 0;
            $certificado = 0;
            $dolar = 0;
            $union = 0;
            $ahorro = 0;
            $varias = 0;
            $multas = 0;
            $gestion = 0;
            $fondo = 0;
            $multas = 0;
            $cuotaIng = 0;
            $puntoEmi = 0;
            $dataPendientetotal = DB::table('partner_aditional_detail')->whereBetween('date_registre',[$fecha_ini,$fecha_fin])->where('status','PENDIENTE')->where('id_partner',$idSocio)->where('number_voucher',$deudas->number_voucher)->get();
            $resultDeudas1 = $dataPendientetotal->toArray();
            foreach ($resultDeudas1 as $deudas1){
                $cuentasmulta = DB::table('configuration_discount')->where('key_account', $deudas1->key_account)->where('code_account', $deudas1->code_account)->where('status',"activo")->where('code_discount',"10")->first();
                $cuentasmulta1 = DB::table('configuration_discount')->where('key_account', $deudas1->key_account)->where('code_account', $deudas1->code_account)->where('status',"activo")->where('code_discount',"4")->first();
                
                if($deudas1->code_discount == "1"){
                    $cuotaAd = $deudas1->value_pending;
                }else if($deudas1->code_discount == "2"){
                    $certificado = $deudas1->value_pending;
                }else if($deudas1->code_discount == "3"){
                    $dolar = $deudas1->value_pending;
                }else if($deudas1->code_discount == "4"){
                    $union = $deudas1->value_pending;
                }else if($deudas1->code_discount == "5"){
                    $ahorro = $deudas1->value_pending;
                }else if($deudas1->code_discount == "6"){
                    $fondo = $deudas1->value_pending;
                }else if($deudas1->code_discount == "7"){
                    $cuotaIng = $deudas1->value_pending;
                }else if($deudas1->code_discount == "8"){
                    $multa = $detallepagos->value_credito;
                }else if($deudas1->code_discount == "9"){
                    $puntoEmi = $detallepagos->value_credito;
                }else if($deudas1->code_discount == "10"){
                    $gestionCobran = $detallepagos->value_credito;
                }else{
                    $varias = $varias + $deudas1->value_pending;
                }
            }
            $pagos[]=[
                'comprobante' => $deudas->number_voucher,
                'date_registre' => $deudas->date_registre,
                'pago' => 0,
                'cuenta' =>"",
                'prestamo' => $prestamo,
                'anticipo' => $anticipo,
                'total' =>number_format($anticipo + $prestamo + $cuotaAd + $certificado + $dolar + $union + $ahorro + $varias + $fondo + $cuotaIng + $multas + $puntoEmi, 2, '.', ""),
                'tabla'=>"D",
                'cuotaAd' =>$cuotaAd,
                'certificado' => $certificado,
                'dolar' => $dolar,
                'union' =>$union,
                'ahorro'=> $ahorro,
                'varias' => $varias,
                'fondo' =>  $fondo,
                'cuotaIng' =>$cuotaIng,
                'multas' => $multas,
                'puntoEmi' =>$puntoEmi,
            ]; 
            $aux++;
        }
        $cuentasCobro = DB::table('advances_loan')->where('id_partner',$idSocio)->where('status','Aprobado')->where('value_pending','!=',0)->get();
        if(isset($cuentasCobro)){
            $index = 1;
            
            foreach ($cuentasCobro as $deudasPrestamo){
                $cuentasDetalle = DB::table('detail_advance_loan')->where('id_advances_loan',$deudasPrestamo->id)->where('status','PENDIENTE')->whereBetween('date_payment',[$fecha_ini,$fecha_fin])->get();
                if(isset($cuentasCobro)){
                    foreach ($cuentasDetalle as $detallePrestamo){
                        $prestamo = 0;
                        $anticipo = 0;
                        if($deudasPrestamo->type_prestamo == "P"){
                            $prestamo =  $detallePrestamo->value_unit;
                        }else{
                            $anticipo = $detallePrestamo->value_unit;
                        }
                        $pagos[]=[
                            'comprobante' => 0,
                            'date_registre' => $detallePrestamo->date_payment,
                            'pago' => 0,
                            'cuenta' =>"",
                            'prestamo' => $prestamo,
                            'anticipo' => $anticipo,
                            'total' =>number_format($anticipo + $prestamo, 2, '.', ""),
                            'tabla'=>"D",
                            'cuotaAd' =>0,
                            'certificado' => 0,
                            'dolar' => 0,
                            'union' =>0,
                            'ahorro'=> 0,
                            'varias' => 0,
                            'fondo' =>  0,
                            'cuotaIng' =>0,
                            'multas' => 0,
                            'puntoEmi' =>0,
                        ]; 
                    }
                }
                
                $index++;
            }
            //return $pagos;
        }
        return $pagos; 
    }


}
