<?php

namespace App\Http\Controllers\Servicios;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubservicioRequest;
use App\Servicios\Service;
use App\Servicios\Subservice;
use App\Traits\SubservicioTrait;
use Illuminate\Http\Request;

class SubserviceController extends Controller
{
    use SubservicioTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

   
   public function index (){
    return view('cruds.Servicios.Servicios.subserviceindex');
   }
   
    public function Sub_service(Request $request){

             $servicios = Service::where('estado', 'activo')->get();

        if ($request->has('subservices')) {
            $subservices = Subservice::with(['servicio','servicio.nombre'])->findOrFail($request->get('subservices')); 
            //dd($subservices);
            return view('cruds.Servicios.Servicios.subservice', compact('servicios', 'subservices'));  
        } else{
            return view('cruds.Servicios.Servicios.subservice', compact('servicios'));
        }
        
    }


    public function store(SubservicioRequest $request){

        $result = $request->edit == 'si' ? $this->UpdateSubservicio($request) : $this->CreateSubservicio($request);
        return response()->json($result, 201);

    }
}
