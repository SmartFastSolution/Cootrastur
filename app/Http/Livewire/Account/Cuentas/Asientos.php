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
class asientos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarAsiento'];
    
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


public $perPage         = 10;
public $search          = '';
public $search_code     = '';
public $orderBy         = 'id';
public $orderAsc        = true;
public $account_id     = '';
public $status          = 'BORRADOR';
public $editMode        = false;
public $createMode      = false;

public $import_data;

public $code_voucher;
public $date_voucher;
public $header_description;

public $detalleasiento = array();

    public function render()
    {
        $data = DB::table('account_header')
        ->where(function($query){
            $query->where('account_header.number_voucher', 'like','%'.$this->search_code.'%');
        })
        ->orderBy('account_header.number_voucher', 'DESC')->paginate($this->perPage);
        return view('livewire.accountplan.plancuentas.journal-entry', compact('data'));
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


    public function editAsiento ($id)
    {
        $c                     = DB::table('account_header')->where('id',$id)->first();
        $this->account_id      = $id;
        $this->code_voucher   = $c->code_voucher;
        $this->header_description      = $c->header_description;
        $this->date_voucher  = $c->date_voucher;
        $this->editMode       =true;
        $this->status          = $c->status;
        $this->detalleasiento = DB::table('account_detail')->where('id_header',$id)->get();
    }

    public function reversarAsiento($id)
    {
        
        DB::table('account_header')->where('id',$id)->update([
            'status' => 'BORRADOR'
        ]);
        $this->emit('info',['mensaje' => 'Asiento revertido Correctamente']);
    }

    public function resetModal(){
        $this->reset(['code_voucher','header_description','date_voucher','detalleasiento','editMode']);
        $this->resetValidation();
    }

   public function estadochange($id)
   {

        $estado = DB::table('account_header')->where('id',$id)->first();
        if($estado->status == "BORRADOR"){
            $estado->status = $estado->status == 'BORRADOR' ? 'CONTABILIZADO' : 'BORRADOR';
            DB::table('account_header')->where('id',$id)->update([
                'status' => $estado->status
            ]);
            $idSocio = 0;
            $this->emit('info',['mensaje' => $estado->status == 'CONTABILIZADO' ? 'Asiento Contabilizado Correctamente.' : '']);
            if($estado->status == "CONTABILIZADO"){
                $detalle =  DB::table('account_detail')->where('id_header',$id)->get();
                foreach($detalle as $buscarProveedor) {
                    $reducirSocio = DB::table('partner')->where('code_account',$buscarProveedor->code_account)->first();
                    if(isset($reducirSocio)){
                        $idSocio = $reducirSocio->id; 
                    }
                }
                foreach($detalle as $d) {
                    $descuentoDisminuir = DB::table('configuration_discount')->where('code_account',$d->code_account)->where('key_account',$d->key_account)->where('id_partner',$idSocio)->first();
                    if(isset($descuentoDisminuir)) {
                        if($descuentoDisminuir->type_payment == "E"){
                           // $configs = include('../config/config.php');
                            $socio = DB::table('voucher_header')->where('id',$id)->first();
                            $reducirSocio = DB::table('partner_aditional')->where('id_partner',$idSocio)->first();
                            /////////////////////BUSCAR EL CAMPO AL QUE TENGO QUE RESTAR /////////////////////////
                            if($descuentoDisminuir->code_discount == "1"){
                                $otrosDescuentos = $reducirSocio->payment_aditional;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'payment_aditional' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "2"){
                                $otrosDescuentos = $reducirSocio->safe_vehicule;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'safe_vehicule' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "3"){
                                $otrosDescuentos = $reducirSocio->satellite;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'satellite' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "5"){
                                $otrosDescuentos = $reducirSocio->saving;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'saving' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "6"){
                                $otrosDescuentos = $reducirSocio->other;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'other' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "7"){
                                $otrosDescuentos = $reducirSocio->iess;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'iess' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "8"){
                                $otrosDescuentos = $reducirSocio->garage;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'garage' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "9"){
                                $otrosDescuentos = $reducirSocio->cleaning;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'cleaning' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "10"){
                                $otrosDescuentos = $reducirSocio->penalty_fee;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito, 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'penalty_fee' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "11"){
                                $otrosDescuentos = $reducirSocio->safe_internal;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito, 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'safe_internal' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "12"){
                                $otrosDescuentos = $reducirSocio->store;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito, 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'store' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "13"){
                                $otrosDescuentos = $reducirSocio->membership;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'membership' => $nuevoValor
                                ]);
                            }else if($descuentoDisminuir->code_discount == "4"){
                                $otrosDescuentos = $reducirSocio->ptmo;
                                $nuevoValor = number_format($otrosDescuentos + $d->value_debito , 2, '.', "");
                                DB::table('partner_aditional')->where('id_partner',$idSocio)->update([
                                    'ptmo' => $nuevoValor
                                ]);
                            }
                        }
                    }
                }
            }
        }else{
            $this->emit('info',['mensaje' => $estado->status == 'CONTABILIZADO' ? 'Este Asiento se encuentra Contabilizado.' : '']);
        }   
        

   }

   public function eliminarAsiento($id)
   {
        DB::table('account_header')->where('id',$id)->delete();
        DB::table('account_detail')->where('id_header',$id)->delete();
        $this->emit('info',['mensaje' => 'Asiento Eliminado Correctamente']);
   }


}

