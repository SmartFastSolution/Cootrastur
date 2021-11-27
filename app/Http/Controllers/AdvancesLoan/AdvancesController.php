<?php

namespace App\Http\Controllers\AdvancesLoan;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\ConfigurationDiscount\Discount;
use App\Traits\ServiceTrait;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
class AdvancesController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function Advanceslist(){
        
        return view('cruds.AdvaanceLoans.advancesLo.index');
    }
     
    public function Store(ServiceRequest $request){

    
         $result = $request->edit == 'si' ? $this->Update($request) : $this->Create($request);
          //return $result;
         return response()->json($result, 201);

    }
    public function buscarCuentas(Request $request)
    {
        $code = $request->code;
        $key = $request->key;
        if($code == ""|| $code == null){
            $cuentasContables = DB::table('account_plan')->where('key_account',$key)->where('status','activo')->get();
            return (isset($cuentasContables) ? $cuentasContables : "") ;
         }else{
            $cuentasContables = DB::table('account_plan')->where('code_account',$code)->where('status','activo')->get();
            return (isset($cuentasContables) ? $cuentasContables : "") ;
         }
    }

    public function DetallePrestamo(Request $request)
    {
        $comprobante = $request->comp;
        $fecha = Carbon::now();
        $usuario = Auth::user()->name;
        $descripcion = "";
        $cabecera = DB::table('advances_loan')->where('id', $comprobante)->first();
        if (isset($cabecera)) {
            if( $cabecera->type_prestamo == "P" ){
                $descripcion="Prestamo";
            }else{
                $descripcion="Anticipo";
            }
            $datosSocio = DB::table('partner')->where('id', $cabecera->id_partner)->first();
            //$valorCheque = DB::table('voucher_detail')->where('id_vheader', $comprobante)->where('key_account',$datosSocio->key_account)->first();
            $detalle = DB::table('detail_advance_loan')->where('id_advances_loan', $comprobante)->get();
            $totalDeuda=DB::table('detail_advance_loan')->select(DB::raw("SUM(value_unit) as debito"))->where('id_advances_loan', $comprobante)->first();
            $TotalInteres=DB::table('detail_advance_loan')->select(DB::raw("SUM(value_interes) as credito"))->where('id_advances_loan', $comprobante)->first();
            $view = \View::make('Reportes.reportePrestamos',compact(['datosSocio','detalle','totalDeuda','TotalInteres','cabecera','fecha','usuario','descripcion']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream($descripcion." - ".$datosSocio->name_partner.'.pdf');
        }
    }
  

}
