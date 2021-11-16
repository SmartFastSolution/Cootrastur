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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\withHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ConciliacionBancariaExport implements FromView,WithColumnWidths,WithStyles,WithColumnFormatting {

    use Exportable;
    public function __construct($fechaini1,$fechafin1,$bancos_id)
    {
        $this->fechaini = $fechaini1;
        $this->fechafin = $fechafin1;
        $this->code_banco = $bancos_id;
    }
    public function view(): view
    {
        $fecha1 = $this->fechaini;
        $fecha2 = $this->fechafin;
        $banco = $this->code_banco;
        $data = [];
        $total = 0;
        //return $banco;

        $asientos = DB::table('account_detail')
                                ->select('account_detail.id_header as id',DB::raw('sum(account_detail.value_debito) as debito,sum(account_detail.value_credito) as credito'))
                                ->leftJoin('account_header', 'account_detail.id_header', '=', 'account_header.id')
                                ->where('account_header.status',"CONTABILIZADO")
                                ->whereBetween('account_header.date_voucher',[$fecha1,$fecha2])
                                ->where('account_detail.code_account',$banco)
                                ->groupBy('account_detail.id_header');
        
        $movimientos = DB::table('voucher_detail')
                                ->select('voucher_detail.id_vheader as id',DB::raw('sum(voucher_detail.value_debito) as debito,sum(voucher_detail.value_credito) as credito'))
                                ->leftJoin('voucher_header', 'voucher_detail.id_vheader', '=', 'voucher_header.id')
                                ->where('voucher_header.status',"APROBADO")
                                ->whereBetween('voucher_header.date_registre',[$fecha1,$fecha2])
                                ->where('voucher_detail.code_account',$banco)
                                ->groupBy('voucher_detail.id_vheader')
                                ->union($asientos)
                                ->get();
        
        foreach ($movimientos as $orden) {
            $description ="";
            $importe = 0;
            $concepto = DB::table('account_header')->where('id', $orden->id)->first();
            if(isset($concepto)){
                $description = $concepto->header_description;
            }else{
                $concepto1 = DB::table('voucher_header')->where('id', $orden->id)->first();
                $description = $concepto1->detail_voucher;
            }
            $importe = $orden->debito + $orden->credito;
            $data [] = [
                'col1' => $description,
                'col2' => null,
                'col3' => null,
                'col4' => $importe,
            ];
            $total = $total + $importe ;
        }
        $data [] = [
            'col1' => "TOTAL",
            'col2' => null,
            'col3' => null,
            'col4' => number_format($total, 2, '.', ""),
        ];
        //return $data;
        return view('cruds.reportes.ConciliacionBancoExcel', compact('data'));
        
    }
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,            
            'C' => 25,            
            'D' => 25,     
            'E' => 10,    
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