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

class BlanceGeneralExport implements FromView,WithColumnWidths,WithStyles,WithColumnFormatting {

    use Exportable;
    public function __construct($fechaini1,$fechafin1)
    {
        $this->fechaini = $fechaini1;
        $this->fechafin = $fechafin1;
    }
    public function view(): view
    {
        $fecha1 = $this->fechaini;
        $fecha2 = $this->fechafin;
        $total_activos = 0;
        $total_pasivos = 0;
        $cuentas_principales = [1,2];
        // 1 ACTIVO
        // 2 PASIVO
        
        $data = [];

        foreach ($cuentas_principales as $cuenta_principal) {
            //FOREACH DE LA TIPO DE CUENTA PRINCIPAL 1 ACTIVO
            $total_general =0;
            $info_cuenta_principal = DB::table('account_plan')->select('description','code_account')->where('account_type',$cuenta_principal)->where('level',1)->first();

            $data [] = [
                'colcode'=>$info_cuenta_principal->code_account,
                'col1' => $info_cuenta_principal->description,
                'col2' => null,
                'col3' => null,
                'col4' => null,
            ];

            //nivel 2
            $cuenta_level_2 = DB::table('account_plan')->where('account_type',$cuenta_principal)->where('status','ACTIVO')->where('level',2)->get(); 

            foreach ($cuenta_level_2 as $ct_lvl2) {
                $all_movimientos = 0;
                $total_sub_cuetnas = 0;
                $data [] = [
                    'colcode'=>$ct_lvl2->code_account,
                    'col1' => null,
                    'col2' => $ct_lvl2->description,
                    'col3' => null,
                    'col4' => null,
                ];

                //VALIDAR VALORES DE LA CUENTA NIVEL 2
                $asientos = DB::table('account_detail')
                                ->leftJoin('account_header', 'account_detail.id_header', '=', 'account_header.id')
                                ->where('account_header.status',"CONTABILIZADO")
                                ->whereBetween('account_header.date_voucher',[$fecha1,$fecha2])
                                ->where('account_detail.code_account', 'like',$ct_lvl2->code_account.'%')
                                ->count();

                $movimientos = DB::table('voucher_detail')
                                ->leftJoin('voucher_header', 'voucher_detail.id_vheader', '=', 'voucher_header.id')
                                ->where('voucher_header.status',"APROBADO")
                                ->whereBetween('voucher_header.date_registre',[$fecha1,$fecha2])
                                ->where('voucher_detail.code_account', 'like',$ct_lvl2->code_account.'%')
                                ->count();

                $all_movimientos = $movimientos + $asientos;

                if (($all_movimientos) == 0) {
                    
                    $data [] = [
                        'colcode'=>null,
                        'col1' => null,
                        'col2' => "TOTAL DE ".$ct_lvl2->description,
                        'col3' => null,
                        'col4' => 0,
                    ];
                    
                }else{

                    $orden_cuentas =  DB::table('account_plan')
                    ->from(DB::table('account_plan')->select('code_account', 'account_type',
                                            DB::raw('CASE WHEN sub_account IS null THEN \'00000\' ELSE sub_account END AS sub_account'),
                                            DB::raw('CASE WHEN object IS null THEN \'00000\' ELSE object END AS object'),
                                            DB::raw('CASE WHEN detail IS null THEN \'00000\' ELSE detail END AS detail'),
                                            DB::raw(' CASE WHEN aux1 IS null THEN \'00000\' ELSE aux1 END AS aux1'),
                                            DB::raw(' CASE WHEN aux2 IS null THEN \'00000\' ELSE aux2 END AS aux2'),
                                            DB::raw(' CASE WHEN aux3 IS null THEN \'00000\' ELSE aux2 END AS aux3'),
                                            'description', 'level')
                                            ->where('account_type',$ct_lvl2->account_type )
                                            ->where('sub_account',$ct_lvl2->sub_account ), 'parche')
                    ->orderBy('parche.account_type', 'ASC')
                    ->orderBy('parche.sub_account', 'ASC')
                    ->orderBy('parche.object', 'ASC')
                    ->orderBy('parche.detail', 'ASC')
                    ->orderBy('parche.aux1', 'ASC')
                    ->orderBy('parche.aux2', 'ASC')
                    ->orderBy('parche.aux3', 'ASC')
                    ->get();

                    foreach ($orden_cuentas as $orden) {
                        $total_cuenta = 0.0;
                        
                        $asientos = DB::table('account_detail')
                                ->select(DB::raw('sum(account_detail.value_debito) as debito,sum(account_detail.value_credito) as credito'))
                                ->leftJoin('account_header', 'account_detail.id_header', '=', 'account_header.id')
                                ->where('account_header.status',"CONTABILIZADO")
                                ->whereBetween('account_header.date_voucher',[$fecha1,$fecha2])
                                ->where('account_detail.code_account', $orden->code_account)
                                ->first();

                        $movimientos = DB::table('voucher_detail')
                                ->select(DB::raw('sum(voucher_detail.value_debito) as debito,sum(voucher_detail.value_credito)  as credito'))
                                ->leftJoin('voucher_header', 'voucher_detail.id_vheader', '=', 'voucher_header.id')
                                ->where('voucher_header.status',"APROBADO")
                                ->whereBetween('voucher_header.date_registre',[$fecha1,$fecha2])
                                ->where('voucher_detail.code_account', $orden->code_account)
                                ->first();

                        if (!isset($asientos)) {
                            $total_cuenta = 0.0;
                        }else{
                            $total_cuenta = $asientos->debito + ($asientos->credito);
                        }

                        if (!isset($movimientos)) {
                            $total_cuenta += 0.0;
                        }else{
                            $total_cuenta += $movimientos->debito + ($movimientos->credito);
                        }
                        if ($total_cuenta  > 0) {
                            $data [] = [
                                'colcode'=>$orden->code_account,
                                'col1' => null,
                                'col2' => null,
                                'col3' => $orden->description,
                                'col4' => $total_cuenta,
                            ];
                            $total_sub_cuetnas = $total_sub_cuetnas + $total_cuenta;
                        }
                    }
                    if($total_sub_cuetnas > 0){
                        $data [] = [
                            'colcode'=>null,
                            'col1' => null,
                            'col2' => "TOTAL DE ".$ct_lvl2->description,
                            'col3' => null,
                            'col4' => $total_sub_cuetnas,
                        ];
                    }
                }
                $total_general =$total_sub_cuetnas + $total_general;
            }
            if($total_general > 0){
                $data [] = [
                    'colcode'=>null,
                    'col1' => "TOTAL DE ".$info_cuenta_principal->description,
                    'col2' => null,
                    'col3' => null,
                    'col4' => $total_general,
                ];
            }
            if($cuenta_principal == 1){
                $total_activos = $total_general;
            }else{
                $total_pasivos = $total_general;
            }
        }
        $data [] = [
            'colcode'=>null,
            'col1' => "TOTAL DE PATRIMONIO",
            'col2' => null,
            'col3' => null,
            'col4' => $total_activos - $total_pasivos,
        ];
        //return $data;
        return view('cruds.reportes.BalanceExcel', compact('data'));
        
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