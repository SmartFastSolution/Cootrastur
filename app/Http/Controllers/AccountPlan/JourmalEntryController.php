<?php

namespace App\Http\Controllers\AccountPlan;

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

class JourmalEntryController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function JourmalEntrylist(){
        return view('cruds.account.cuenta.indexseat');
    }
   

    public function SaveJourmalEntry(Request $request)
    {
         $cuentas = $request->cuentas;
    
    }

    public function cuentasContable(Request $request){
        $codigo = $request->code;
        $result1 = DB::table('account_plan')
                ->select('key_account','code_account','description')
                ->where('status', 'activo')
                ->where('code_account',$codigo)
                ->get();
        if(count($result1)== 0){
            $result1 = DB::table('account_plan')
                ->select('key_account','code_account','description')
                ->where('status', 'activo')
                ->where('key_account',$codigo)
                ->get();
        }
        return $result1;
    }

    public function guardarAsiento(Request $request){
        $codigo = $request->code_voucher;
        $fechaV = $request->date_voucher;
        $descripcion = $request->descripcionA;
        $detalle = $request->detail;
        $i = 1;
        DB::beginTransaction();
        try{
            $seq = DB::table('sequential')->where('id', 1)->first();
            $numeroVoucher =$seq->id_compro;
            DB::table('account_header')->insert([
                'code_voucher' =>  $codigo,
                'date_voucher' => Carbon::parse($fechaV),
                'number_voucher' => $numeroVoucher,
                'header_description' =>  $descripcion,
                'status' => "BORRADOR",
            ]);
    
            $idheader = DB::getPdo()->lastInsertId();
    
            if($detalle == null || $detalle == ''){
    
            }else{
                foreach($detalle as $d) {
                    DB::table('account_detail')->insert([
                        'key_account' =>  $d['key_account'],
                        'code_account' => $d['code_account'],
                        'description_account' => $d['descripcionAsiento'],
                        'line' => $i,
                        'value_debito' => $d['debe'],
                        'Value_credito' => $d['haber']*-1,
                        'reference' => ($d['referencia'] == "" ? "":$d['referencia']),
                        'id_header'=>$idheader,
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

    public function buscarDetalle(Request $request){
        $id_header = $request->id;
        $cabecera = DB::table('account_header')
                    ->select('account_header.code_voucher','account_header.date_voucher','account_header.header_description','account_header.status')
                    ->where('account_header.id',$id_header)->first();
        $resultado = DB::table('account_detail')
                ->select('account_detail.key_account','account_detail.code_account','account_detail.value_debito','account_detail.value_credito','account_detail.reference','account_detail.description_account')
                ->where('id_header',$id_header)
                ->get();
        $result = $resultado->toArray();
        foreach ($result as $nuevo){
            $nuevaData[]=[
                'code_voucher' => $cabecera->code_voucher,
                'date_voucher' => $cabecera->date_voucher,
                'header_description' => $cabecera->header_description,
                'estado' => $cabecera->status,
                'id' => $id_header,
                'key_account'=> $nuevo->key_account,
                'code_account'=>$nuevo->code_account,
                'description_account'=>$nuevo->description_account,
                'value_debito'=>$nuevo->value_debito,
                'value_credito'=>$nuevo->value_credito,
                'reference'=>$nuevo->reference,
            ];
        }
        return $nuevaData;
    }

    public function descargarPDF(Request $request){
        $comprobante = $request->comp;
        $fecha = Carbon::now();
        $usuario = Auth::user()->name;
        $cabecera = DB::table('account_header')->where('id', $comprobante)->first();
        if (isset($cabecera)) {
            $cuentaSocio = DB::table('account_detail')
                            ->join('partner', 'partner.code_account', '=', 'account_detail.code_account')
                            ->where('id_header', $comprobante)->first();
            $detalle = DB::table('account_detail')
                        ->select('account_detail.key_account', 'account_detail.code_account','account_plan.description', 'account_detail.value_debito', 'account_detail.value_credito')
                        ->join('account_plan', 'account_plan.code_account', '=', 'account_detail.code_account') 
                        ->where('id_header', $comprobante)->get();
            if(isset($cuentaSocio)){
                $datosSocio = DB::table('partner')->where('code_account', $cuentaSocio->code_account)->first();
            }else{
                $datosSocio = "";
            }
            
            $total_debito=DB::table('account_detail')->select(DB::raw("SUM(value_debito) as debito"))->where('id_header', $comprobante)->first();
            $total_crebito=DB::table('account_detail')->select(DB::raw("SUM(value_credito) as credito"))->where('id_header', $comprobante)->first();
            $view = \View::make('Reportes.reporteAsientos',compact(['datosSocio','detalle','total_debito','total_crebito','cabecera','fecha','usuario']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream("Asiento contable ".$cabecera->number_voucher.'.pdf');
            //return $pdf->download("Comprobante ".$cabecera->number_voucher.'.pdf');
        }
    }

    public function actualizarAsiento(Request $request){
        $codigo = $request->code_voucher;
        $fechaV = $request->date_voucher;
        $descripcion = $request->descripcionA;
        $detalle = $request->detail;
        $id_header = $request->id_header;
        $i=1;
        $numeroVoucher = DB::table('account_header')->where('id',$id_header)->first();
        DB::beginTransaction();
        try{

            DB::table('account_header')->where('id',$id_header)->update([
                'header_description' => $descripcion,
                'date_voucher' =>Carbon::parse($fechaV),
            ]);
            if($detalle == null || $detalle == ''){
    
            }else{
                DB::table('account_detail')->where('id_header', $id_header)->delete();
                foreach($detalle as $d) {
                    DB::table('account_detail')->insert([
                        'key_account' =>  $d['key_account'],
                        'code_account' => $d['code_account'],
                        'description_account' => $d['descripcionAsiento'],
                        'line' => $i,
                        'value_debito' => $d['debe'],
                        'Value_credito' => $d['haber']*-1,
                        'reference' => ($d['referencia'] == "" ? "":$d['referencia']),
                        'id_header'=>$id_header,
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
  
    public function EliminarAsiento(Request $request){
        
        $id = $request->id;
        DB::table('account_detail')->where('id_header',$id)->delete();
        DB::table('account_header')->where('id',$id)->delete();
        return "OK";
    }

    public function AprobarAsiento(Request $request){
        $id = $request->id;
        $fecha = Carbon::now()->format('Y/m/d');
        $separarFecha = explode("/", $fecha);
        $estado = DB::table('account_header')->where('id',$id)->first();
        if($estado->status == "BORRADOR"){
            $estado->status = $estado->status == 'BORRADOR' ? 'CONTABILIZADO' : 'BORRADOR';
            DB::table('account_header')->where('id',$id)->update([
                'status' => $estado->status
            ]);
            $idSocio = 0;
            if($estado->status == "CONTABILIZADO"){
                $detalle =  DB::table('account_detail')->where('id_header',$id)->get();
                foreach($detalle as $buscarProveedor) {
                    $reducirSocio = DB::table('partner')->where('code_account',$buscarProveedor->code_account)->first();
                    if(isset($reducirSocio)){
                        $idSocio = $reducirSocio->id; 
                    }
                }
                foreach($detalle as $d) {
                    $cuentaSocio = DB::table('partner')->where('code_account',$d->code_account)->first();
                    if(!isset($cuentaSocio)){
                        $cuentasCobro1 = DB::table('charges')->where('key_account', $d->key_account)->where('code_account', $d->code_account)->where('status',"activo")->first();
                        DB::table('partner_aditional_detail')->insert([
                            'id_partner' => $idSocio,
                            'key_account' =>  $d->key_account,
                            'code_account' => $d->code_account,
                            'code_discount' => (isset($cuentasCobro1->type_cobros) ? $cuentasCobro1->type_cobros: 0),
                            'status' => "PENDIENTE",
                            'date_registre' => Carbon::now(),
                            'month' => (int)$separarFecha[1],
                            'year' => $separarFecha[0],
                            'value_pending'=>($d->value_debito > 0 ? $d->value_debito : $d->value_credito * -1),
                            'number_voucher'=>$estado->number_voucher,
                            'value_total'=>($d->value_debito > 0 ? $d->value_debito : $d->value_credito * -1),
                        ]);
                    }
                    /*$descuentoDisminuir = DB::table('configuration_discount')->where('code_account',$d->code_account)->where('key_account',$d->key_account)->where('id_partner',$idSocio)->first();
                    if(isset($descuentoDisminuir)) {
                        if($descuentoDisminuir->type_payment == "E"){
                           // $configs = include('../config/config.php');
                            $socio = DB::table('voucher_header')->where('id',$id)->first();
                            $reducirSocio = DB::table('partner_aditional')->where('id_partner',$idSocio)->first();
                            /////////////////////BUSCAR EL CAMPO AL QUE TENGO QUE RESTAR /////////////////////////
                            if($descuentoDisminuir->code_discount == "1"){
                                $otrosDescuentos = $reducirSocio->payment_aditional;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'payment_aditional' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "2"){
                                $otrosDescuentos = $reducirSocio->safe_vehicule;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'safe_vehicule' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "3"){
                                $otrosDescuentos = $reducirSocio->satellite;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'satellite' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "5"){
                                $otrosDescuentos = $reducirSocio->saving;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'saving' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "6"){
                                $otrosDescuentos = $reducirSocio->other;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'other' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "7"){
                                $otrosDescuentos = $reducirSocio->iess;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'iess' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "8"){
                                $otrosDescuentos = $reducirSocio->garage;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'garage' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "9"){
                                $otrosDescuentos = $reducirSocio->cleaning;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'cleaning' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "10"){
                                $otrosDescuentos = $reducirSocio->penalty_fee;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito, 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'penalty_fee' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "11"){
                                $otrosDescuentos = $reducirSocio->safe_internal;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito, 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'safe_internal' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "12"){
                                $otrosDescuentos = $reducirSocio->store;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito, 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'store' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "13"){
                                $otrosDescuentos = $reducirSocio->membership;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'membership' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "4"){
                                $otrosDescuentos = $reducirSocio->ptmo;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'ptmo' => $nuevoValor
                                ]);
                            }
                        }
                    }*/
                }
                return "OK";
            }
        }else{
            return "ERROR";
        }   
    }
}
