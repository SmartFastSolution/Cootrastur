<?php

namespace App\Http\Livewire\Sociosaccount\Estado;
use App\Partner\Partner;
use Livewire\Component;
use Livewire\WithPagination;

class cuentassocios extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = [''];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


public $perPage         = 10;
public $search_fecha1          = '';
public $search_fecha2          = '';
public $search_cedula          = '';
public $search_codigo          = '';
public $search          = '';
public $search_nombres          = '';
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
        $fecha1 = $this->search_fecha1; 
        $fecha2 = $this->search_fecha2;
        $data = Partner::where(function($query){
            $query->where('partner.identification', 'like','%'.$this->search_cedula.'%');
        })
        ->where(function($query){
            $query->where('partner.code_trans', 'like','%'.$this->search_codigo.'%');
        })
        ->where(function($query){
            $query->where('partner.name_partner', 'like','%'.$this->search_nombres.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        
        return view('livewire.estadocuentas.cuentasestados.estadoscuentas',compact('data'));
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

}

