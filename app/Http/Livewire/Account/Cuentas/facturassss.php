<?php

namespace App\Http\Livewire\Account\Cuentas;

use App\AccountPlan\AccountPlan;
use App\Bank\Bank;
use Livewire\Component;
use Livewire\WithPagination;
use Validator;
use Illuminate\Support\Facades\Gate;
use DB;
use Illuminate\Http\Request;
use PDF;
use Response;
use View;

class facturassss extends Component 
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarFacturas'];
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

public $name_proveedor;
public $beneficiario;
public $id_bank;
public $type_document;
public $number_voucher;
public $date_registre;
public $date_check;
public $id_proveedor;
public $number_check;
public $total_value;
public $detail_voucher;
public $voucher_detail = [];

public $descargas = [];


    public function render()
    {
        $bancos = Bank::get();
        $data = DB::table('voucher_header')
        ->select('voucher_header.id','voucher_header.date_voucher','voucher_header.number_voucher','voucher_header.detail_voucher','voucher_header.date_registre','partner.name_partner','voucher_header.status','voucher_header.type_document')
        ->join('partner','partner.id', '=', 'voucher_header.id_proveedor')
        ->where(function($query){
            $query->where('voucher_header.number_voucher', 'like','%'.$this->search_code.'%');
        })
        ->orderBy('voucher_header.number_voucher', 'DESC')->paginate($this->perPage);
        return view('livewire.registrevoucher.facturascheque.voucher-entry', compact('data','bancos'));
    
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
        $this->reset(['id_bank','number_voucher','date_registre','date_check','id_proveedor','number_check','total_value',
                      'detail_voucher','beneficiario','name_proveedor','type_document','editMode']);
        $this->resetValidation();
    }

    public function createAccount (){
        

    }


    public function editVoucher ($id)
    {
        $c                     = DB::table('voucher_header')->where('id',$id)->first();
        $socios                     =DB::table('partner')->where('id',$c->id_proveedor)->first();
        $this->account_id      = $id;
        $this->id_bank   = $c->id_bank;
        $this->number_voucher      = $c->number_voucher;
        $this->date_registre  = $c->date_registre;
        $this->type_document  = $c->type_document;
        $this->date_check      =$c->date_check;
        $this->id_proveedor   = $c->id_proveedor;
        $this->number_check      = $c->number_check;
        $this->total_value  = $c->total_value;
        $this->detail_voucher      = $c->detail_voucher;
        $this->editMode       =true;
        $this->status          = $c->status;
        $this->name_proveedor = $socios->identification;
        $this->beneficiario = $socios->name_partner;

        $this->voucher_detail = DB::table('voucher_detail')->where('id_vheader',$id)->get();
    }


   public function updateAccount()
   {
        

   }


   public function estadochange($id)
   {
       
   }



   public function eliminarFacturas($id)
   {
       

   }

   public function descargasExcel($id)
   {
        $this->emit('info',['mensaje' => 'Descargando Excel espere...']);
   }

   public function descargasPDF($id)
   {
        $this->emit('info',['mensaje' => 'Descargando PDF espere...']);
   }

}

