<?php

namespace App\Http\Livewire\Tienda;

use App\Servicios\Subservice;
use App\Servicios\Tipoplan;
use App\Tienda\Shop;
use App\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Miadminlista extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    public $perPage         = 10;
    public $search          = '';
    public $orderBy         = 'shops.id';
    public $orderAsc        = true;
    public $uid;
    public $ShowMode        = false;

    public $clientes  =[];
    public $tipoplans  =[];
    public $subservices  =[];

    public $shop_id, $costo, $user_id, $tipoplan_id, $subservice_id ;


    //COMPONENTE PARA LA ADMINISTRACION DE PLANES ACEPTADOS POR EL ESPECIALISTA
    public function mount(){
        $this->uid = Auth::user()->id;
     }

    public function render()
    {
       $this->clientes = User::get(['id', 'name']);
       $this->subservices = Subservice::get(['id', 'nombre']);
       $this->tipoplans = Tipoplan::get(['id', 'nombre']);
        $data = Shop::where('especialista_id', $this->uid)
        ->join('users','shops.user_id','=','users.id')
        ->join('subservices','shops.subservice_id', '=','subservices.id')
        ->join('tipoplans','shops.tipoplan_id','=','tipoplans.id')
        ->where(function($query){
            $query->where('subservices.nombre', 'like', '%' . $this->search . '%')
            ->orWhere('users.name', 'like', '%' . $this->search . '%');
        })

        ->select('shops.*','subservices.nombre as sub','tipoplans.nombre as tipoplan','users.name as cliente')
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);


        return view('livewire.tienda.miadminlista',compact('data'));
    }

    public function sortBy($field)
    {
        if ($this->orderBy === $field) {
            $this->orderAsc = !$this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $field;
    }


    public function estadochange($id)
    {
        $estado = Shop::find($id);
        $estado->estado = $estado->estado == 'aprobada' ? 'en proceso' : 'aprobada';
        $estado->save();
        $this->emit('info',['mensaje' => $estado->estado == 'aprovada' ? 'Compra Aprobada Correctamente' : 'Compra en estado de Proceso']);

    }

    public function ShowData($id){
        return redirect()->route('compra.detalle.individual.show', $id);
    }





    public function resetModal(){
        $this->reset(['ShowMode','costo','user_id','tipoplan_id','subservice_id']);
        $this->resetValidation();
    }


    //function dedicada para la interaccion entre el especialista y el cliente
    public function Interaccion($id){
        return redirect()->route('tienda.interaccion', $id);
    }


}
