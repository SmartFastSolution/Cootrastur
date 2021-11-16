<?php

namespace App\Exports;

use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\withHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class EstadoDeudaExport implements FromView,WithColumnWidths,WithStyles {

    use Exportable;
    public function __construct($comp,$fechaini1,$fechafin1)
    {
        $this->comp = $comp;
        $this->fechaini = $fechaini1;
        $this->fechafin = $fechafin1;
    }
    public function view(): view
    {
        $dataPendiente = DB::table('partner_aditional_detail')->select('number_voucher','date_registre')->whereBetween('date_registre',[$this->fechaini,$this->fechafin])->where('status','PENDIENTE')->where('id_partner',$this->comp)->groupBy('number_voucher','date_registre')->get();
        $resultDeudas = $dataPendiente->toArray();
        $aux = 1;
        $pagos = [];
        //$separarFecha = explode("/", Carbon::parse($fecha_ini)->format('Y/m/d'));
        //$separarFecha2 = explode("/",Carbon::parse($fecha_fin)->format('Y/m/d'));
        //$mesVlidacion = (int)$separarFecha[1];
        $totalDeudaAuto= count($dataPendiente);
        //return $dataPendiente;
        
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
            $dataPendientetotal = DB::table('partner_aditional_detail')->whereBetween('date_registre',[$this->fechaini,$this->fechafin])->where('status','PENDIENTE')->where('id_partner',$this->comp)->where('number_voucher',$deudas->number_voucher)->get();
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
                'gestion'=>$gestionCobran,
            ]; 
            $aux++;
        }
        $cuentasCobro = DB::table('advances_loan')->where('id_partner',$this->comp)->where('status','Aprobado')->where('value_pending','!=',0)->get();
        if(isset($cuentasCobro)){
            $index = 1;
            foreach ($cuentasCobro as $deudasPrestamo){
                $cuentasDetalle = DB::table('detail_advance_loan')->where('id_advances_loan',$deudasPrestamo->id)->where('status','PENDIENTE')->whereBetween('date_payment',[$this->fechaini,$this->fechafin])->get();
                if(isset($cuentasCobro)){
                    foreach ($cuentasDetalle as $detallePrestamo){
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
                            'gestion'=>$gestionCobran,
                        ]; 
                    }
                }
                
                $index++;
            }
        }
        return view('cruds.accountsatussocios.estadocuenta.deudaEstadosExcel', compact('pagos'));
        
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,            
            'C' => 10,            
            'D' => 10,
            'E' => 10,  
            'F' => 10,
            'G' => 10,            
            'H' => 10,            
            'I' => 10,
            'J' => 10,  
            'K' => 10,
            'L' => 10,            
            'M' => 10,            
            'N' => 10,
            'O' => 10,             
        ];
    }

      public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
    

}