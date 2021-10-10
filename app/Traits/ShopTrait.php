<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Tienda\Shop;

trait ShopTrait
{


    public function CreateData($request){

      
     $s                   = new Shop();
     $s->user_id          = Auth::id();
     $s->subservice_id    = $request->subservice_id;
     $s->tipoplan_id      = $request->tipoplan_id;
     $s->plan_id          = $request->plan_id;
     $s->costo            = $request->costo;
     $s->estado           = $request->estado;
     $s->save();
  
        $response = array('mensaje' => "Compra en Estado de Revision");
        return $response;

    }


  


}