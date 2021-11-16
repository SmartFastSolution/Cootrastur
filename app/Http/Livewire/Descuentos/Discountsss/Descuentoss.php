<?php

namespace App\Http\Livewire\Descuentos\Discountsss;

use App\ConfigurationDiscount\Discount;
use Livewire\Component;
use Livewire\WithPagination;
use DB;
class Descuentoss extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarDescuentos'];
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

public $type_payment;
public $code_discount;
public $key_account;
public $code_account;
public $name_discount;
public $id_partner;
public $identification;
public $beneficiario;

    public function render()
    {
        $data = Discount::
        select('configuration_discount.id','configuration_discount.key_account','configuration_discount.code_account','configuration_discount.type_payment','configuration_discount.name_discount','partner.name_partner','configuration_discount.status')
        ->join('partner', 'partner.id', '=','configuration_discount.id_partner')
        ->where(function($query){
            $query->where('configuration_discount.name_discount', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.configurationdescueto.descuentoss.tipo-discount', compact('data'));
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
        $this->reset(['type_payment','code_discount','key_account','code_account','name_discount','id_partner','identification','editMode']);
        $this->resetValidation();
    }

    public function createDiscount (){
        $this->validate([
            'type_payment' =>'required',
            'code_discount' =>'required',
            'key_account' =>'required',
            'code_account' =>'required',
            'id_partner' =>'required',
    
        ],[
            'type_payment.required'      => 'No has seleccionado un tipo de cobro',
            'code_account.required'      => 'No has agregado un código cuenta contable',
            'key_account.required'      => 'No has agregado una clave de cuenta contable',
            'code_discount.required'      => 'No has seleccionado un tipo descuento',
            'id_partner.required'      => 'No has agregado un Socio',

        ]);

        $this->createMode = true;
        $p  = new Discount;
        $p->type_payment  = $this->type_payment;
        $p->code_discount = $this->code_discount;
        $p->key_account = $this->key_account;
        $p->code_account = $this->code_account;
        $p->name_discount = $this->name_discount;
        $p->id_partner = $this->id_partner;
        $p->status       = $this->status == 'activo' ? 'activo' : 'inactivo';

        $p->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Configuración de descuento Registrado Correctamente', 'modal' => '#createDiscount']);

        $this->createMode = false;
    }


    public function editDiscount ($id)
    {
        $c                    = Discount::find($id);
        
        $this->charges_id    =$id;
        $this->type_payment         =$c->type_payment;
        $this->code_discount         =$c->code_discount;
        $this->key_account  = $c->key_account;
        $this->code_account         =$c->code_account;
        $this->name_discount         =$c->name_discount;
        $this->id_partner         =$c->id_partner;
        $this->status         =$c->status;
        $datosSocios = DB::table('partner')->where('id',$this->id_partner)->first();
        $this->identification         =$datosSocios->identification;
        $this->beneficiario         =$datosSocios->name_partner;
        $this->editMode       =true;
   }


   public function updateDiscount()
   {

    $this->validate([
        'type_payment' =>'required',
        'code_discount' =>'required|unique:configuration_discount,code_discount,'.$this->charges_id,
        'key_account' =>'required|unique:configuration_discount,key_account,'.$this->charges_id,
        'code_account' =>'required|unique:configuration_discount,code_account,'.$this->charges_id,
        'id_partner' =>'required|unique:configuration_discount,id_partner,'.$this->charges_id,

    ],[
        'type_payment.required'      => 'No has seleccionado un tipo de cobro',
        'code_account.required'      => 'No has agregado un código cuenta contable',
        'key_account.required'      => 'No has agregado una clave de cuenta contable',
        'code_discount.required'      => 'No has seleccionado un tipo descuento',
        'id_partner.required'      => 'No has agregado un Socio',
        'code_discount.unique'       => 'Este Tipo de descuento ya se encuentra en uso',
        'key_account.unique'       => 'Esta clave de cuenta ya se encuentra en uso',
        'code_account.unique'       => 'Este código de cuenta ya se encuentra en uso',
        'id_partner.required'      => 'Este Socio ya tiene una configuración',
    ]);

    $m     = Discount::find($this->charges_id);
    $m->type_payment         = $this->type_payment;
    $m->code_discount         = $this->code_discount;
    $m->key_account         = $this->key_account;
    $m->code_account         = $this->code_account;
    $m->name_discount         = $this->name_discount;
    $m->id_partner         = $this->id_partner;
    $m->status         = $this->status;
    $m->save();
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Configuración de descuento Correctamente', 'modal' => '#createDiscount']);

   }


   public function estadochange($id)
   {

       $estado = Discount::find($id);
       $estado->status = $estado->status == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->status == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }


   public function eliminarDescuentos($id)
   {
       $c = Discount::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Configuración de descuento Eliminado Correctamente']);
   }




}

