<?php

namespace App\Http\Controllers;

use App\TipoTransaccion;
use Illuminate\Http\Request;

class IngresoComprobanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listarTipoTransaccion()
    {
        return TipoTransaccion::where('estado','=','activo')->get();
    }


}
