<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Servicios\Plan;
use App\Servicios\Subservice;
use App\Servicios\Tipoplan;
use App\Traits\PlanTrait;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use PlanTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }



    // crud de redicreccion de ruta del mantenimiento de planes
    public function Planes(){
        return view('cruds.Servicios.TipoPlanes.Planes');
    }

    //crud de creacion de plan y edicion
    public function Plan(Request $request){

        $subservicios = Subservice::where('estado', 'activo')->get();
        $tipoplan  = Tipoplan::where('estado', 'activo')->get();

        if ($request->has('plans')) {
            $plans = Plan::with(['subservicio','subservicio.nombre'],['tipoplan','tipoplan.nombre'])->findOrFail($request->get('plans'));
           // dd($plans);
            return view('cruds.Servicios.TipoPlanes.createplan', compact('subservicios', 'tipoplan','plans'));
        }else{

            return view('cruds.Servicios.TipoPlanes.createplan', compact('subservicios', 'tipoplan'));

        }





    }

    public function Store(PlanRequest $request){

        $result = $request->edit == 'si' ? $this->UpdatePlan($request) : $this->CreatePlan($request);
        return response()->json($result, 201);
    }




}
