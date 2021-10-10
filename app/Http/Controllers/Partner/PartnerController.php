<?php

namespace App\Http\Controllers\Partner;

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

class PartnerController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function Partnerlist(){
        return view('cruds.partner.partner.index');
    }
   

    //ruta de almacenamiento del servicio modificado
  
    public function Store(ServiceRequest $request){

    
         $result = $request->edit == 'si' ? $this->Update($request) : $this->Create($request);
          //return $result;
         return response()->json($result, 201);

    }

    public function importarSocios1(Request $request)
   {
    //$descripcion = "";
    //DB::beginTransaction();
    //try{
        $json = $request->json;
        $errorValidacion = "";
        
        $rules = [
            '*.CODIGO'=>  array('required','regex:/^[0-9]+$/'),
            '*.IDENTIFICACION'=>  array('required','regex:/^[0-9]+$/'),
            '*.NOMBRES' => 'required',
            '*.PLACA' => 'required',
            '*.TIPO VEHICULO' =>array('required','regex:/^[1-2]+$/'),
            "*.CORREO"=> 'required|email',
            '*.SENSOR' => 'regex:/^[0-9]+$/',
        ];
        $validator = Validator::make($json, $rules);
        if ($validator->passes() ) {
            foreach ($json as $data) {
                $validation1 = DB::table("partner")->where('code_trans',$data['CODIGO'])->first();
                $validation2 = DB::table("partner")->where('identification',$data['IDENTIFICACION'])->first();
                $validation3 = DB::table("partner")->where('email',$data['CORREO'])->first();
                if(!isset($validation1) && !isset($validation2) && !isset($validation3)){
                    DB::table('partner')->insert([
                        'code_trans' =>  number_format($data['CODIGO'], 0, '.', ""),
                        'identification' => $data['IDENTIFICACION'],
                        'birthday' => Carbon::parse($data['FECHA NACIMIENTO']),
                        'date_begin' =>  Carbon::parse($data['FECHA REGISTRO']),
                        'line' => $data['LINEA'],
                        'license_plate' => $data['PLACA'],
                        'year_vehicle' =>  $data['AÑO VEHICULO'],
                        'chasis' =>$data['CHASIS'],
                        'motor' => $data['MOTOR'],
                        'name_partner' => $data['NOMBRES'],
                        'address_partner' => $data['DIRECCION'],
                        'phone1' => $data['TELEFONO 1'],
                        'phone2' =>  $data['TELEFONO 2'],
                        'email' => $data['CORREO'],
                        'bank' => $data['BANCO'],
                        'account_bank' =>  $data['NUMERO CUENTA'],
                        'driver' => $data['CHOFER'],
                        'type_account' => $data['TIPO CUENTA'],
                        'status' =>  'activo'
                    ]);
                    $idparnet = \DB::getPdo()->lastInsertId();
    
                    DB::table('partner_aditional')->insert([
                        'id_partner' =>  $idparnet,
                        'type_vehicule' => number_format($data['TIPO VEHICULO'], 0, '.', ""),
                        'payment_aditional' => number_format($data['CUOTA AD.'],2, '.', ""),
                        'safe_vehicule' =>  number_format($data['SEGURO VEH.'],2, '.', ""),
                        'ptmo' => number_format($data['PTMO.'],2, '.', ""),
                        'saving' => number_format($data['AHORRO'],2, '.', ""),
                        'other' =>  number_format($data['OTROS'],2, '.', ""),
                        'iess' => number_format($data['IESS'],2, '.', ""),
                        'garage' => number_format($data['GRAJE'],2, '.', ""),
                        'cleaning' => number_format($data['LIMPIEZA'],2, '.', ""),
                        'penalty_fee' => number_format($data['MULTA'],2, '.', ""),
                        'safe_internal' => number_format($data['SEGURO INTERNO'],2, '.', ""),
                        'store' =>  number_format($data['ALMACEN'],2, '.', ""),
                        'membership' => number_format($data['AFILIACION'],2, '.', ""),
                        'sensor' => number_format($data['SENSOR'],0, '.', ""),
                        'satellite' =>  number_format($data['SATELITAL'],2, '.', "")
                    ]);
                }else{
                    if(isset($validation1)){
                        return "El siguiente codigo de Socio ya existe ".$validation1->code_trans;
                    }else if(isset($validation2)){
                        return "La siguiente identificacion de Socuio ya existe ".$validation1->identification;
                    }else{
                        return "La siguiente correo ya existe ".$validation1->email;
                    }
                   // $errorValidacion = 1;
                }
                
                
            }
            //if($errorValidacion !=1){
             //   DB::commit();
                return "OK";
           // }
            
        }else {
            
            return $validator->errors()->first();
           //$emit('Error Importacion',$validator->errors()->first());
        }
       
        
    //} catch(\Exception $e){
      //  DB::rollBack();
        
     //   return $descripcion;

   // } 
   }

   
  

}
