<?php

namespace App\Http\Livewire\Configurationcharges\mantenimineto;

use App\MantCharges\ManCharges;
use Livewire\Component;
use Livewire\WithPagination;

class mantenimineto extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarMantCobro'];
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
public $value;
public $key_account;
public $code_account;

    public function render()
    {
        $data = ManCharges::where(function($query){
            $query->where('mant_charges.description', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.configuracionCobros.cobrosconfig.chargesconfig', compact('data'));
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
        $this->reset(['description','editMode']);
        $this->resetValidation();
    }

    public function createConfig (){
        $this->validate([
            'description' =>'required',
    
        ],[
            'description.required'      => 'No has agregado el nombre del cobro',
        ]);

        $this->createMode = true;
        $p  = new ManCharges;
        $p->description  = $this->description;
        $p->status       = $this->status == 'activo' ? 'activo' : 'inactivo';
        $p->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Cobro Registrado Correctamente', 'modal' => '#createCobros']);

        $this->createMode = false;
    }


    public function editConfig ($id)
    {
        $c                    = ManCharges::find($id);
        $this->charges_id    =$id;
        $this->description         =$c->description;
        $this->status         =$c->status;
        $this->editMode       =true;
   }


   public function updateConfig()
   {

    $this->validate([
        'description' =>'required',
        
    ],[
        'description.required'      => 'No has agregado el nombre del cobro',
        
    ]);

    $m     = ManCharges::find($this->charges_id);
    $m->description         = $this->description;
    $m->status         = $this->status;
    $m->save();
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Cobro Actualizado Correctamente', 'modal' => '#createCobros']);

   }


   public function estadochange($id)
   {

       $estado = ManCharges::find($id);
       $estado->status = $estado->status == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->status == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }


   public function eliminarConfig($id)
   {
       $c = ManCharges::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Cobro Eliminado Correctamente']);
   }




}

