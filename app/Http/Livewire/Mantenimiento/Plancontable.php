<?php

namespace App\Http\Livewire\Mantenimiento;

use App\Servicios\Plancontable as Pcontable;
use App\Servicios\Tipocuenta;
use App\UserEmpresa;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Plancontable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarCuenta'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];

    public $perPage             = 10;
    public $search              = '';
    public $orderBy             = 'plancontables.id';
    public $orderAsc            = true;
    public $plancontable_id     = '';
    public $estado              = 'activo';
    public $editMode            = false;
    public $createMode          = false;
    public $filternivel         ='';
    public $uid;
    public $empresas            =[];
    public $tipocuenta          =[];
    public $user_empresa_id     ='';
    public $tipocuenta_id       ='';
    public $nivel               ='';
    public $codigo              ='';
    public $cuenta              ='';
    public $user_id;


    public function mount(){
        $this->uid = Auth::user()->id;
    }

    public function render()
    {

        $this->tipocuenta= Tipocuenta::all(['id', 'descripcion']);
        $this->empresas= UserEmpresa::where('user_id', $this->uid)->get();

        $data = Pcontable::join('user_empresas','plancontables.user_empresa_id','=','user_empresas.id')
        ->join('tipocuentas','plancontables.tipocuenta_id','=','tipocuentas.id')
       
        ->where(function($query){
            $query->where('tipocuentas.descripcion', 'like', '%'. $this->search . '%')
            ->orWhere('user_empresas.razon_social', 'like', '%' . $this->search . '%')
            ->orWhere('plancontables.cuenta', 'like', '%'. $this->search . '%');
        })       
         ->select('plancontables.*','user_empresas.razon_social as empresa','tipocuentas.descripcion as tipoc')
         ->where(function($query){
            if($this->filternivel !== ''){
                $query->where('plancontables.nivel', $this->filternivel);
            }
        })
         ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);
        

       
        //dd($data);
        return view('livewire.mantenimiento.plancontable', compact('data'));
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
        $this->reset(['editMode','cuenta','nivel','codigo','user_empresa_id','tipocuenta_id']);
        $this->resetValidation();
    }


    public Function Create(){
        $this->validate([
            'cuenta'          =>'required',
            'nivel'           =>'required',
            'codigo'          =>'required',
            'user_empresa_id' =>'required',
            'tipocuenta_id'   =>'required',

        ],[
            'cuenta.required'                     => 'No has agregado La Cuenta',
            'nivel.required'                      => 'No has agregado el Nivel',
            'codigo.required'                     => 'No has agregado el Codigo',
            'user_empresa_id.required'            => 'No has Seleccionado la Empresa',
            'tipocuenta_id.required'              => 'No has Seleccionado el Tipo de Cuenta',
        ]);
        $this->createMode= true;

        $c           = new Pcontable;
        $c->cuenta           = $this->cuenta;
        $c->nivel            = $this->nivel;
        $c->codigo           = $this->codigo;
        $c->user_empresa_id  = $this->user_empresa_id;
        $c->user_id          = Auth::id();
        $c->tipocuenta_id    = $this->tipocuenta_id;
        $c->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $c->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => ' Cuenta Registrada Correctamente', 'modal' => '#createCuenta']);

        $this->createMode = false;
    }

    public function Edit($id){

        $c                      = Pcontable::find($id);
        $this->plancontable_id    =$id;
        $this->cuenta             =$c->cuenta;
        $this->nivel              =$c->nivel;
        $this->codigo             =$c->codigo;
        $this->user_empresa_id    =$c->user_empresa_id;
        $this->tipocuenta_id      =$c->tipocuenta_id;
        $this->estado             =$c->estado;
        $this->editMode           =true;
   
    }

    public Function Update(){
        $this->validate([
            'cuenta'          =>'required',
            'nivel'           =>'required',
            'codigo'          =>'required',
            'user_empresa_id' =>'required',
            'tipocuenta_id'   =>'required',

        ],[
            'cuenta.required'                     => 'No has agregado La Cuenta',
            'nivel.required'                      => 'No has agregado el Nivel',
            'codigo.required'                     => 'No has agregado el Codigo',
            'user_empresa_id.required'            => 'No has Seleccionado la Empresa',
            'tipocuenta_id.required'              => 'No has Seleccionado el Tipo de Cuenta',
        ]);
      

        $c                   =  Pcontable::find($this->plancontable_id);
        $c->cuenta           = $this->cuenta;
        $c->nivel            = $this->nivel;
        $c->codigo           = $this->codigo;
        $c->user_empresa_id  = $this->user_empresa_id;
        $c->user_id          =Auth::id();
        $c->tipocuenta_id    = $this->tipocuenta_id;
        $c->estado           = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $c->save();
        $this->resetModal();
        $this->emit('success',['mensaje' => ' Cuenta Actualizada Correctamente', 'modal' => '#createCuenta']);

    }

      
   public function estadochange($id)
   {

       $estado = Pcontable::find($id);
       $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }

   
   public function eliminarCuenta($id)
   {
       $c = Pcontable::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => ' Cuenta Eliminada Correctamente']);
   }








}
