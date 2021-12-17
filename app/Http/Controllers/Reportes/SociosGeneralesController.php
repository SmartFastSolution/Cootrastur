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

class SociosGeneralesController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function SociosGeneraleslist(){
        $sociostotal = DB::table('partner')->where('status', "activo")->get();
        return view('cruds.reportes.sociodeuda',compact('sociostotal'));
    }

   

    public function GeneralSocio(Request $request){
        $fecha1 = $request->fechaini;
        $fecha2 = $request->fechafin;
        $socio = $request->socios;
        $fechaReporte=Carbon::now();
        $data = [];
        $usuario = Auth::user()->name;
        $totalprestamo = 0;
        $totalanticipo = 0;
        $totalcuotaAd = 0;
        $totalcertificado = 0;
        $totaldolar = 0;
        $totalunion = 0;
        $totalahorro = 0;
        $totalvarias = 0;
        $totalmultas = 0;
        $totalgestionCobran = 0;
        $totalfondo = 0;
        $totalmultas = 0;
        $totalcuotaIng = 0;
        $totalpuntoEmi = 0;
        $acmuladoLinea = 0;
        
        //return $banco;
        if($socio == "TODOS"){
            //$dataPendiente = DB::table('partner_aditional_detail')->select('number_voucher','date_registre','id_partner')->whereBetween('date_registre',[$fecha1,$fecha2])->where('status','PENDIENTE')->groupBy('number_voucher','date_registre','id_partner')->get();
            $todoSocio = DB::table('partner')->get();
            //return $dataPendiente;
            $resultDeudas = $todoSocio->toArray();
            foreach ($resultDeudas as $sociosregistro){
                $prestamo = 0;
                $anticipo = 0;
                $cuotaAd = 0;
                $certificado = 0;
                $dolar = 0;
                $union = 0;
                $ahorro = 0;
                $varias = 0;
                $multas = 0;
                $gestionCobran = 0;
                $fondo = 0;
                $multas = 0;
                $cuotaIng = 0;
                $puntoEmi = 0;
                $totalLinea1 = 0;
                $prestamosTotal = DB::table('advances_loan')
                                    ->select('type_prestamo as codigo',DB::raw("SUM(value_unit) as valorD"))
                                    ->join('detail_advance_loan', 'detail_advance_loan.id_advances_loan', '=', 'advances_loan.id')
                                    ->where('id_partner', $sociosregistro->id)
                                    ->where('detail_advance_loan.status','PENDIENTE')
                                    ->where('advances_loan.type_prestamo','P')
                                    ->whereBetween('detail_advance_loan.date_payment',[$fecha1,$fecha2])
                                    ->groupBy('type_prestamo');
                $anticipoTotal = DB::table('advances_loan')
                                    ->select('type_prestamo as codigo',DB::raw("SUM(value_unit) as valorD"))
                                    ->join('detail_advance_loan', 'detail_advance_loan.id_advances_loan', '=', 'advances_loan.id')
                                    ->where('id_partner', $sociosregistro->id)
                                    ->where('detail_advance_loan.status','PENDIENTE')
                                    ->where('advances_loan.type_prestamo','A')
                                    ->whereBetween('detail_advance_loan.date_payment',[$fecha1,$fecha2])
                                    ->groupBy('type_prestamo');
                //return $prestamosTotal;
                $dataPendientetotal = DB::table('partner_aditional_detail')->select('code_discount as codigo', 'value_pending as valorD')->whereBetween('date_registre',[$fecha1,$fecha2])->where('status','PENDIENTE')->where('id_partner',$sociosregistro->id)->union($prestamosTotal)->union($anticipoTotal)->get();
                $resultDeudas1 = $dataPendientetotal->toArray();
                foreach ($resultDeudas1 as $deudas1){
                    if($deudas1->codigo == "1"){
                        $cuotaAd = $cuotaAd + $deudas1->valorD;
                        $totalcuotaAd = $totalcuotaAd + $cuotaAd;
                    }else if($deudas1->codigo == "2"){
                        $certificado = $certificado + $deudas1->valorD;
                        $totalcertificado = $totalcertificado + $certificado;
                    }else if($deudas1->codigo == "3"){
                        $dolar =$dolar + $deudas1->valorD;
                        $totaldolar = $totaldolar + $dolar;
                    }else if($deudas1->codigo == "4"){
                        $union = $union + $deudas1->valorD;
                        $totalunion = $totalunion + $union ;
                    }else if($deudas1->codigo == "5"){
                        $ahorro =$ahorro + $deudas1->valorD;
                        $totalahorro = $totalahorro + $ahorro;
                    }else if($deudas1->codigo == "6"){
                        $fondo =$fondo + $deudas1->valorD;
                        $totalfondo = $totalfondo + $fondo;
                    }else if($deudas1->codigo == "7"){
                        $cuotaIng =$cuotaIng + $deudas1->valorD;
                        $totalcuotaIng = $totalcuotaIng + $cuotaIng;
                    }else if($deudas1->codigo == "8"){
                        $multa =$multa + $deudas1->valorD;
                        $totalmultas = $totalmultas + $multa;
                    }else if($deudas1->codigo == "9"){
                        $puntoEmi = $puntoEmi + $deudas1->valorD;
                        $totalpuntoEmi =$totalpuntoEmi + $deudas1->valorD;
                    }else if($deudas1->codigo == "10"){
                        $gestionCobran = $gestionCobran + $deudas1->valorD;
                        $totalgestionCobran = $totalgestionCobran + $gestionCobran;
                    }else if($deudas1->codigo == "P"){
                        $prestamo = $deudas1->valorD;
                        $totalprestamo = $totalprestamo + $prestamo;
                    }else if($deudas1->codigo == "A"){
                        $anticipo = $deudas1->valorD;
                        $totalanticipo = $totalanticipo + $anticipo;
                    }else{
                        $varias = $varias + $deudas1->valorD;
                        $totalvarias = $totalvarias + $varias;
                    }
                    
                }
                $totalLinea1 = number_format($anticipo + $prestamo + $cuotaAd + $certificado + $prestamo + $anticipo + $dolar + $union + $ahorro + $varias + $fondo + $cuotaIng + $multas + $puntoEmi, 2, '.', "");
                $acmuladoLinea = $acmuladoLinea + $totalLinea1;
                $pagos[]=[
                    'Socio' => $sociosregistro->name_partner,
                    'codigoSocio' => $sociosregistro->code_trans,
                    'pago' => 0,
                    'cuenta' =>"",
                    'prestamo' => $prestamo,
                    'anticipo' => $anticipo,
                    'total' =>$totalLinea1,
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
                    'gestion'=>$gestionCobran,
                ]; 
                
            }
            //return $pagos;
            $identificacion= $sociosregistro->identification;
            $nombrePartner1= $sociosregistro->name_partner;
            $view = \View::make('Reportes.reporteSocioGeneral',compact(['pagos','fechaReporte','totalprestamo','totalanticipo','fecha1','fecha2','usuario','identificacion',
                                                                 'totalcuotaAd','totalcertificado','totalcuotaAd','totaldolar','totalunion','totalahorro','totalvarias','totalmultas',
                                                                 'totalgestionCobran','totalfondo','totalcuotaIng','totalpuntoEmi','acmuladoLinea','nombrePartner1']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream("Reporte de socio ".$sociosregistro->name_partner.'.pdf');
        }else{
            $detalleSocio = DB::table('partner')->where('id',$socio)->first();
            $dataPendiente = DB::table('partner_aditional_detail')->select('number_voucher','date_registre')->whereBetween('date_registre',[$fecha1,$fecha2])->where('status','PENDIENTE')->where('id_partner',$socio)->groupBy('number_voucher','date_registre')->get();
            $resultDeudas = $dataPendiente->toArray();
            
            $aux = 1;
            $pagos = [];
            $totalDeudaAuto= count($dataPendiente);            
            foreach ($resultDeudas as $deudas){
                $prestamo = 0;
                $anticipo = 0;
                $cuotaAd = 0;
                $certificado = 0;
                $dolar = 0;
                $union = 0;
                $ahorro = 0;
                $varias = 0;
                $multas = 0;
                $gestionCobran = 0;
                $fondo = 0;
                $multas = 0;
                $cuotaIng = 0;
                $puntoEmi = 0;
                $totalLinea1 = 0;
                $dataPendientetotal = DB::table('partner_aditional_detail')->whereBetween('date_registre',[$fecha1,$fecha2])->where('status','PENDIENTE')->where('id_partner',$socio)->where('number_voucher',$deudas->number_voucher)->get();
                $resultDeudas1 = $dataPendientetotal->toArray();
                foreach ($resultDeudas1 as $deudas1){
                    $cuentasmulta = DB::table('configuration_discount')->where('key_account', $deudas1->key_account)->where('code_account', $deudas1->code_account)->where('status',"activo")->where('code_discount',"10")->first();
                    $cuentasmulta1 = DB::table('configuration_discount')->where('key_account', $deudas1->key_account)->where('code_account', $deudas1->code_account)->where('status',"activo")->where('code_discount',"4")->first();
                    
                    if($deudas1->code_discount == "1"){
                        $cuotaAd = $deudas1->value_pending;
                        $totalcuotaAd = $totalcuotaAd + $cuotaAd;
                    }else if($deudas1->code_discount == "2"){
                        $certificado = $deudas1->value_pending;
                        $totalcertificado = $totalcertificado + $certificado;
                    }else if($deudas1->code_discount == "3"){
                        $dolar = $deudas1->value_pending;
                        $totaldolar = $totaldolar + $dolar;
                    }else if($deudas1->code_discount == "4"){
                        $union = $deudas1->value_pending;
                        $totalunion = $totalunion + $union ;
                    }else if($deudas1->code_discount == "5"){
                        $ahorro = $deudas1->value_pending;
                        $totalahorro = $totalahorro + $ahorro;
                    }else if($deudas1->code_discount == "6"){
                        $fondo = $deudas1->value_pending;
                        $totalfondo = $totalfondo + $fondo;
                    }else if($deudas1->code_discount == "7"){
                        $cuotaIng = $deudas1->value_pending;
                        $totalcuotaIng = $totalcuotaIng + $cuotaIng;
                    }else if($deudas1->code_discount == "8"){
                        $multa = $deudas1->value_pending;
                        $totalmultas = $totalmultas + $multa;
                    }else if($deudas1->code_discount == "9"){
                        $puntoEmi = $deudas1->value_pending;
                        $totalpuntoEmi =$totalpuntoEmi + $puntoEmi;
                    }else if($deudas1->code_discount == "10"){
                        $gestionCobran = $deudas1->value_pending;
                        $totalgestionCobran = $totalgestionCobran + $gestionCobran;
                    }else{
                        $varias = $varias + $deudas1->value_pending;
                        $totalvarias = $totalvarias + $varias;
                    }
                }
                $totalLinea1 = number_format($anticipo + $prestamo + $cuotaAd + $certificado + $dolar + $union + $ahorro + $varias + $fondo + $cuotaIng + $multas + $puntoEmi, 2, '.', "");
                $acmuladoLinea = $acmuladoLinea + $totalLinea1;
                $pagos[]=[
                    'comprobante' => $deudas->number_voucher,
                    'date_registre' => $deudas->date_registre,
                    'pago' => 0,
                    'cuenta' =>"",
                    'prestamo' => $prestamo,
                    'anticipo' => $anticipo,
                    'total' =>$totalLinea1,
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
                    'gestion'=>$gestionCobran,
                ]; 
                $aux++;
            }
            $cuentasCobro = DB::table('advances_loan')->where('id_partner',$socio)->where('status','Aprobado')->where('value_pending','!=',0)->get();
            if(isset($cuentasCobro)){
                $index = 1;
                $TotalLinea = 0;
                foreach ($cuentasCobro as $deudasPrestamo){
                    
                    $cuentasDetalle = DB::table('detail_advance_loan')->where('id_advances_loan',$deudasPrestamo->id)->where('status','PENDIENTE')->whereBetween('date_payment',[$fecha1,$fecha2])->get();
                    if(isset($cuentasCobro)){
                        foreach ($cuentasDetalle as $detallePrestamo){
                            if($deudasPrestamo->type_prestamo == "P"){
                                $prestamo =  $detallePrestamo->value_unit;
                                $totalprestamo =  $totalprestamo + $prestamo;
                                
                            }else{
                                $anticipo = $detallePrestamo->value_unit;
                                $totalanticipo = $totalanticipo + $anticipo;
                            }
                            
                            $TotalLinea = number_format($anticipo + $prestamo, 2, '.', "");
                            $acmuladoLinea = $acmuladoLinea + $TotalLinea;
                            $pagos[]=[
                                'comprobante' => 0,
                                'date_registre' => $detallePrestamo->date_payment,
                                'pago' => 0,
                                'cuenta' =>"",
                                'prestamo' => $prestamo,
                                'anticipo' => $anticipo,
                                'total' =>$TotalLinea,
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
                                'gestion'=>$gestionCobran,
                            ]; 
                        }
                    }
                    
                    $index++;
                }
            }
            $identificacion= $detalleSocio->identification;
            $nombrePartner1= $detalleSocio->name_partner;
            $view = \View::make('Reportes.reporteSocio',compact(['pagos','fechaReporte','totalprestamo','totalanticipo','fecha1','fecha2','usuario','identificacion',
                                                                 'totalcuotaAd','totalcertificado','totalcuotaAd','totaldolar','totalunion','totalahorro','totalvarias','totalmultas',
                                                                 'totalgestionCobran','totalfondo','totalcuotaIng','totalpuntoEmi','acmuladoLinea','nombrePartner1']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream("Reporte de socio ".$detalleSocio->name_partner.'.pdf');
        }
        
        //return $pdf->download("Comprobante ".$cabecera->number_voucher.'.pdf');
        //return $data;
    }


}
