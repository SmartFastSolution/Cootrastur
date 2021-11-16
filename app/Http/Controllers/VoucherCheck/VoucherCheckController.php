<?php

namespace App\Http\Controllers\VoucherCheck;

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

class VoucherCheckController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function Voucherlist(){
        return view('cruds.vouchers.facturas.index');
    }
   

    public function SaveJourmalEntry(Request $request)
    {
         $cuentas = $request->cuentas;
    
    }

    public function cuentasContable(Request $request){
        $codigo = $request->code;
        $nuevaData = [];
        $valorRetener = DB::table('items_percentage')->where('code_account',$codigo)->first();
        $otherValores = DB::table('charges')->where('code_account',$codigo)->first();
        //$valorRetener = DB::table('configuration_retention')->where('code_account',$codigo)->first();
        $result1 = DB::table('account_plan')
                ->select('key_account','code_account','description')
                ->where('status', 'activo')
                ->where('code_account',$codigo)
                ->get();
        if(count($result1)== 0){
            //$valorRetener = DB::table('configuration_retention')->where('key_account',$codigo)->first();
            $valorRetener = DB::table('items_percentage')->where('key_account',$codigo)->first();
        $otherValores = DB::table('charges')->where('key_account',$codigo)->first();
            $result1 = DB::table('account_plan')
                ->select('key_account','code_account','description')
                ->where('status', 'activo')
                ->where('key_account',$codigo)
                ->get();
        }
        if(count($result1)>=1){
            $result = $result1->toArray();
            foreach ($result as $nuevo){
                $nuevaData[]=[
                    'key_account'=> $nuevo->key_account,
                    'code_account'=>$nuevo->code_account,
                    'description'=>$nuevo->description,
                    'valor_normal'=>(isset($valorRetener) ? ($valorRetener->type == "V" ? $valorRetener->value : 0) : (isset($otherValores) ? ($otherValores->type_charges == "V" ? $otherValores->value : 0) : 0)),
                    'valor_retener' => (isset($valorRetener) ? ($valorRetener->type == "P" ? $valorRetener->value : "N") : (isset($otherValores) ? ($otherValores->type_charges == "P" ? $otherValores->value : "N") : "N")),
                    'numerodeuda' =>0,
                ];
            }
        }   
        return $nuevaData;
    }


    public function buscarDetalle(Request $request){
        $id_header = $request->id;
        $cabecera = DB::table('voucher_header')
                    ->select('voucher_header.date_registre','voucher_header.number_check_voucher','voucher_header.number_autorization','voucher_header.type_document','voucher_header.number_check','voucher_header.date_check','voucher_header.total_value'
                            ,'voucher_header.detail_voucher','voucher_header.status','voucher_header.id_bank','voucher_header.id_proveedor')
                    ->join('bank', 'bank.id', '=', 'voucher_header.id_bank')
                    ->where('voucher_header.id',$id_header)->first();
        $datosProveedor = DB::table('partner')->where('id',$cabecera->id_proveedor)->first();
        $resultado = DB::table('voucher_detail')
                ->select('voucher_detail.key_account','voucher_detail.code_account','voucher_detail.value_debito','voucher_detail.value_credito','voucher_detail.reference_voucher','account_plan.description','voucher_detail.voucher_deuda')
                ->join('account_plan', 'account_plan.code_account', '=', 'voucher_detail.code_account')
                ->where('id_vheader',$id_header)
                ->get();
        $result = $resultado->toArray();
        foreach ($result as $nuevo){
            $valorRetener = DB::table('items_percentage')->where('code_account',$nuevo->code_account)->where('key_account',$nuevo->key_account)->first();
            $otherValores = DB::table('charges')->where('code_account',$nuevo->code_account)->where('key_account',$nuevo->key_account)->first();
            $nuevaData[]=[
                'fecha' => $cabecera->date_registre,
                'idProveedor' => $cabecera->id_proveedor,
                'identificacion' => $datosProveedor->identification,
                'tipoDocumento' => $cabecera->type_document,
                'numeroDocumento' => $cabecera->number_check,
                'fechaDocumento' => $cabecera->date_check,
                'beneficiario' => $datosProveedor->name_partner,
                'valor' => $cabecera->total_value,
                'detalle' => $cabecera->detail_voucher,
                'estado' => $cabecera->status,
                'banco' => $cabecera->id_bank,
                'key_account'=> $nuevo->key_account,
                'code_account'=>$nuevo->code_account,
                'description'=>$nuevo->description,
                'value_debito'=>$nuevo->value_debito,
                'value_credito'=>$nuevo->value_credito,
                'reference_voucher'=>$nuevo->reference_voucher,
                'valor_retener' => (isset($valorRetener) ? ($valorRetener->type == "P" ? $valorRetener->value : "N") : (isset($otherValores) ? ($otherValores->type_charges == "P" ? $otherValores->value : "N") : "N")),
                'numerodeuda' =>$nuevo->voucher_deuda,

                'cheque_factura'=>$cabecera->number_check_voucher,
                'autorizacion'=>$cabecera->number_autorization,
            ];
        }
        return $nuevaData;
    }

    public function buscarSocio(Request $request){
        $id_socio = $request->id;
        $resultado = DB::table('partner')
                ->where('id',$id_socio)
                ->get();
        return $resultado;
    }

    public function guardarFactura(Request $request){
        $id_bank = $request->code_account;
        $numero_factura = $request->number_voucher;
        $fecha_registro = $request->date_registre;
        $tipo_documento = $request->tipo_documento;
        $fecha_cheque = $request->date_check;
        $proveedor = $request->id_proveedor;
        $numero_cheque = $request->number_check;

        $numero_cheque_factura = $request->number_cheque;
        $numero_autorizacion = $request->number_autorization;

        $total = $request->total_value;
        $referencia = $request->header_description;
        $detalle = $request->detail;
        $i = 1;
        DB::beginTransaction();
        try{
            $seq = DB::table('sequential')->where('id', 1)->first();
            $numeroVoucher =$seq->id_compro;
            DB::table('voucher_header')->insert([
                'id_bank' =>  $id_bank,
                'number_voucher' => $numeroVoucher,
                'date_registre' => Carbon::parse($fecha_registro),
                'date_check' => Carbon::parse($fecha_cheque),
                'id_proveedor' => $proveedor,
                'number_check' => $numero_cheque,
                'total_value' =>  $total,
                'detail_voucher' => $referencia,
                'type_document'=>$tipo_documento,
                'date_voucher' => Carbon::now(),
                'status' => "BORRADOR",
                'number_check_voucher' => $numero_cheque_factura,
                'number_autorization' => $numero_autorizacion,

            ]);
    
            $idheader = DB::getPdo()->lastInsertId();
    
            if($detalle == null || $detalle == ''){
    
            }else{
                foreach($detalle as $d) {
                    DB::table('voucher_detail')->insert([
                        'key_account' =>  $d['key_account'],
                        'code_account' => $d['code_account'],
                        'line' => $i,
                        'value_debito' => $d['debe'],
                        'Value_credito' => $d['haber']*-1,
                        'id_vheader'=>$idheader,
                        'reference_voucher'=>($d['referencia'] == "" ? "":$d['referencia']),
                        'voucher_deuda' => $d['voucher_deuda'],
                    ]);
    
                    $i++;
                }
            }
            DB::table('sequential')->where('id', 1)->update([
                'id_compro' => $numeroVoucher+1
            ]);
            DB::commit();
            return  $numeroVoucher;
        } catch(\Exception $e){
            DB::rollBack();
            abort(500, $e->getMessage());
        } 
        //return $detalle;
    }

    public function actualizarVoucher(Request $request){
        $id_bank = $request->code_account;
        $numero_factura = $request->number_voucher;
        $fecha_registro = $request->date_registre;

        $numero_cheque_factura = $request->number_cheque;
        $numero_autorizacion = $request->number_autorization;

        $fecha_cheque = $request->date_check;
        $proveedor = $request->id_proveedor;
        $numero_cheque = $request->number_check;
        $tipo_documento = $request->tipo_documento;
        $total = $request->total_value;
        $referencia = $request->header_description;
        $detalle = $request->detail;
        $id_vheader = $request->id_vheader;
        $i=1;
        $numeroVoucher = DB::table('voucher_header')->where('id',$id_vheader)->first();
        DB::beginTransaction();
        try{

            DB::table('voucher_header')->where('id',$id_vheader)->update([
                'id_bank'=> $id_bank,
                'detail_voucher' => $referencia,
                'date_registre' =>Carbon::parse($fecha_registro)->toDateTimeString(),
                'date_check' =>Carbon::parse($fecha_cheque),
                'id_proveedor' =>$proveedor,
                'number_check' =>$numero_cheque,
                'total_value' =>$total,
                'type_document'=>$tipo_documento,
                'number_check_voucher' => $numero_cheque_factura,
                'number_autorization' => $numero_autorizacion,
            ]);
            if($detalle == null || $detalle == ''){
    
            }else{
                DB::table('voucher_detail')->where('id_vheader', $id_vheader)->delete();
                foreach($detalle as $d) {
                    DB::table('voucher_detail')->insert([
                        'key_account' =>  $d['key_account'],
                        'code_account' => $d['code_account'],
                        'line' => $i,
                        'value_debito' => $d['debe'],
                        'Value_credito' => $d['haber']*-1,
                        'id_vheader'=>$id_vheader,
                        'reference_voucher'=>($d['referencia'] == "" ? "":$d['referencia']),
                        'voucher_deuda' => $d['voucher_deuda'],
                    ]);
    
                    $i++;
                }
            }
            DB::commit();
            return  $numeroVoucher->number_voucher;
        } catch(\Exception $e){
            DB::rollBack();
            abort(500, $e->getMessage());
        } 
        //return $detalle;
    }
    
    public function consultaSocios(Request $request){
        $identificacion = $request->identification;
        $result1 = DB::table('partner')
                ->select('id','identification','name_partner')
                ->where('status', 'activo')
                ->where('identification',$identificacion)
                ->orderby('name_partner','ASC')->get();
        return $result1;
    }

    public function descargarPDF(Request $request){
        $comprobante = $request->comp;
        $fecha = Carbon::now();
        $usuario = Auth::user()->name;
        $cabecera = DB::table('voucher_header')->where('id', $comprobante)->first();
        if (isset($cabecera)) {
            $banco = DB::table('bank')->where('id',$cabecera->id_bank)->first();
            $datosSocio = DB::table('partner')->where('id', $cabecera->id_proveedor)->first();
            //$valorCheque = DB::table('voucher_detail')->where('id_vheader', $comprobante)->where('key_account',$datosSocio->key_account)->first();
            $detalle = DB::table('voucher_detail')
                        ->select('voucher_detail.key_account', 'voucher_detail.code_account','account_plan.description', 'voucher_detail.value_debito', 'voucher_detail.value_credito')
                        ->join('account_plan', 'account_plan.code_account', '=', 'voucher_detail.code_account') 
                        ->where('id_vheader', $comprobante)->get();
            $total_debito=DB::table('voucher_detail')->select(DB::raw("SUM(value_debito) as debito"))->where('id_vheader', $comprobante)->first();
            $total_crebito=DB::table('voucher_detail')->select(DB::raw("SUM(value_credito) as credito"))->where('id_vheader', $comprobante)->first();
            $view = \View::make('Reportes.reporteIngresos',compact(['datosSocio','detalle','total_debito','total_crebito','cabecera','fecha','usuario','banco']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream("Comprobante ".$cabecera->number_voucher.'.pdf');
            //return $pdf->download("Comprobante ".$cabecera->number_voucher.'.pdf');
        }
    }

    public function CuentasProveedor(Request $request){
        $idProveedor = $request->code;
        $fechaDia = Carbon::now()->format('Y/m/d');
        $year = Carbon::now()->format('Y');
        $mes = Carbon::now()->format('m');
        $data = [];
        $configs = include('../config/config.php');
        $cabeceraProveedor = DB::table('partner')->where('id', $idProveedor)->first();
        
        $datosCobro= DB::table('charges')
                            ->select('charges.code_account','account_plan.description','charges.type_charges','charges.value','charges.key_account','charges.type_cobros')
                            ->leftJoin('account_plan', function($join){
                                $join->on('account_plan.key_account', '=', 'charges.key_account');
                                $join->on('account_plan.code_account','=','charges.code_account');
                            })
                            ->where('charges.status',"activo")->get();
        if(count($datosCobro)>0){
            $result = $datosCobro->toArray();
            foreach ($result as $nuevo){
                if($nuevo->type_cobros == null){
                    if($nuevo->type_charges == "P"){
                        $data[]=[
                            'key'=> $nuevo->key_account,
                            'codigo'=>$nuevo->code_account,
                            'descripcion'=>$nuevo->description,
                            'valor_debito' =>0,
                            'valor_credito' =>0,
                            'valor_porcentaje'=>$nuevo->value,
                            'tipo_valor' =>$nuevo->type_charges,
                            'numerodeuda' =>0,
                        ];
                    }else{
                        $data[]=[
                            'key'=> $nuevo->key_account,
                            'codigo'=>$nuevo->code_account,
                            'descripcion'=>$nuevo->description,
                            'valor_debito' =>0,
                            'valor_credito' =>$nuevo->value,
                            'valor_porcentaje'=>"N",
                            'tipo_valor' =>$nuevo->type_charges,
                            'numerodeuda' =>0,
                        ];
                    }
                }
            }
        }
        $datosDeuda = DB::table('advances_loan')
                        ->select('advances_loan.id','advances_loan.key_account','advances_loan.code_account','advances_loan.type_prestamo','advances_loan.id_percentaje',
                                 'advances_loan.value_total','advances_loan.id_partner','advances_loan.value_pending','advances_loan.months','account_plan.description')
                        ->leftJoin('account_plan', function($join){
                            $join->on('account_plan.key_account', '=', 'advances_loan.key_account');
                            $join->on('account_plan.code_account','=','advances_loan.code_account');
                        })
                        ->where('advances_loan.id_partner', $idProveedor)
                        ->where('advances_loan.status', "Aprobado")->get();
        if(isset($datosDeuda)){
            $deuda = $datosDeuda->toArray();
            foreach ($deuda as $prestamos){
                $detalle = "";
                $detalleDeuda = DB::table('detail_advance_loan')->where('id_advances_loan', $prestamos->id)->where('status',"PENDIENTE")->whereDate('date_payment', '<=',$fechaDia)->where('year',$year)->orderBy('month_payment')->first();
                
                if(isset($detalleDeuda)){
                    
                
                    if($prestamos->type_prestamo == "P"){
                        $data[]=[
                            'key'=> $prestamos->key_account,
                            'codigo'=>$prestamos->code_account,
                            'descripcion'=>$prestamos->description,
                            'valor_debito' =>0,
                            'valor_credito' =>$detalleDeuda->value_unit,
                            'valor_porcentaje'=>"N",
                            'tipo_valor' =>"V",
                            'numerodeuda' =>0,
                        ];
                    }else{
                        
                        $data[]=[
                            'key'=> $prestamos->key_account,
                            'codigo'=>$prestamos->code_account,
                            'descripcion'=>$prestamos->description,
                            'valor_debito' =>0,
                            'valor_credito' =>$detalleDeuda->value_unit,
                            'valor_porcentaje'=>"N",
                            'tipo_valor' =>"V",
                            'numerodeuda' =>0,
                        ];
                        
                    }
                }
                
            }
            //return $data;
        }
        $fechaDia = Carbon::now()->format('Y/m/d');
        $separarFecha = explode("/", $fechaDia);
        $datosProveedor = DB::table('partner_aditional')->where('id_partner', $idProveedor)->first();
        if(isset($datosProveedor)){
            //$cuentaProveedor = DB::table('account_plan')->where('display', 'S')->where('status','activo')->where('key_account', $cabeceraProveedor->key_account)->first();
            $automaticos= DB::table('partner_aditional_detail')->where('status',"PENDIENTE")->where('id_partner',$idProveedor)->where('month','<=', $separarFecha[1])->where('year','<=', $separarFecha[0])->get();
            $deudaAuto = $automaticos->toArray();
            //return $deudaAuto;
            foreach ($deudaAuto as $deudautomaticos){
                $result1 = DB::table('account_plan')->where('status', 'activo')->where('key_account',$deudautomaticos->key_account)->where('code_account',$deudautomaticos->code_account)->first();
                //return $result1;
                $data[]=[
                    'key'=> $deudautomaticos->key_account,
                    'codigo'=>$deudautomaticos->code_account,
                    'descripcion'=>$result1->description,
                    'valor_debito' =>0,
                    'valor_credito' =>$deudautomaticos->value_pending,
                    'valor_porcentaje'=>"N",
                    'tipo_valor' =>"V",
                    'numerodeuda' =>$deudautomaticos->number_voucher,
                ];
            }
            return $data;   
        }else{
            return "ERROR";
        }

        
    }

    public function EliminarFactura(Request $request){
        
        $id = $request->id;
        DB::table('voucher_header')->where('id',$id)->delete();
        DB::table('voucher_detail')->where('id_vheader',$id)->delete();
        return "OK";
    }

    public function AprobarFactura(Request $request){
        
        $id = $request->id;
        $estado = DB::table('voucher_header')->where('id',$id)->first();
        if($estado->status == "BORRADOR"){
            $estado->status = $estado->status == 'BORRADOR' ? 'APROBADO' : 'BORRADOR';
            DB::table('voucher_header')->where('id',$id)->update([
                'status' => $estado->status
            ]);
            if($estado->status == "APROBADO"){
                $detalle =  DB::table('voucher_detail')->where('id_vheader',$id)->get();
                foreach($detalle as $d) {
                    DB::table('partner_aditional_detail')->where('number_voucher',$d->voucher_deuda)->where('code_account',$d->code_account)->where('key_account',$d->key_account)->where('id_partner',$estado->id_proveedor)->update([
                        'status' => "PAGADO",
                    ]);
                    /*$descuentoDisminuir = DB::table('configuration_discount')->where('code_account',$d->code_account)->where('key_account',$d->key_account)->where('id_partner',$estado->id_proveedor)->first();
                    if(isset($descuentoDisminuir)) {
                           // $configs = include('../config/config.php');
                            $socio = DB::table('voucher_header')->where('id',$id)->first();
                            $reducirSocio = DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->first();
                            /////////////////////BUSCAR EL CAMPO AL QUE TENGO QUE RESTAR /////////////////////////
                            if($descuentoDisminuir->code_discount == "1"){
                                $otrosDescuentos = $reducirSocio->payment_aditional;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'payment_aditional' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "2"){
                                $otrosDescuentos = $reducirSocio->safe_vehicule;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'safe_vehicule' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "3"){
                                $otrosDescuentos = $reducirSocio->satellite;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'satellite' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "5"){
                                $otrosDescuentos = $reducirSocio->saving;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'saving' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "6"){
                                $otrosDescuentos = $reducirSocio->other;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'other' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "7"){
                                $otrosDescuentos = $reducirSocio->iess;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'iess' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "8"){
                                $otrosDescuentos = $reducirSocio->garage;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'garage' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "9"){
                                $otrosDescuentos = $reducirSocio->cleaning;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'cleaning' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "10"){
                                $otrosDescuentos = $reducirSocio->penalty_fee;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito, 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'penalty_fee' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "11"){
                                $otrosDescuentos = $reducirSocio->safe_internal;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito, 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'safe_internal' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "12"){
                                $otrosDescuentos = $reducirSocio->store;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito, 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'store' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "13"){
                                $otrosDescuentos = $reducirSocio->membership;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'membership' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "4"){
                                $otrosDescuentos = $reducirSocio->ptmo;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_credito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$socio->id_proveedor)->update([
                                    'ptmo' => $nuevoValor
                                ]);
                            }
                    }*/
                    $prestamosDisminuir = DB::table('advances_loan')->where('code_account',$d->code_account)->where('key_account',$d->key_account)->where('id_partner',$estado->id_proveedor)->where('status','Aprobado')->first();
                    if(isset($prestamosDisminuir)) {
                        if($prestamosDisminuir->type_prestamo == "P"){
                            if($prestamosDisminuir->value_loan != NULL || $prestamosDisminuir->value_loan != "" || $prestamosDisminuir->value_loan != 0){
                                $valorInteres= $prestamosDisminuir->value_loan;
                            }else{
                                $valorInteres= 0;
                            }
                            $detalle = DB::table('detail_advance_loan')->where('id_advances_loan',$prestamosDisminuir->id)->where('status',"PENDIENTE")->orderBy('month_payment')->first();
                            //$valorPrestamo = number_format($prestamosDisminuir->value_pending - $detalle->value_pending , 2, '.', "");
                            DB::table('advances_loan')->where('id',$prestamosDisminuir->id)->update([
                                'value_pending' => $detalle->value_pending,
                                'value_loan' => $valorInteres + $detalle->value_interes
                            ]);
                            DB::table('detail_advance_loan')->where('id_advances_loan',$prestamosDisminuir->id)->where('status',"PENDIENTE")->where('month_payment',$detalle->month_payment)->update([
                                'status' => "PAGADO",
                                'number_document' => $estado->number_voucher
                            ]);
                            if($detalle->value_pending == 0){
                                DB::table('advances_loan')->where('id',$prestamosDisminuir->id)->update([
                                    'status' => "Pagado",
                                ]);
                            }
                        }else{
                            $detalle = DB::table('detail_advance_loan')->where('id_advances_loan',$prestamosDisminuir->id)->where('status',"PENDIENTE")->orderBy('month_payment')->first();;
                            $valorPrestamo = number_format($prestamosDisminuir->value_pending - $detalle->value_unit , 2, '.', "");
                            DB::table('advances_loan')->where('id',$prestamosDisminuir->id)->update([
                                'value_pending' => $valorPrestamo
                            ]);
                            DB::table('detail_advance_loan')->where('id_advances_loan',$prestamosDisminuir->id)->where('status',"PENDIENTE")->where('month_payment',$detalle->month_payment)->update([
                                'status' => "PAGADO",
                                'number_document' => $estado->number_voucher
                            ]);
                            if($prestamosDisminuir->value_pending == 0){
                                DB::table('advances_loan')->where('id',$prestamosDisminuir->id)->update([
                                    'status' => "Pagado",
                                ]);
                            }
                        }
                        
                    }
                }
                return "OK";
            }
        }else{
            return "ERROR";
        }  
    }
    

}
