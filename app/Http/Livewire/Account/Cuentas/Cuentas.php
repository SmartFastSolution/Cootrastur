<?php

namespace App\Http\Livewire\Account\Cuentas;

use App\AccountPlan\AccountPlan;
use App\Partner\PartnerAditional;
use Livewire\Component;
use Livewire\WithPagination;
use Validator;
use Illuminate\Support\Facades\Gate;
use DB;
use Illuminate\Http\Request;
class Cuentas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarAccount'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


public $perPage         = 10;
public $search          = '';
public $search_code     = '';
public $orderBy         = 'id';
public $orderAsc        = true;
public $account_id     = '';
public $status          = 'activo';
public $editMode        = false;
public $createMode      = false;

public $import_data;

public $account_type;
public $sub_account;
public $object;
public $detail;
public $aux1;
public $aux2;
public $aux3;
public $description;
public $level;
public $level1;
public $display;
public $code_account;
public $key_account;


    public function render()
    {
        $validacion = DB::table('account_plan')->count();
        $data = AccountPlan::where(function($query){
            $query->where('account_plan.description', 'like','%'.$this->search.'%');
            $query->where('account_plan.code_account', 'like','%'.$this->search_code.'%');
        })->orderBy('account_plan.account_type', 'ASC')
        ->orderBy('account_plan.sub_account', 'ASC')
        ->orderBy('account_plan.object', 'ASC')
        ->orderBy('account_plan.detail', 'ASC')
        ->orderBy('account_plan.aux1', 'ASC')
        ->orderBy('account_plan.aux2', 'ASC')
        ->orderBy('account_plan.aux3', 'ASC')
        ->paginate($this->perPage);
    
        return view('livewire.accountplan.plancuentas.tipo-account', compact('data','validacion'));
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
        $this->reset(['account_type','sub_account','object','detail','aux1','aux2','aux3',
                      'description','level','display','status','code_account','key_account','editMode']);
        $this->resetValidation();
    }

    public function createAccount (){
        //return $this->code_account;
            $this->validate([
                'level' => 'required',
                'account_type' =>'required',
                'description' =>'required',
                'display'    =>'required',

            ],[
                'level.required' => 'No has seleccioando un nivel de cuenta',
                'account_type.required'      => 'No has agregado un tipo de cuenta',
                'description.required'      => 'No has agregado una descripcion a la cuenta',
                'display.required'      => 'No has seleccionado la visualizacion de la cuenta',
            ]);
            
            $this->createMode = true;
            $p  = new AccountPlan;
            $p->account_type = $this->account_type;
            $p->sub_account = $this->sub_account;
            $p->object = $this->object;
            $p->detail = $this->detail;
            $p->aux1 = $this->aux1;
            $p->aux2 = $this->aux2;
            $p->aux3  = $this->aux3;
            $p->description = $this->description;
            $p->level = $this->level;
            $p->display = $this->display;
            $p->code_account  = $this->code_account;
            $p->key_account  = $this->key_account;
            $p->status       = $this->status == 'activo' ? 'activo' : 'inactivo';

            $p->save();
            $this->emit('success',['mensaje' => 'Cuenta Registrado Correctamente', 'modal' => '#createAccount']);
            $this->createMode = false;
            $this->resetModal();


    }


    public function editAccount ($id)
    {
        $c                     = AccountPlan::find($id);
        $this->account_id      = $id;
        $this->account_type   = $c->account_type;
        $this->sub_account      = $c->sub_account;
        $this->object  = $c->object;
        $this->detail        = $c->detail;
        $this->aux1      = $c->aux1;
        $this->aux2            = $c->aux2;
        $this->aux3   = $c->aux3;
        $this->description    = $c->description;
        $this->level          = $c->level;
        $this->display           = $c->display;
        $this->code_account    = $c->code_account;
        $this->key_account    = $c->key_account;
        $this->status          = $c->status;
        $this->editMode       =true;
   }


   public function updateAccount()
   {
        $this->validate([
            'level' => 'required',
            'account_type' =>'required',
            'description' =>'required',
            'display'    =>'required',

        ],[
            'level.required' => 'No has seleccioandoi un nivel de cuenta',
            'account_type.required'      => 'No has agregado un tipo de cuenta',
            'description.required'      => 'No has agregado una descripcion a la cuenta',
            'display.required'      => 'No has seleccionado la visualizacion de la cuenta',
        ]);
        /*$this->validate([
            'name_partner' =>'required',
            'identification' =>'required',
            'email'     => 'required|email|unique:partner,email,'.$this->partner_id,
            'code_trans' =>'required',

        ],[
            'name_partner.required'      => 'No has agregado el nombre del Socio',
            'identification.required'      => 'No has agregado una identificacion del Socio',
            'email.required'     => 'No has agregado el correo',
            'email.email'        => 'Agrega un correo valido',
            'email.unique'       => 'Este correo ya se encuentra en uso',
            'code_trans.required'      => 'No has agregado un codigo del Socio',
        ]);*/

        $m                  = AccountPlan::find($this->account_id);
        $m->account_type      = $this->account_type;
        $m->sub_account  = $this->sub_account;
        $m->object        = $this->object;
        $m->detail      = $this->detail;
        $m->aux1            = $this->aux1;
        $m->aux2   = $this->aux2;
        $m->aux3    = $this->aux3;
        $m->description          = $this->description;
        $m->level           = $this->level;
        $m->display    = $this->display;
        $m->code_account = $this->code_account;
        $m->key_account = $this->key_account;
        $m->status          = $this->status;
        $m->save();
        
        $this->resetModal();
        $this->emit('info',['mensaje' => 'Cuenta Actualizada Correctamente', 'modal' => '#createAccount']);

   }


   public function estadochange($id)
   {

       $estado = AccountPlan::find($id);
       $estado->status = $estado->status == 'activo' ? 'inactivo' : 'activo';
       $estado->save();
        $this->emit('info',['mensaje' => $estado->status == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }

   public function estadoVisualizacion($id)
   {

       $estado = AccountPlan::find($id);
       $estado->display = $estado->display == 'S' ? 'N' : 'S';
       $estado->save();
        $this->emit('info',['mensaje' => $estado->display == 'S' ? 'Estado Visualizacion Activado Correctamente' : 'Estado Visualizacion Desactivado Correctamente']);

   }


   public function eliminarAccount($id)
   {
       $c = AccountPlan::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Cuenta Eliminado Correctamente']);
   }


}

