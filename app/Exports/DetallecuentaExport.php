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

class DetallecuentaExport implements FromView,WithColumnWidths,WithStyles,WithColumnFormatting {

    use Exportable;
    public function __construct($fechaini1,$fechafin1,$cuenta,$codigo)
    {
        $this->cuenta = $cuenta;
        $this->codigo = $codigo;
        $this->fechaini = $fechaini1;
        $this->fechafin = $fechafin1;
    }
    public function view(): view
    {
        $total = 0;
        $acumulacion=0;
        $totaldebito = 0;
        $totalcredito = 0;
        //$cuenta=DB::table('account_plan')->where('code_account',$this->cuenta)->where('key_account',$this->codigo)->where('status', 'activo')->first();
            $asientos = DB::table('account_detail')
                                    ->select('account_detail.id_header as id',DB::raw('account_detail.value_debito as debito,account_detail.value_credito as credito'))
                                    ->leftJoin('account_header', 'account_detail.id_header', '=', 'account_header.id')
                                    ->where('account_header.status',"CONTABILIZADO")
                                    ->whereBetween('account_header.date_voucher',[$this->fechaini,$this->fechafin])
                                    ->where('account_detail.code_account',$this->cuenta)
                                    ->where('account_detail.key_account',$this->codigo);
            
            $movimientos = DB::table('voucher_detail')
                                    ->select('voucher_detail.id_vheader as id',DB::raw('voucher_detail.value_debito as debito,voucher_detail.value_credito as credito'))
                                    ->leftJoin('voucher_header', 'voucher_detail.id_vheader', '=', 'voucher_header.id')
                                    ->where('voucher_header.status',"APROBADO")
                                    ->whereBetween('voucher_header.date_registre',[$this->fechaini,$this->fechafin])
                                    ->where('voucher_detail.code_account',$this->cuenta)
                                    ->where('voucher_detail.key_account',$this->codigo)
                                    ->union($asientos)
                                    ->get();

            if(count($movimientos) == 0){
                $asientos = DB::table('account_detail')
                    ->select('account_detail.id_header as id',DB::raw('account_detail.value_debito as debito,account_detail.value_credito as credito'))
                    ->leftJoin('account_header', 'account_detail.id_header', '=', 'account_header.id')
                    ->where('account_header.status',"CONTABILIZADO")
                    ->whereBetween('account_header.date_voucher',[$this->fechaini,$this->fechafin])
                    ->where('account_detail.code_account',$this->codigo)
                    ->where('account_detail.key_account',$this->cuenta);
                                    
                $movimientos = DB::table('voucher_detail')
                    ->select('voucher_detail.id_vheader as id',DB::raw('voucher_detail.value_debito as debito,voucher_detail.value_credito as credito'))
                    ->leftJoin('voucher_header', 'voucher_detail.id_vheader', '=', 'voucher_header.id')
                    ->where('voucher_header.status',"APROBADO")
                    ->whereBetween('voucher_header.date_registre',[$this->fechaini,$this->fechafin])
                    ->where('voucher_detail.code_account',$this->codigo)
                    ->where('voucher_detail.key_account',$this->cuenta)
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
        return view('cruds.reportes.detalleCuentaExcel', compact('data'));
        
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,            
            'C' => 20,            
            'D' => 20,
            'E' => 20,  
            'F' => 20,
            'G' => 70        
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
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
        ];
    }


}