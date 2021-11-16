<?php

namespace App\Http\Controllers\AdvancesLoan;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\ConfigurationDiscount\Discount;
use App\Traits\ServiceTrait;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
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
  

}
