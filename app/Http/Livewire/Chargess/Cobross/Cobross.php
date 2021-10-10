<?php

namespace App\Http\Livewire\Chargess\Cobross;

use App\Charges\Charges;
use Livewire\Component;
use Livewire\WithPagination;

class Cobross extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarProveedor'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


public $perPage         = 10;
public $search          = '';
public $orderBy         = 'id';
public $orderAsc        = true;
public $charges_id     = '';
public $status          = 'activo';
public $editMode        = false;
public $createMode      = false;

public $description;
public $type_charges;
public $address;
public $value;

    public function render()
    {
        $data = Charges::where(function($query){
            $query->where('charges.description', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.charges.cobros.tipo-charges', compact('data'));
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


  

    public function resetModal(){
        $this->reset(['description','type_charges','value','editMode']);
        $this->resetValidation();
    }

    public function createCharges (){
        $this->validate([
            'description' =>'required',
            'type_charges' =>'required',
            'value' =>'required',
    
        ],[
            'description.required'      => 'No has agregado el nombre del cobro',
            'type_charges.required'      => 'No has seleccionado un tipo de cobro',
            'value.required'      => 'No has agregado un valor',
        ]);

        $this->createMode = true;
        $p  = new Charges;
        $p->description  = $this->description;
        $p->type_charges = $this->type_charges;
        $p->value = $this->value;
        $p->status       = $this->status == 'activo' ? 'activo' : 'inactivo';

        $p->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Cobro Registrado Correctamente', 'modal' => '#createCobros']);

        $this->createMode = false;
    }


    public function editCharges ($id)
    {
        $c                    = Charges::find($id);
        $this->charges_id    =$id;
        $this->description         =$c->description;
        $this->type_charges         =$c->type_charges;
        $this->value= $c->value;
        $this->status         =$c->status;
        $this->editMode       =true;
   }


   public function updateCharges()
   {

    $this->validate([
        'description' =>'required',
        'type_charges' =>'required',
        'value' =>'required',

    ],[
        'description.required'      => 'No has agregado el nombre del cobro',
        'type_charges.required'      => 'No has seleccionado un tipo de cobro',
        'value.required'      => 'No has agregado un valor',
    ]);

    $m     = Charges::find($this->charges_id);
    $m->description         = $this->description;
    $m->type_charges         = $this->type_charges;
    $m->value         = $this->value;
    $m->status         = $this->status;
    $m->save();
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Cobro Actualizado Correctamente', 'modal' => '#createCobros']);

   }


   public function estadochange($id)
   {

       $estado = Charges::find($id);
       $estado->status = $estado->status == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->status == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }


   public function eliminarCobro($id)
   {
       $c = Charges::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Cobro Eliminado Correctamente']);
   }




}

