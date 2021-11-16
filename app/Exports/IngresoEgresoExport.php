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

class IngresoEgresoExport implements FromView,WithColumnWidths,WithStyles {

    use Exportable;
    public function __construct($comp)
    {
        $this->comp = $comp;
        
    }
    public function view(): view
    {
        $data = DB::table('voucher_detail')
            ->select('voucher_detail.key_account', 'voucher_detail.code_account','account_plan.description', 'voucher_detail.value_debito', 'voucher_detail.value_credito')
            ->join('account_plan', 'account_plan.code_account', '=', 'voucher_detail.code_account')
            ->where('id_vheader', $this->comp)->get();
        $total_debito=DB::table('voucher_detail')->select(DB::raw("SUM(value_debito) as debito"))->where('id_vheader', $this->comp)->first();
        $total_crebito=DB::table('voucher_detail')->select(DB::raw("SUM(value_credito) as credito"))->where('id_vheader', $this->comp)->first();
        return view('cruds.vouchers.facturas.ingresoEgresoExcel', compact('data','total_debito','total_crebito'));
        
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,            
            'C' => 40,            
            'D' => 20,
            'E' => 20,            
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