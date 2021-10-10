<?php

namespace App\Http\Controllers\Tienda;

use App\DocumentosInteraccion;

use App\Http\Controllers\Controller;
use App\Http\Requests\TiendaRequest;
use App\Servicios\Service;
use App\Servicios\Subservice;
use Illuminate\Http\Request;
use App\Servicios\Plan;
use App\Servicios\Tipoplan;
use App\Tienda\Shop;
use App\Traits\ShopTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    use ShopTrait;
    //controlador dedicado a la administracion de los planes que compra el usuario
    //y administracion de los mismos por parte del especialista

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function Index()
    {
        $data = Service::where('estado', 'activo')->paginate(8);
        return view('cruds.Tienda.index', compact('data'));
    }

    //function para el redireccionamiento a la pagina de lista de solicitudes
    public function access($id)
    {

        $servicio = Service::where('id', $id)->firstOrfail();
        $data  = Subservice::where('service_id', $id)->paginate(8);


        return view('cruds.Tienda.listasubservicios', compact('servicio', 'data'));
    }

    //function para el redireccionamiento de la informacion de compra de la solicitud
    public function access2($id)
    {



        $data  = Subservice::join('services', 'subservices.service_id', '=', 'services.id')
            ->join('tiposervicios', 'services.tiposervicio_id', '=', 'tiposervicios.id')
            ->where('subservices.id', $id)
            ->select('subservices.*', 'services.nombre as servicio', 'tiposervicios.nombre as tiposervicio')
            ->get();

        $plans = Plan::where('estado', 'activo')
            ->with(['subservicio', 'subservicio.nombre'], ['tipoplan', 'tipoplan.nombre'])
            ->where('subservice_id', '=', $id)
            ->get();

        $tipoplan = Tipoplan::join('plans', 'plans.tipoplan_id', '=', 'tipoplans.id')
            ->where('plans.subservice_id', $id)
            ->where('plans.estado', 'activo')
            ->where('tipoplans.estado', 'activo')

            ->get();

        //dd($tipoplan);

        return view('cruds.Tienda.paginacompra', compact('data', 'plans', 'tipoplan'));
    }


    //almacenamiento del data
    public function Storee(TiendaRequest $request)
    {

        return response()->json($this->CreateData($request), 201);
    }



    public function adminplanindex()
    {

        return view('cruds.Tienda.adminplan.admincompra');
    }


    public function MiadminPlan()
    {
        return view('cruds.Tienda.adminplan.miadminplan');
    }

    //redirecciona a la vista de los detalles de la compra del cliente
    // a la cual no se le ha asignado ningun especialista
    public function Showdetalle($id)
    {
        $compra = Shop::with([
            'tipoplan' => function ($query) {
                $query->select('id', 'nombre');
            },
            'tipoplan.planes',
            'subservicio' => function ($query) {
                $query->select('id', 'nombre', 'descripcion');
            },
            'cliente' => function ($query) {
                $query->select('id', 'name', 'email');
            },
            'plan' => function ($query) {
                $query->select('id', 'descripcion');
            }

        ])->find($id);
        // dd($compra);
        return view('cruds.Tienda.adminplan.show.showplangeneral', compact('compra'));
    }

    //function para visualizar el detalle de cada compra por parte de la lista de especialista acoplada
    public function Showdetalleindividual($id)
    {
        $compra = Shop::with([
            'tipoplan' => function ($query) {
                $query->select('id', 'nombre');
            },
            'tipoplan.planes',
            'subservicio' => function ($query) {
                $query->select('id', 'nombre', 'descripcion');
            },
            'cliente' => function ($query) {
                $query->select('id', 'name', 'email');
            },
            'plan' => function ($query) {
                $query->select('id', 'descripcion');
            }

        ])->find($id);
        // dd($compra);
        return view('cruds.Tienda.adminplan.show.showplanindividual', compact('compra'));
    }

    public function ListaPlanesCliente()
    {

        return view('cruds.cliente.listacompra');
    }

    /* public function store(Request $request)
    {
        $max_size = (int)ini_get('upload_max_filesize') * 10240;
        $files = $request->file('files');
        $user_id = Auth::id();



        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $fileName = Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension() ;

                if (Storage::putFileAs('/public/' . $user_id . '/', $file, $fileName)) {
                    DocumentosInteraccion::create([
                        'user_id'               => $user_id,
                        'nombre'                => $fileName,
                    ]);
                }
            }

            return back();

        } else {
            return 'Error';
        }

    } */


    public function store(Request $request)
    {
        $max_size = (int)ini_get('upload_max_filesize') * 10240;
        $files = $request->file('files');
        $user_id = Auth::id();



        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $fileName = Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension() ;

                if (Storage::putFileAs('/public/' . $user_id . '/', $file, $fileName)) {
                    DocumentosInteraccion::create([
                        'user_id'               => $user_id,
                        'nombre'                => $fileName,
                    ]);
                }
            }

            return back();

        } else {
            return 'Error';
        }

    }




    //funcion para la interaccion con el cliente
    public function InteraccionEspecialista($id)
    {
        $compra = Shop::with([
           /*  'users' => function ($query) {
                $query->select('id', 'nombre');
            }, */
            'tipoplan' => function ($query) {
                $query->select('id', 'nombre');
            },
            'cliente' => function ($query) {
                $query->select('id', 'name', 'email');
            },

        ])->find($id);
        //dd($compra);
        return view('cruds.Tienda.adminplan.especialistainteraccion', compact('compra'));
        /* return view('cruds.Tienda.adminplan.especialistainteraccion'); */
    }
}
