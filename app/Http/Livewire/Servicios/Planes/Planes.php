<?php

namespace App\Http\Livewire\Servicios\Planes;

use App\Servicios\Plan;
use Livewire\Component;
use Livewire\WithPagination;

class Planes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarPlan'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];


    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'plans.id';
    public $orderAsc       = true;
    public $estado         = 'activo';



    public function render()
    {
        $data = Plan::join('subservices','plans.subservice_id','=', 'subservices.id')
                    ->join('tipoplans','plans.tipoplan_id','=','tipoplans.id') 
                    ->where(function($query){
                        $query->where('subservices.nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('plans.descripcion', 'like', '%' . $this->search . '%')
                        ->orWhere('tipoplans.nombre', 'like', '%' . $this->search . '%');
                    })
                    ->select('plans.*','subservices.nombre as subservicio', 'tipoplans.nombre as tipoplan')
                    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
            // ->get();
            // dd($data);
        return view('livewire.servicios.planes.planes', compact('data'));
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
 
        $estado = Plan::find($id);
        $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
        $estado->save();
 
         $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);
 
    }

    public function editPlan($id){

        return redirect()->to("servicios/crear-plan?plans={$id}");

    }

    public function eliminarPlan($id)
    {
        $c = Plan::find($id);
        $c->delete();
        $this->emit('info',['mensaje' => 'Servicio Eliminada Correctamente']);
    }


}
