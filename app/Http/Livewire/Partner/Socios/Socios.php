<?php

namespace App\Http\Livewire\Partner\Socios;

use App\Partner\Partner;
use App\Partner\PartnerAditional;
use Livewire\Component;
use Livewire\WithPagination;
use Validator;
use Illuminate\Support\Facades\Gate;
use DB;
use Illuminate\Http\Request;
class Socios extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarSocios'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


public $perPage         = 10;
public $search          = '';
public $orderBy         = 'id';
public $orderAsc        = true;
public $partner_id     = '';
public $status          = 'activo';
public $editMode        = false;
public $createMode      = false;

public $import_data;

public $code_trans;
public $identification;
public $birthday;
public $date_begin;
public $line;
public $license_plate;
public $year_vehicle;
public $chasis;
public $motor;
public $name_partner;
public $address_partner;
public $phone1;
public $phone2;
public $email;
public $bank;
public $account_bank;
public $driver;
public $type_account;
public $code_account;
public $roles=[];


//////////////INFORMACION ADICIONAL DEL SOCIO /////////////////////////////
public $id_partner;
public $type_vehicule;
public $payment_aditional;
public $safe_vehicule;
public $ptmo;
public $saving;
public $other;
public $iess;
public $garage;
public $cleaning;
public $penalty_fee;
public $safe_internal;
public $store;
public $membership;
public $sensor;
public $satellite;
//////////////INFORMACION ADICIONAL DEL SOCIO /////////////////////////////


    public function render()
    {
        $this->roles =  \DB::table('bank')->get();
        $data = Partner::where(function($query){
            $query->where('partner.name_partner', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
    
        return view('livewire.partner.socios.tipo-partner', compact('data'));
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
        $this->reset(['code_trans','identification','birthday','date_begin','line','phone1','phone2',
                      'license_plate','year_vehicle','chasis','motor','name_partner','address_partner','email',
                      'bank','account_bank','driver','type_account','type_vehicule','payment_aditional','safe_vehicule',
                      'ptmo','saving','other','iess','garage','cleaning','penalty_fee','safe_internal','store','membership',
                      'sensor','satellite','code_account','editMode']);
        $this->resetValidation();
    }

    public function createPartner (){
            $this->validate([
                'name_partner' =>'required',
                'identification' =>'required',
                'email'    => 'required|email|unique:partner,email',
                'code_trans' =>'required',

            ],[
                'name_partner.required'      => 'No has agregado el nombre del Socio',
                'identification.required'      => 'No has agregado una identificacion del Socio',
                'email.email'        => 'Agrega un correo valido',
                'code_trans.required'      => 'No has agregado un codigo del Socio',
                'year_vehicle' => 'Agrege un año de vehiculo valido'
            ]);

            $this->createMode = true;
            $p  = new Partner;
            $p->code_trans  = $this->code_trans;
            $p->identification = $this->identification;
            $p->birthday = $this->birthday;
            $p->date_begin = $this->date_begin;
            $p->line = $this->line;
            $p->license_plate = $this->license_plate;
            $p->year_vehicle = $this->year_vehicle;
            $p->chasis = $this->chasis;
            $p->motor = $this->motor;
            $p->name_partner = $this->name_partner;
            $p->address_partner = $this->address_partner;
            $p->phone1 = $this->phone1;
            $p->phone2 = $this->phone2;
            $p->email  = $this->email;
            $p->code_account  = $this->code_account;
            $p->bank = $this->bank;
            $p->account_bank = $this->account_bank;
            $p->driver = $this->driver;
            $p->type_account  = $this->type_account;
            $p->status       = $this->status == 'activo' ? 'activo' : 'inactivo';

            $p->save();
            $pa  = new PartnerAditional;
            $pa->id_partner = $p->id;
            $pa->type_vehicule  = $this->type_vehicule;
            $pa->payment_aditional = $this->payment_aditional;
            $pa->safe_vehicule = $this->safe_vehicule;
            $pa->ptmo = $this->ptmo;
            $pa->saving = $this->saving;
            $pa->other = $this->other;
            $pa->iess = $this->iess;
            $pa->garage = $this->garage;
            $pa->cleaning = $this->cleaning;
            $pa->penalty_fee = $this->penalty_fee;
            $pa->safe_internal = $this->safe_internal;
            $pa->store = $this->store;
            $pa->membership = $this->membership;
            $pa->sensor  = $this->sensor;
            $pa->satellite  = $this->satellite;
            $pa->save();
            $this->emit('success',['mensaje' => 'Socio Registrado Correctamente', 'modal' => '#createSocios']);
            $this->createMode = false;
            $this->resetModal();


    }


    public function editPartner ($id)
    {
        $c                     = Partner::find($id);
        $this->partner_id      = $id;
        $this->id_partner   = $id;
        $this->code_trans      = $c->code_trans;
        $this->identification  = $c->identification;
        $this->birthday        = $c->birthday;
        $this->date_begin      = $c->date_begin;
        $this->line            = $c->line;
        $this->license_plate   = $c->license_plate;
        $this->code_account     = $c->code_account;
        $this->year_vehicle    = $c->year_vehicle;
        $this->chasis          = $c->chasis;
        $this->motor           = $c->motor;
        $this->name_partner    = $c->name_partner;
        $this->address_partner = $c->address_partner;
        $this->phone1          = $c->phone1;
        $this->phone2          = $c->phone2;
        $this->email           = $c->email;
        $this->bank            = $c->bank;
        $this->account_bank    = $c->account_bank;
        $this->driver          = $c->driver;
        $this->type_account    = $c->type_account;
        $this->status          = $c->status;
        

        $pa         =    PartnerAditional::Where('id_partner',$id)->first();
        $this->type_vehicule        = $pa->type_vehicule;
        $this->payment_aditional    = $pa->payment_aditional;
        $this->safe_vehicule        = $pa->safe_vehicule;
        $this->ptmo                 = $pa->ptmo;
        $this->saving               = $pa->saving;
        $this->other                = $pa->other;
        $this->iess                 = $pa->iess;
        $this->garage               = $pa->garage;
        $this->cleaning             = $pa->cleaning;
        $this->penalty_fee          = $pa->penalty_fee;
        $this->safe_internal        = $pa->safe_internal;
        $this->store                = $pa->store;
        $this->membership           = $pa->membership;
        $this->sensor               = $pa->sensor;
        $this->satellite            = $pa->satellite; 
        $this->editMode             = true;
        
   }


   public function updatePartner()
   {

        $this->validate([
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
        ]);

        $m                  = Partner::find($this->partner_id);
        $m->code_trans      = $this->code_trans;
        $m->identification  = $this->identification;
        $m->birthday        = $this->birthday;
        $m->date_begin      = $this->date_begin;
        $m->line            = $this->line;
        $m->license_plate   = $this->license_plate;
        $m->year_vehicle    = $this->year_vehicle;
        $m->chasis          = $this->chasis;
        $m->motor           = $this->motor;
        $m->name_partner    = $this->name_partner;
        $m->address_partner = $this->address_partner;
        $m->phone1          = $this->phone1;
        $m->phone2          = $this->phone2;
        $m->email           = $this->email;
        $m->code_account     = $this->code_account;
        $m->bank            = $this->bank;
        $m->account_bank    = $this->account_bank;
        $m->driver          = $this->driver;
        $m->type_account    = $this->type_account;
        $m->status          = $this->status;
        $m->save();

        DB::table('partner_aditional')->where('id_partner',$this->partner_id)->update([
            'type_vehicule' =>  $this->type_vehicule,
            'payment_aditional' => $this->payment_aditional,
            'safe_vehicule' => $this->safe_vehicule,
            'ptmo' =>  $this->ptmo,
            'saving' => $this->saving,
            'other' => $this->other,
            'iess' =>  $this->iess,
            'garage' => $this->garage,
            'cleaning' =>$this->cleaning,
            'penalty_fee' => $this->penalty_fee,
            'safe_internal' => $this->safe_internal,
            'store' =>$this->store,
            'membership' => $this->membership,
            'sensor' => $this->sensor,
            'satellite' => $this->satellite
          ]); 
        
        $this->resetModal();
        $this->emit('info',['mensaje' => 'Socio Actualizado Correctamente', 'modal' => '#createSocios']);

   }


   public function estadochange($id)
   {

       $estado = Partner::find($id);
       $estado->status = $estado->status == 'activo' ? 'inactivo' : 'activo';
       $estado->save();
        $this->emit('info',['mensaje' => $estado->status == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }


   public function eliminarSocios($id)
   {
       $c = Partner::find($id);
       DB::table('partner_aditional')->where('id_partner', $id)->delete();
       $c->delete();
       $this->emit('info',['mensaje' => 'Socio Eliminado Correctamente']);
   }


}

