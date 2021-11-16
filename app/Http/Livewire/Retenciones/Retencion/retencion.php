<?php

namespace App\Http\Livewire\Retenciones\Retencion;

use App\ConfigurationRetention\ConfiguracionRetencion;
use Livewire\Component;
use Livewire\WithPagination;

class retencion extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarRetention'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


public $perPage         = 10;
public $search          = '';
public $search_description          = '';
public $orderBy         = 'id';
public $orderAsc        = true;
public $charges_id     = '';
public $status          = 'activo';
public $editMode        = false;
public $createMode      = false;

public $key_account;
public $code_account;
public $percentage;

    public function render()
    {
        $data = ConfiguracionRetencion::select('configuration_retention.id','configuration_retention.code_account','account_plan.description','configuration_retention.status','configuration_retention.percentage')
        ->leftJoin('account_plan', function($join){
            $join->on('account_plan.key_account', '=', 'configuration_retention.key_account');
            $join->on('account_plan.code_account','=','configuration_retention.code_account');
        })
        ->where(function($query){
            $query->where('configuration_retention.code_account', 'like','%'.$this->search.'%');
        })
        ->where(function($query){
            $query->where('account_plan.description', 'like','%'.$this->search_description.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.retention.retentions.retention', compact('data'));
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
        $this->reset(['key_account','code_account','percentage','status','editMode']);
        $this->resetValidation();
    }

    public function createRetentions (){
        $this->validate([
            'percentage' =>'required',
            'key_account' =>'required',
            'code_account' =>'required',
    
        ],[
            'percentage.required'      => 'No has agregado un Porcentaje',
            'key_account.required'      => 'No has agregado una clave de cuenta contable',
            'code_discount.required'      => 'No has agregado una código de cuenta contable',

        ]);

        $this->createMode = true;
        $p  = new ConfiguracionRetencion;
        $p->percentage  = $this->percentage;
        $p->key_account = $this->key_account;
        $p->code_account = $this->code_account;
        $p->status       = $this->status == 'activo' ? 'activo' : 'inactivo';

        $p->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Configuración de retencion Registrado Correctamente', 'modal' => '#createRetention']);

        $this->createMode = false;
    }


    public function editRetention ($id)
    {
        $c                    = ConfiguracionRetencion::find($id);
        $this->charges_id    =$id;
        $this->percentage         =$c->percentage;
        $this->key_account  = $c->key_account;
        $this->code_account         =$c->code_account;
        $this->status         =$c->status;
        $this->editMode       =true;
   }


   public function updateRetention()
   {

    $this->validate([
        'percentage' =>'required',
        'key_account' =>'required|unique:configuration_retention,key_account,'.$this->charges_id,
        'code_account' =>'required|unique:configuration_retention,code_account,'.$this->charges_id,

    ],[
        'percentage.required'      => 'No has agregado un porcentaje',
        'code_account.required'      => 'No has agregado un código cuenta contable',
        'key_account.required'      => 'No has agregado una clave de cuenta contable',
        'key_account.unique'       => 'Esta clave de cuenta ya se encuentra en uso',
        'code_account.unique'       => 'Este código de cuenta ya se encuentra en uso',
    ]);

    $m     = ConfiguracionRetencion::find($this->charges_id);
    $m->percentage         = $this->percentage;
    $m->key_account         = $this->key_account;
    $m->code_account         = $this->code_account;
    $m->status         = $this->status;
    $m->save();
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Configuración de retencion Actualizado Correctamente', 'modal' => '#createRetention']);

   }


   public function estadochange($id)
   {

       $estado = ConfiguracionRetencion::find($id);
       $estado->status = $estado->status == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->status == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }


   public function eliminarRetention($id)
   {
       $c = ConfiguracionRetencion::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Configuración de retencion Eliminado Correctamente']);
   }




}

