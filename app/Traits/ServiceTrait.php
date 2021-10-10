<?php

namespace App\Traits;

use App\Document;
use App\Servicios\Service;


/**
 * 
 */
trait ServiceTrait
{

    public function Create($request){

      

        $s                   = new Service();
        $s->nombre           = $request->nombre;
        $s->tiposervicio_id  = $request->tiposervicio_id;
        $s->descripcion      = $request->descripcion;
        $s->estado           = $request->estado;
        $s->save();
   
           if ($request->hasFile('documento')) {
               $archivo = $request->documento;
               $nombre       = time() . '_' . $archivo->getClientOriginalName();
               $urldocumento = '/documentos/' . $nombre;
               $archivo->storeAs('documentos',  $nombre, 'public_upload');
               $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
               $s->documento()->save($documento);
           }
     
           $response = array('mensaje' => "Registro Realizado Correctamente");
           return $response;
   
       }



       public function Update($request){

        $s                   = Service::find($request->service_id);
        $s->nombre           = $request->nombre;
        $s->tiposervicio_id  = $request->tiposervicio_id;
        $s->descripcion      = $request->descripcion;
        $s->estado           = $request->estado;
        $s->save();

        if ($request->hasFile('documento')) {
            if (isset($s->documento)) {
                $image_path = public_path() . $s->documento->archivo;
                unlink($image_path);
            }
            $archivo = $request->documento;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/documentos/' . $nombre;
            $archivo->storeAs('documentos',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $s->documento()->save($documento);
        }

        $response = array('mensaje' => "Registro Actualizado Correctamente");
        return $response;



    }


    
}
