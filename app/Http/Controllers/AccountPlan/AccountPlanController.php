<?php

namespace App\Http\Controllers\AccountPlan;

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

class AccountPlanController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function Accountlist(){
        return view('cruds.account.cuenta.index');
    }
    
   

    //ruta de almacenamiento del servicio modificado
  
    public function Store(ServiceRequest $request){

    
         $result = $request->edit == 'si' ? $this->Update($request) : $this->Create($request);
          //return $result;
         return response()->json($result, 201);

    }

    public function importarAccount1(Request $request)
    {
         $cuentas = $request->cuentas;
         foreach ($cuentas as $validacion) {
             $accounts =$validacion['CODIGO CUENTA'];
             $validacion = DB::table('account_plan')->where('code_account', $accounts)->first();
             if(isset($validacion)){
                 return "Cuenta Existente ".$validacion->code_account." ".$validacion->description;
             }
         }
         $rules = [
             '*.CODIGO CUENTA' => 'required',
             '*.DESCRIPCION' => 'required',
             '*.CLAVE' =>  array('required','regex:/^[0-9]+$/'),
             '*.VISUALIZACION' => 'required|in:S,N',
         ];
         
         $validator = Validator::make($cuentas, $rules);
        
         if ($validator->passes()) {
             DB::beginTransaction();
             try{
                 foreach ($cuentas as $data1) {
                     
                     
 
                     $account = explode(".", $data1['CODIGO CUENTA']);
                 
                         DB::table('account_plan')->insert([
                             'account_type' => (isset($account[0]) ? $account[0] : $data1['CODIGO CUENTA']) ,
                             'sub_account' => (isset($account[1]) ? $account[1] : null) ,
                             'object' => (isset($account[2])? $account[2] : null) ,
                             'detail' =>  (isset($account[3]) ? $account[3] : null) ,
                             'aux1' => (isset($account[4])? $account[4] : null) ,
                             'aux2' => (isset($account[5]) ? $account[5] : null) ,
                             'aux3' =>  (isset($account[6]) ? $account[6] : null) ,
                             'description' =>$data1['DESCRIPCION'],
                             'level' => count($account),
                             'display' => $data1['VISUALIZACION'],
                             'status' =>  'activo',
                             'code_account'=> $data1['CODIGO CUENTA'],
                             'key_account' => $data1['CLAVE'],
                         ]);
                        
 
                     
                 }
                 DB::commit();
                 return "OK";
             } catch(\Exception $e){
                 DB::rollBack();
                 abort(500, $e->getMessage());
     
             } 
                 
             
         }else {
             
             return $validator->errors()->first();
         }
    }

   
  

}
