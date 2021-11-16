<?php

namespace App\Http\Livewire\Rubrosporcentaje\Rubross;

use App\Itempercentage\Itempercentage;
use Livewire\Component;
use Livewire\WithPagination;

class Rubross extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarRubro'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


public $perPage         = 10;
public $search          = '';
public $orderBy         = 'id';
public $orderAsc        = true;
public $item_id     = '';
public $status          = 'activo';
public $editMode        = false;
public $createMode      = false;

public $description;
public $type;
public $code;
public $value;

public $key_account;
public $code_account;

    public function render()
    {
        $data = Itempercentage::where(function($query){
            $query->where('items_percentage.description', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.itempercentage.rubros.tipo-itempercentage', compact('data'));
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
        $this->reset(['code','description','type','value','code_account','key_account','editMode']);
        $this->resetValidation();
    }

    public function createItemPercentage (){
        $this->validate([
            'code' =>'required',
            'description' =>'required',
            'type' =>'required',
            'value' =>'required',
            'key_account' =>'required',
            'code_account' =>'required',
    
        ],[
            'code.required'      => 'No has agregado un código del cobro',
            'description.required'      => 'No has agregado el nombre del cobro',
            'type.required'      => 'No has seleccionado un tipo de cobro',
            'value.required'      => 'No has agregado un valor',
            'key_account.required'      => 'No has agregado una clave de cuenta contable',
            'code_account.required'      => 'No has agregado un código de cuenta contable',
        ]);

        $this->createMode   = true;
        $p                  = new Itempercentage;
        $p->code            = $this->code;
        $p->description     = $this->description;
        $p->type            = $this->type;
        $p->value           = $this->value;
        $p->key_account            = $this->key_account;
        $p->code_account     = $this->code_account;
        $p->status          = $this->status == 'activo' ? 'activo' : 'inactivo';

        $p->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Rubro y Porcentaje Registrado Correctamente', 'modal' => '#createRubros']);

        $this->createMode = false;
    }


    public function editItemPercentage ($id)
    {
        $c                    = Itempercentage::find($id);
        $this->item_id        =$id;
        $this->code           =$c->code;
        $this->description    =$c->description;
        $this->type           =$c->type;
        $this->value          = $c->value;
        $this->key_account           =$c->key_account;
        $this->code_account    =$c->code_account;
        $this->status         =$c->status;
        $this->editMode       =true;
   }


   public function updateItemPercentage()
   {

    $this->validate([
        'code' =>'required',
        'description' =>'required',
        'type' =>'required',
        'value' =>'required',
        'key_account' =>'required',
        'code_account' =>'required',
    ],[
        'code.required'      => 'No has agregado un código del cobro',
        'description.required'      => 'No has agregado el nombre del cobro',
        'type.required'      => 'No has seleccionado un tipo de cobro',
        'value.required'      => 'No has agregado un valor',
        'key_account.required'      => 'No has agregado una clave de cuenta contable',
        'code_account.required'      => 'No has agregado un código de cuenta contable',
    ]);

    $m                      = Itempercentage::find($this->item_id);
    $m->code                = $this->code;
    $m->description         = $this->description;
    $m->type                = $this->type;
    $m->value               = $this->value;
    $m->status              = $this->status;
    $m->key_account                = $this->key_account;
    $m->code_account         = $this->code_account;
    $m->save();
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Rubro y Porcentaje Actualizado Correctamente', 'modal' => '#createRubros']);

   }


   public function estadochange($id)
   {

       $estado = Itempercentage::find($id);
       $estado->status = $estado->status == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->status == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }


   public function eliminarRubro($id)
   {
       $c = Itempercentage::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Rubro y Porcentaje Eliminado Correctamente']);
   }




}

