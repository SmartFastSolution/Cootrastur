<?php

namespace App\Http\Controllers\AccountParameter;

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

class AccountParameterController extends Controller
{

    use ServiceTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
        // redireccion de tipo de planes vista 
    public function Parameterlist(){
        return view('cruds.parametroscuentas.cuentasparametros.index');
    }

    public function buscarCuentas(Request $request)
    {
        $code = $request->code;
        $level = $request->level;
        $cuentasContables = DB::table('account_plan')->where('code_account',$code)->where('level',$level)->where('status','activo')->get();
        return (isset($cuentasContables) ? $cuentasContables : "") ;
    }


}
