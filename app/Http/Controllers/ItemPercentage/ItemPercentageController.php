<?php

namespace App\Http\Controllers\ItemPercentage;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Servicios\Service;
use App\Servicios\Tiposervicio;
use App\Traits\ServiceTrait;
use Illuminate\Http\Request;

class ItemPercentageController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function ItemPercentagelist(){
        return view('cruds.itempercentages.itempercentages.index');
    }
   

    //ruta de almacenamiento del servicio modificado
  
    public function Store(ServiceRequest $request){

    
         $result = $request->edit == 'si' ? $this->Update($request) : $this->Create($request);
          //return $result;
         return response()->json($result, 201);

    }
  

}
