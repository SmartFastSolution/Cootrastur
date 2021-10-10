<?php

namespace App\Http\Livewire\Supplier\Proveedores;

use App\Supplier\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class Proveedor extends Component
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
public $supplier_id     = '';
public $status          = 'activo';
public $editMode        = false;
public $createMode      = false;

public $name;
public $code;
public $address;
public $contact;
public $identification;
public $phone1;
public $phone2;
public $fax;
public $email;
public $plazos;
public $line;
public $key_advance;
public $key_supplier;
public $autorization;

    public function render()
    {
        $data = Supplier::where(function($query){
            $query->where('supplier.name', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.supplier.proveedor.tipo-supplier', compact('data'));
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
        $this->reset(['name','code','address','contact','identification','phone1','phone2','fax','email','plazos','line','key_advance','key_supplier','autorization','editMode']);
        $this->resetValidation();
    }

    public function createProveedor (){
        $this->validate([
            'name' =>'required',
            'identification' =>'required',
            'email'    => 'required|email|unique:supplier,email',
            'code' =>'required',

        ],[
            'name.required'      => 'No has agregado el nombre del Proveedor',
            'identification.required'      => 'No has agregado una identificacion del Proveedor',
            'email.email'        => 'Agrega un correo valido',
            'code.required'      => 'No has agregado un codigo del Proveedor',
        ]);

        $this->createMode = true;
        $p  = new Supplier;
        $p->name  = $this->name;
        $p->code = $this->code;
        $p->address = $this->address;
        $p->contact = $this->contact;
        $p->identification = $this->identification;
        $p->phone1 = $this->phone1;
        $p->phone2 = $this->phone2;
        $p->fax = $this->fax;
        $p->email = $this->email;
        $p->plazos = $this->plazos;
        $p->line = $this->line;
        $p->key_advance = $this->key_advance;
        $p->key_supplier = $this->key_supplier;
        $p->autorization  = $this->autorization;
        $p->status       = $this->status == 'activo' ? 'activo' : 'inactivo';

        $p->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => 'Proveedor Registrado Correctamente', 'modal' => '#createProcveedor']);

        $this->createMode = false;
    }


    public function editProveedor ($id)
    {
        $c                    = Supplier::find($id);
        $this->supplier_id    =$id;
        $this->name         =$c->name;
        $this->code         =$c->code;
        $this->address= $c->address;
        $this->contact= $c->contact;
        $this->identification= $c->identification;
        $this->phone1= $c->phone1;
        $this->phone2= $c->phone2;
        $this->fax= $c->fax;
        $this->email= $c->email;
        $this->plazos=$c->plazos;
        $this->line=$c->line;
        $this->key_advance=$c->key_advance;
        $this->key_supplier=$c->key_supplier;
        $this->autorization=$c->autorization;
        $this->status         =$c->status;
        $this->editMode       =true;
   }


   public function updateProveedor()
   {

    $this->validate([
        'name' =>'required',
        'identification' =>'required',
        'email'     => 'required|email|unique:supplier,email,'.$this->supplier_id,
        'code' =>'required',

    ],[
        'name.required'      => 'No has agregado el nombre del Proveedor',
        'identification.required'      => 'No has agregado una identificacion del Proveedor',
        'email.required'     => 'No has agregado el correo',
        'email.email'        => 'Agrega un correo valido',
        'email.unique'       => 'Este correo ya se encuentra en uso',
        'code.required'      => 'No has agregado un codigo del Proveedor',
    ]);

    $m     = Supplier::find($this->supplier_id);
    $m->name         = $this->name;
    $m->address         = $this->address;
    $m->contact         = $this->contact;
    $m->identification         = $this->identification;
    $m->phone1         = $this->phone1;
    $m->phone2         = $this->phone2;
    $m->email         = $this->email;
    $m->plazos         = $this->status;
    $m->line         = $this->line;
    $m->status         = $this->status;
    $m->save();
    $this->resetModal();
    $this->emit('info',['mensaje' => 'Proveedor Actualizado Correctamente', 'modal' => '#createProveedor']);

   }


   public function estadochange($id)
   {

       $estado = Supplier::find($id);
       $estado->status = $estado->status == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->status == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }


   public function eliminarProveedor($id)
   {
       $c = Supplier::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Proveedor Eliminado Correctamente']);
   }




}

