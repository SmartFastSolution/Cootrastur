<?php

namespace App\Http\Livewire\Contableparametro\estadoresult;

use App\ParametroAccount\ParametroAccount;
use Livewire\Component;
use Livewire\WithPagination;

class parametriza extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarParametro'];
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
public $code;
public $level;
public $account1;
public $account2;

    public function render()
    {
        $data = ParametroAccount::where(function($query){
            $query->where('accounting_parameter.description', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.parameaccount.accountparameter.parametrossss', compact('data'));
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
        $this->reset(['description','code','level','account1','account2','status','editMode']);
        $this->resetValidation();
    }

    public function createParametro (){
        $this->validate([
            'description' =>'required',
            'code' =>'required',
            'level' =>'required',
            'account1' =>'required',
            'account2' =>'required',
    
        ],[
            'description.required'   => 'No has agregado la descripción',
            'account1.required'      => 'No has agregado el código de Cuenta 1',
            'account1.required'      => 'No has agregado el código de Cuenta 2',
        ]);

        $this->createMode = true;
        $p  = new ParametroAccount;
        $p->description  = $this->description;
        $p->code         = $this->code;
        $p->level        = $this->level;
        $p->account1     = $this->account1;
        $p->account2     = $this->account2;
        $p->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Parametro Contable Registrado Correctamente', 'modal' => '#createParametro']);

        $this->createMode = false;
    }


    public function editParametro ($id)
    {
        $c                    = ParametroAccount::find($id);
        $this->bank_id    =$id;
        $this->description         =$c->description;
        $this->code         =$c->code;
        $this->level         =$c->level;
        $this->account1         =$c->account1;
        $this->account2         =$c->account2;
        $this->editMode       =true;
   }


   public function updateParametro()
   {

    $this->validate([
        'description' =>'required',
        'code' =>'required',
        'level' =>'required',
        'account1' =>'required',
        'account2' =>'required',

    ],[
        'description.required'   => 'No has agregado la descripción',
        'account1.required'      => 'No has agregado el código de Cuenta 1',
        'account1.required'      => 'No has agregado el código de Cuenta 2',
    ]);

    $m     = ParametroAccount::find($this->bank_id);
    $m->description         = $this->description;
    $m->code         = $this->code;
    $m->level         = $this->level;
    $m->account1         = $this->account1;
    $m->account2         = $this->account2;
    $m->save();
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Parametro Contable Actualizado Correctamente', 'modal' => '#createParametro']);

   }


   public function estadochange($id)
   {


   }


   public function eliminarParametro($id)
   {
       $c = ParametroAccount::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Parametro Contable Eliminado Correctamente']);
   }




}

