<?php

namespace App\Http\Livewire\Admin\User;

use App\City;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use App\User;

class DatosPersonales extends Component
{   
 
     public $genero ="";
     public $uid ;
     public $user, $telefono, $fecha_n, $domicilio , $cedula, $edad;
     public $ciudades  =[];
     public $city_id   ;
     public $user_id   ;
     public $editMode    = true;
     

     public function mount(){
         $this->uid = Auth::user()->id;
     }

    public function render()
    {   
        $this->ciudades = City::get(['id','nombre']);

        $data = User::where('id', $this->uid)
        ->with('city')
        ->get();
        return view('livewire.admin.user.datos-personales', compact('data'));
    }

    public function EditDatos(){

     
        $user                  = Auth::user();
        $this->name            = $user->name;
        $this->email           = $user->email;
        $this->telefono        = $user->telefono;
        $this->domicilio       = $user->domicilio;
        $this->fecha_n         = $user->fecha_n;
        $this->cedula          = $user->cedula;
        $this->genero          = $user->genero;
        $this->edad            = $user->edad;
        $this->city_id         = $user->city_id;
        $this->editMode  = true;
        dd($user);
    }


    public function UpdateDatos(){

        $user              = Auth::user();
        $user->telefono    = $this->telefono;
        $user->fecha_n     = $this->fecha_n;
        $user->city_id     = $this->city_id;
        $user->domicilio   = $this->domicilio;
        $user->cedula      = $this->cedula;
        $user->genero      = $this->genero;
        $user->edad        = $this->edad;
        $user->save();

        $this->emit('info',['mensaje' => 'Datos Actualizados Correctamente', 'modal' => '#EditUser']);  
    }


  
}
