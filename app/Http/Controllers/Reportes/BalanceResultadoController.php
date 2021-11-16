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

class BalanceResultadoController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function balanceResult(){
        return view('cruds.reportes.resultado');
    }

    public function balanceExcelResult(Request $request){
        $fecha1 = $request->fechaini;
        $fecha2 = $request->fechafin;
        $tabla =    '<thead style=\'background-color:#167F92; color:white; font-size:12px\'><tr><td>DESCRIPCIÓN</td><td></td><td></td></tr></thead><tbody>';
        $result_formulas = DB::table('template_er')->OrderBy('order')->get();
        $arr_result_formulas = $result_formulas->toArray();

        $result_parametro_er = DB::table('accounting_parameter')->where('code','LIKE','ER%')->orderby('code')->get();
        $arr_result_parametros_er = $result_parametro_er->toArray();
        foreach ($arr_result_parametros_er as $parametros) {
            $sum = 0;
            $total = 0;
            $result_rango_cuentas  = DB::table('account_plan')->whereBetween('code_account',[$parametros->account1,$parametros->account2])->OrderBy('code_account')->get();
            $arr_rango_cuentas = $result_rango_cuentas->toArray();
            foreach ($arr_rango_cuentas as $cuentas) {
                //$type_account = $cuentas->account_type;
                //$subtype_account = $cuentas->sub_account;
                //$object_account = $cuentas->object;
                //$detail_account = $cuentas->detail;
                //$aux1 = $cuentas->aux1;
                //$aux2 = $cuentas->aux2;
                //$aux3 = $cuentas->aux3;
                /*$sum = DB::table('balance_account')->select(DB::raw('sum(initial_balance +'.$months.') as total'))
                                ->join('account_plan', 'account_plan.number_account', '=', 'balance_account.number_account')
                                ->when($type_account, function ($query, $type_account) {
                                    return $query->where('account_plan.type_account', $type_account);
                                })->when($subtype_account, function ($query, $subtype_account) {
                                    return $query->where('account_plan.subtype_account', $subtype_account);
                                })->when($object_account, function ($query, $object_account) {
                                    return $query->where('account_plan.object_account', $object_account);
                                })->when($detail_account, function ($query, $detail_account) {
                                    return $query->where('account_plan.detail_account', $detail_account);
                                })->when($auxiliary, function ($query, $auxiliary) {
                                    return $query->where('account_plan.auxiliary', $auxiliary);
                                })->where('account_plan.company', $company)
                                ->where('balance_account.company', $company)
                                ->where('balance_account.status_close',"CERRADA")
                                ->where('balance_account.fiscal_year',$year_fiscal)
                                ->wherein('account_plan.account_level',['4','5'])->first();
                $total = $total + $sum->total;*/
                $asientos = DB::table('account_detail')
                                ->select(DB::raw('sum(account_detail.value_debito) as debito,sum(account_detail.value_credito) as credito'))
                                ->leftJoin('account_header', 'account_detail.id_header', '=', 'account_header.id')
                                ->where('account_header.status',"CONTABILIZADO")
                                ->whereBetween('account_header.date_voucher',[$fecha1,$fecha2])
                                ->where('account_detail.code_account', $cuentas->code_account)
                                ->first();

                $movimientos = DB::table('voucher_detail')
                                ->select(DB::raw('sum(voucher_detail.value_debito) as debito,sum(voucher_detail.value_credito)  as credito'))
                                ->leftJoin('voucher_header', 'voucher_detail.id_vheader', '=', 'voucher_header.id')
                                ->where('voucher_header.status',"APROBADO")
                                ->whereBetween('voucher_header.date_registre',[$fecha1,$fecha2])
                                ->where('voucher_detail.code_account', $cuentas->code_account)
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
                $total = $total + $total_cuenta;
            }
            $values[] = [
                'code' => $parametros->code,
                'total' => strval($total)
            ];
        }
        //return $values;
        foreach ($arr_result_formulas as $formulas) {
            if ($formulas->display == "on") {

                if ($formulas->formula == "0") {
                    $tabla.= '<tr style=\'background: white;\'><td></td><td></td><td></td></tr>';    
                }else{
                    $style_line = '';
                    if ($formulas->total_line == 1) {
                        $style_line = 'border-bottom: 1px solid black';
                    }

                    //CALCULO
                    $calculo = '';
                    $_temp = 0;
                    foreach ($values as $key => $value) {
                        if ($_temp == 0) {
                            $_formula = ($formulas->formula);
                        }else{
                            $_formula = $calculo;
                        }
                        $calculo = str_replace($value["code"], "(".$value["total"].")", $_formula);
                        $_temp++;
                    }

                    if ($calculo == '') {
                        $calculo = '0';
                    }else{
                        $calculo = str_replace(',', ".", $calculo);
                    }
                    //FIN CALCULO

                    $parche = (eval("return ".$calculo.";"));

                    $tabla.= '<tr style=\'background: white;\'>';
                    $tabla.= '<td>'.$formulas->description.'</td>';
                    if ($formulas->column == 1) {
                        $tabla.= '<td style=\'text-align:right;'.$style_line.'\'>$'.number_format(($parche),2,'.',"").'</td>';
                        $tabla.= '<td style=\'text-align:right;\'></td>';
                    }else{
                        $tabla.= '<td style=\'text-align:right;\'></td>';
                        $tabla.= '<td style=\'text-align:right;'.$style_line.'\'>$'.number_format(($parche),2,'.',"").'</td>';
                    }
                    $tabla.= '</tr>';
                }

            }
            
        }
        //$title = 'Estado de Resultado realizado desde el mes de '.data_get($arr_months,$month_fiscal).' a '.data_get($arr_months,$month_fiscal2).' del año '.$year_fiscal;
        $tabla.=  '</tbody>';

        return $tabla;
    }
}
