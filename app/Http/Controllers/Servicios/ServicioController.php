<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Servicios\Service;
use App\Servicios\Tiposervicio;
use App\Traits\ServiceTrait;
use Illuminate\Http\Request;

class ServicioController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function TipoPlanes(){
        return view('cruds.Servicios.TipoPlanes.index');
    }
  
        // redireccion de servicios vista
    public function Servicio(){
        return view('cruds.Servicios.Servicios.servicio');
    }
        // redireccion de tipo de servicios vista
    public function TipoServicio(){
        return view('cruds.Servicios.Servicios.tiposervicio');
    }
  

  //redireccion a la vista de crear servicio y edicion 
    public function CreateServicio (Request $request){
        $tiposervicios = Tiposervicio::where('estado', 'activo')->get();
              
        if ($request->has('services')) {
            $services = Service::with(['tipo','tipo.nombre'])->findOrFail($request->get('services')); 
            return view('cruds.Servicios.Servicios.createservicio', compact('tiposervicios','services'));
        } else{
            return view('cruds.Servicios.Servicios.createservicio', compact('tiposervicios'));
        }     
    }

    //ruta de almacenamiento del servicio modificado
  
    public function Store(ServiceRequest $request){

    
         $result = $request->edit == 'si' ? $this->Update($request) : $this->Create($request);
          //return $result;
         return response()->json($result, 201);

    }

    public function Tipocuenta(){

        return view('cruds.mantenimientos.tipocuenta.index');
    }

    
    public function Plancontable(){

        return view('cruds.mantenimientos.plancontable.index');
    }
  
    public function Impuestosri(){

        return view('cruds.mantenimientos.ImpuestosSRI.index');
    }
    public function ProyeccionGasto(){

        return view('cruds.mantenimientos.proyecciongastos.index');
    }
  

}
