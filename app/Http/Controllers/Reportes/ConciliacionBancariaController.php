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

class ConciliacionBancariaController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function conciliacionlist(){
        $bancos = DB::table('bank')->where('status', "activo")->get();
        return view('cruds.reportes.conciliacion', compact('bancos'));
    }

    public function ConciliacionBancaria(Request $request){
        $fecha1 = $request->fechaini;
        $fecha2 = $request->fechafin;
        $banco = $request->banco;
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
        return $data;
    }
}
