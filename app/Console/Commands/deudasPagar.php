<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Response;
use Session;
use DB;
use Carbon\Carbon;

class deudasPagar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deudas:pagar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta el proceso de cobros mensuales automatico';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


/**
* Execute the console command.
*
* @return mixed
*/
    public function handle(){
        setlocale(LC_TIME, 'es_ES');
        $fechaDia = Carbon::now()->format('Y/m/d');
        $separarFecha = explode("/", $fechaDia);
        $mes = "";
        $arr_months = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        foreach ($arr_months as $key1 => $value1) {
            if($key1 == ($separarFecha[1])){
                $mes = $value1;
                
            }
        }
        $mes;
        //DB::beginTransaction();
        //try{
            $Socios = DB::table('partner')->where('status', "activo")->whereNotNull('code_account')->get();
            foreach($Socios as $buscarProveedor) {
                $i=1;
                $valorTotal=0;
                $seq = DB::table('sequential')->where('id', 1)->first();
                $numeroVoucher =$seq->id_compro;
                
                //echo $cuentasCobro1;
                DB::table('account_header')->insert([
                    'code_voucher' =>  "002",
                    'date_voucher' => Carbon::now(),
                    'number_voucher' => $numeroVoucher,
                    'header_description' =>  "Asiento Automatico del mes ".$mes,
                    'status' => "CONTABILIZADO",
                ]);
                $idheader = DB::getPdo()->lastInsertId();
                $cuentasCobro1 = DB::table('charges')->whereNotNull('type_cobros')->where('status',"activo")->get();
                foreach($cuentasCobro1 as $cuentaDeuda) {
                    $cuentasAutomaticas = DB::table('mant_charges')->where('id',$cuentaDeuda->type_cobros)->first();
                    if($cuentasAutomaticas->process == "A" ){
                        $deudaMesesPasadas = DB::table('partner_aditional_detail')->where('key_account',$cuentaDeuda->key_account)->where('code_account',$cuentaDeuda->code_account)->where('id_partner',$buscarProveedor->id)->where('status','PENDIENTE')->get();
                        if(isset($deudaMesesPasadas)){
                            $totalRegistro = count($deudaMesesPasadas)+1;
                            foreach($deudaMesesPasadas as $cuotasPendientes) {
                                DB::table('partner_aditional_detail')->where('id', $cuotasPendientes->id)->update([
                                    'status' => "NO PAGADO"
                                ]);
                                $valorTotal = $valorTotal + $cuotasPendientes->value_pending;
                            }
                        }
                        $valorTotal = $valorTotal + $cuentaDeuda->value;
                        
                        $result1 = DB::table('account_plan')->where('code_account',trim(rtrim($cuentaDeuda->code_account, " "), " "))->where('key_account',trim(rtrim($cuentaDeuda->key_account, " "), " "))->where('status', 'activo')->first();
                        DB::table('account_detail')->insert([
                            'key_account' =>  $cuentaDeuda->key_account,
                            'code_account' => $cuentaDeuda->code_account,
                            'description_account' => $result1->description,
                            'line' => $i,
                            'value_debito' => (isset($deudaMesesPasadas) ? $cuentaDeuda->value* $totalRegistro: $cuentaDeuda->value),
                            'Value_credito' => 0,
                            'reference' => "",
                            'id_header'=>$idheader,
                        ]);
                        
                        DB::table('partner_aditional_detail')->insert([
                            'id_partner' => $buscarProveedor->id,
                            'key_account' =>  $cuentaDeuda->key_account,
                            'code_account' => $cuentaDeuda->code_account,
                            'code_discount' => (isset($cuentaDeuda->type_cobros) ? $cuentaDeuda->type_cobros: 0),
                            'status' => "PENDIENTE",
                            'date_registre' => Carbon::now(),
                            'month' => (int)$separarFecha[1],
                            'year' => $separarFecha[0],
                            'value_pending'=>(isset($deudaMesesPasadas) ? $cuentaDeuda->value* $totalRegistro: $cuentaDeuda->value),
                            'number_voucher'=>$numeroVoucher,
                        ]);
                        $i++;
                    }
                }
                $cuentaProveedor = DB::table('account_plan')->where('status', 'activo')->where('code_account',$buscarProveedor->code_account)->first();
                DB::table('account_detail')->insert([
                    'key_account' =>  $cuentaProveedor->key_account,
                    'code_account' => $cuentaProveedor->code_account,
                    'description_account' => $cuentaProveedor->description,
                    'line' => $i+1,
                    'value_debito' => 0,
                    'Value_credito' => $valorTotal*-1,
                    'reference' => "",
                    'id_header'=>$idheader,
                ]);
                DB::table('sequential')->where('id', 1)->update([
                    'id_compro' => $numeroVoucher+1
                ]);
            }
        //} catch(\Exception $e){
        //    DB::rollBack();
        //    abort(500, $e->getMessage());
        //} 
    }

}