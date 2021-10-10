<?php

namespace App\Http\Livewire\Tienda;

use App\DocumentosInteraccion;
use App\Interaccion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EspecialistaInteraccion extends Component
{
    public $espe;
    public $interaccion;
    public $mensajes;


    public function mount()
    {
        $this->id = Auth::user()->id;
        $this->actualizarBandeja();
    }

    public function render()
    {
        $data = Interaccion::where('especialista_id', $this->id)->get();
        /* $documentos = DocumentosInteraccion::where('user_id', $this->id)->get(); */

        //dd($documentos);

        return view('livewire.tienda.especialista-interaccion',compact('data'));
    }



    public function actualizarBandeja()
    {
        /* Se traen los datos de la tabla Interacción */
        $mensajes = Interaccion::where('especialista_id', $this->espe)->get();
        $documentos = DocumentosInteraccion::where('user_id', Auth::id())->get();


        /* dd($mensajes); */

       /*  foreach ($mensajes as $mensaje) {

            if ($mensaje->especialista_id == Auth::user()->id) {

                $this->mensajes = [
                    "cliente" => $mensaje->cliente_id,
                    "detalle" => $mensaje->detalle,
                    "observacion" => $mensaje->observacion,
                    "fecha" => $mensaje->fecha
                ];
            }
        } */
    }
}
