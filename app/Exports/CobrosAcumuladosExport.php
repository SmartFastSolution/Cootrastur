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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CobrosAcumuladosExport implements FromView,WithColumnWidths,WithStyles,WithColumnFormatting {

    use Exportable;
    public function __construct($fechaini1,$fechafin1,$comp)
    {
        $this->comp = $comp;
        $this->fechaini = $fechaini1;
        $this->fechafin = $fechafin1;
    }
    public function view(): view
    {
        $idSocio = $this->comp;
        //$fecha_ini = $request->fechaini;
        //$fecha_fin = $request->fechafin;
        $pagos = [];
        $datosSocios = [];
        if($idSocio != "ALL"){
            $datosSocios = DB::table('partner')->where('id', $idSocio)->where('status','activo')->get();
        }else{
            $datosSocios = DB::table('partner')->where('status','activo')->get();
        }
        foreach ($datosSocios as $datoPartner){
            $datafactura = DB::table('voucher_header')->whereBetween('date_registre',[$this->fechaini,$this->fechafin])->where('status','APROBADO')->where('id_proveedor',$datoPartner->id)->get();
            $result = $datafactura->toArray();
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
            foreach ($result as $cabecera){
                $detalle = DB::table('voucher_detail')->where('id_vheader', $cabecera->id)->get();
                $resultdetalle = $detalle->toArray();
                
                foreach ($resultdetalle as $detallepagos){
                    $flag = "Y";
                    $cuentasCobro1 = DB::table('charges')->where('key_account', $detallepagos->key_account)->where('code_account', $detallepagos->code_account)->where('status',"activo")->first();
                    if(isset($cuentasCobro1)){
                        $flag = "N";
                        if($cuentasCobro1->type_cobros != "" || $cuentasCobro1->type_cobros != null ){
                            if($cuentasCobro1->type_cobros == "1"){
                                $cuotaAd = $detallepagos->value_credito + $cuotaAd;
                            }else if($cuentasCobro1->type_cobros == "2"){
                                $certificado = $detallepagos->value_credito + $certificado;
                            }else if($cuentasCobro1->type_cobros == "3"){
                                $dolar = $detallepagos->value_credito + $dolar;
                            }else if($cuentasCobro1->type_cobros == "4"){
                                $union = $detallepagos->value_credito + $union;
                            }else if($cuentasCobro1->type_cobros == "5"){
                                $ahorro = $detallepagos->value_credito + $ahorro;
                            }else if($cuentasCobro1->type_cobros == "6"){
                                $fondo = $detallepagos->value_credito + $fondo;
                            }else if($cuentasCobro1->type_cobros == "7"){
                                $cuotaIng = $detallepagos->value_credito + $cuotaIng;
                            }else if($cuentasCobro1->type_cobros == "8"){
                                $multa = $detallepagos->value_credito + $multa;
                            }else if($cuentasCobro1->type_cobros == "9"){
                                $puntoEmi = $detallepagos->value_credito + $puntoEmi;
                            }else if($cuentasCobro1->type_cobros == "10"){
                                $gestionCobran = $detallepagos->value_credito + $gestionCobran;
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
                    $cuentasCobro = DB::table('advances_loan')->where('key_account', $detallepagos->key_account)->where('code_account', $detallepagos->code_account)->where('id_partner',$datoPartner->id)->where('status','Aprobado')->first();
                    if(isset($cuentasCobro)){
                        $flag = "N";
                        if($cuentasCobro->type_prestamo == "P"){
                            $prestamo = $detallepagos->value_credito + $prestamo;
                        }else{
                            $anticipo = $detallepagos->value_credito + $anticipo;
                        }
                    }
                    $cuentaPaga = DB::table('bank')->where('key_account', $detallepagos->key_account)->where('code_account', $detallepagos->code_account)->first();
                    if(isset($cuentaPaga)){
                        $flag = "N";
                        
                    }
                    if($flag == "Y"){
                        $varias = number_format($varias + $detallepagos->value_credito , 2, '.', "");
                    }
                }
                
            }
            $pagos[]=[
                'codigo' => $datoPartner->code_trans,
                'identification' => $datoPartner->identification,
                'socio' =>$datoPartner->name_partner,
                'prestamo' => $prestamo,
                'anticipo' => $anticipo,
                'total' =>number_format($anticipo + $prestamo + $cuotaAd + $certificado + $dolar + $union + $ahorro + $varias + $fondo + $cuotaIng + $multas + $puntoEmi, 2, '.', ""),
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
        return view('cruds.reportes.cobrosAcumuladosExcel', compact('pagos'));
        
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,            
            'C' => 40,            
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
            'P' => 10,
            'Q' => 10,            
        ];
    }

      public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }


}