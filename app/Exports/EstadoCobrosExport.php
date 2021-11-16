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

class EstadoCobrosExport implements FromView,WithColumnWidths,WithStyles {

    use Exportable;
    public function __construct($comp,$fechaini1,$fechafin1)
    {
        $this->comp = $comp;
        $this->fechaini = $fechaini1;
        $this->fechafin = $fechafin1;
    }
    public function view(): view
    {
        $pagos = [];
        $datafactura = DB::table('voucher_header')->whereBetween('date_voucher',[$this->fechaini,$this->fechafin])->where('status','APROBADO')->where('id_proveedor',$this->comp)->get();
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
                $cuentasCobro = DB::table('advances_loan')->where('key_account', $detallepagos->key_account)->where('code_account', $detallepagos->code_account)->where('id_partner',$this->comp)->where('status','Aprobado')->first();
                if(isset($cuentasCobro)){
                    $flag = "N";
                    if($cuentasCobro->type_prestamo == "P"){
                        $prestamo = $detallepagos->value_credito;
                    }else{
                        $anticipo = $detallepagos->value_credito;
                    }
                }
                /*$cuentaPaga = DB::table('bank')->where('key_account', $detallepagos->key_account)->where('code_account', $detallepagos->code_account)->first();
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
                }*/
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
        return view('cruds.accountsatussocios.estadocuenta.cobrosEstadoExcel', compact('pagos'));
        
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