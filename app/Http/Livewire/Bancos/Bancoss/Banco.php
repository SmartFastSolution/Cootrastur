<?php

namespace App\Http\Livewire\Bancos\Bancoss;

use App\Bank\Bank;
use Livewire\Component;
use Livewire\WithPagination;

class Banco extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarBank'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


public $perPage         = 10;
public $search          = '';
public $orderBy         = 'id';
public $orderAsc        = true;
public $bank_id     = '';
public $status          = 'activo';
public $editMode        = false;
public $createMode      = false;

public $description;
public $type_charges;
public $address;
public $value;
public $key_account;
public $code_account;

    public function render()
    {
        $data = Bank::where(function($query){
            $query->where('Bank.description', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.banco.banks.banksss', compact('data'));
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
        $this->reset(['description','status','editMode']);
        $this->resetValidation();
    }

    public function createBank (){
        $this->validate([
            'description' =>'required',
            'key_account' =>'required',
            'code_account' =>'required',
    
        ],[
            'description.required'      => 'No has agregado el nombre del Banco',
            'key_account.required'      => 'No has agregado una clave de Cuenta',
            'code_account.required'      => 'No has agregado un código de Cuenta',
        ]);

        $this->createMode = true;
        $p  = new Bank;
        $p->description  = $this->description;
        $p->key_account  = $this->key_account;
        $p->code_account = $this->code_account;
        $p->status       = $this->status == 'activo' ? 'activo' : 'inactivo';

        $p->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Banco Registrado Correctamente', 'modal' => '#createBanco']);

        $this->createMode = false;
    }


    public function editBank ($id)
    {
        $c                    = Bank::find($id);
        $this->bank_id    =$id;
        $this->description         =$c->description;
        $this->key_account         =$c->key_account;
        $this->code_account         =$c->code_account;
        $this->status         =$c->status;
        $this->editMode       =true;
   }


   public function updateBank()
   {

    $this->validate([
        'description' =>'required',
        'key_account' =>'required',
        'code_account' =>'required',

    ],[
        'description.required'      => 'No has agregado el nombre del Banco',
        'key_account.required'      => 'No has agregado una clave de Cuenta',
        'code_account.required'      => 'No has agregado un código de Cuenta',
    ]);

    $m     = Bank::find($this->bank_id);
    $m->description         = $this->description;
    $m->status         = $this->status;
    $m->key_account         = $this->key_account;
    $m->code_account         = $this->code_account;
    $m->save();
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Banco Actualizado Correctamente', 'modal' => '#createBanco']);

   }


   public function estadochange($id)
   {

       $estado = Bank::find($id);
       $estado->status = $estado->status == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->status == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }


   public function eliminarBank($id)
   {
       $c = Bank::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Banco Eliminado Correctamente']);
   }




}

