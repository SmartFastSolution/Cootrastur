<?php

namespace App\Http\Livewire\Prestamo\Prestamosss;

use App\Advances\ConfiguracionAdvances;
use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Carbon\Carbon;
class Anticipossss extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarAdvances'];
    protected $queryString     =['search' => ['except' => ''],
        'page',
    ];


    public $perPage         = 10;
    public $search          = '';
    public $search_description          = '';
    public $orderBy         = 'id';
    public $orderAsc        = true;
    public $charges_id     = '';
    public $status          = 'Borrador';
    public $editMode        = false;
    public $createMode      = false;

    public $key_account;
    public $code_account;
    public $type_prestamo;
    public $id_percentaje;
    public $value_total;
    public $months;
    public $id_partner;
    public $value_pending;
    public $beneficiario;
    public $description;
    public $identification;
    public $type_formula;

    public function render()
    {
        $intereces = DB::table('items_percentage')->select('id','description','code_account','value')->where('type', 'P')->get();
        
        $data = ConfiguracionAdvances::select('advances_loan.id','advances_loan.code_account','account_plan.description','advances_loan.status','advances_loan.value_total','advances_loan.months','advances_loan.value_pending','advances_loan.type_prestamo','partner.name_partner','advances_loan.type_formula')
        ->leftJoin('account_plan', function($join){
            $join->on('account_plan.key_account', '=', 'advances_loan.key_account');
            $join->on('account_plan.code_account','=','advances_loan.code_account');
        })
        ->leftJoin('partner', function($join){
            $join->on('partner.id', '=', 'advances_loan.id_partner');
        })
        ->where(function($query){
            $query->where('advances_loan.code_account', 'like','%'.$this->search.'%');
        })
        ->where(function($query){
            $query->where('account_plan.description', 'like','%'.$this->search_description.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.prestamosAnticipos.prestamos.prestamosAnticipos', compact('data','intereces'));
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
        $this->reset(['key_account','code_account','type_prestamo','id_percentaje','value_total','months','value_pending','status','description','editMode','identification']);
        $this->resetValidation();
    }

    public function createAdvances (){
        $this->validate([
            'key_account' =>'required',
            'code_account' =>'required',
            'type_prestamo' =>'required',
            'value_total' =>'required',
            'months' =>'required',
    
        ],[
            'key_account.required'      => 'No has agregado una clave de cuenta contable',
            'code_discount.required'      => 'No has agregado una código de cuenta contable',
            'type_prestamo.required'      => 'No seleccionado un tipo de prestamo',
            'value_total.required'      => 'No has agregado el total del prestamo',
            'months.required'      => 'No has agregado los meses de cobro',
        ]);
        $tipo_prestamo = $this->type_prestamo;
        $this->createMode = true;
        $p  = new ConfiguracionAdvances;
        $p->key_account = $this->key_account;
        $p->code_account = $this->code_account;
        $p->type_prestamo  = $this->type_prestamo;
        $p->value_total = $this->value_total;
        $p->months = $this->months;
        $p->id_partner  = $this->id_partner;
        $p->id_percentaje = ($this->type_prestamo == "A" ? 0 : $this->id_percentaje);
        $p->value_pending  = $this->value_pending;
        $p->type_formula  = $this->type_formula;
        $p->status       = $this->status == 'Borrador' ? 'Borrador' : 'Aprobado';
        $p->save();
        $this->resetModal();
        if( $tipo_prestamo == "A"){
            $this->emit('info',['mensaje' => 'Anticipo Registrado Correctamente', 'modal' => '#createAdvances']);
        }else{
            $this->emit('info',['mensaje' => 'Prestamo Registrado Correctamente', 'modal' => '#createAdvances']);
        }
        $this->createMode = false;
    }


    public function editAdvances ($id)
    {
        $c                    = ConfiguracionAdvances::find($id);
        
        $this->charges_id    =$id;
        $this->type_prestamo         =$c->type_prestamo;
        $this->key_account  = $c->key_account;
        $this->code_account         =$c->code_account;
        $this->value_total  = $c->value_total;
        $this->months         =$c->months;
        $this->id_partner         =$c->id_partner;
        $this->id_percentaje         =$c->id_percentaje;
        $this->value_pending         =$c->value_pending;
        $this->type_formula         =$c->type_formula;
        $this->status         =$c->status;
        $this->editMode       =true;
        $datosCuenta = DB::table('account_plan')->where('key_account',$this->key_account)->where('code_account',$this->code_account)->first();
        $datosSocios = DB::table('partner')->where('id',$this->id_partner)->first();
        $this->description         =$datosCuenta->description;
        $this->identification         =$datosSocios->identification;
        $this->beneficiario         =$datosSocios->name_partner;
   }


   public function updateAdvances()
   {

        $this->validate([
            'key_account' =>'required',
            'code_account' =>'required',
            'type_prestamo' =>'required',
            'value_total' =>'required',
            'months' =>'required',

        ],[
            'key_account.required'      => 'No has agregado una clave de cuenta contable',
            'code_discount.required'      => 'No has agregado una código de cuenta contable',
            'type_prestamo.required'      => 'No seleccionado un tipo de prestamo',
            'value_total.required'      => 'No has agregado el total del prestamo',
            'months.required'      => 'No has agregado los meses de cobro',
        ]);
        $tipo_prestamo = $this->type_prestamo;
        $m     = ConfiguracionAdvances::find($this->charges_id);
        $m->type_prestamo         = $this->type_prestamo;
        $m->key_account         = $this->key_account;
        $m->code_account         = $this->code_account;
        $m->value_total         = $this->value_total;
        $m->months         = $this->months;
        $m->id_partner         = $this->id_partner;
        $m->id_percentaje         = $this->id_percentaje;
        $m->status         = $this->status;
        $m->value_pending         = $this->value_pending;
        $m->type_formula         = $this->type_formula;
        $m->save();
        $this->resetModal();
        if( $tipo_prestamo == "A"){
            $this->emit('info',['mensaje' => 'Anticipo Actualizado Correctamente', 'modal' => '#createAdvances']);
        }else{
            $this->emit('info',['mensaje' => 'Prestamo Actualizado Correctamente', 'modal' => '#createAdvances']);
        }

   }

   public function estadochange($id)
   {

        $estado = ConfiguracionAdvances::find($id);
        $fecha = Carbon::now()->format('Y/m/d');
        //$date_payment = Carbon::now()->startOfMonth()->format('Y/m/d');
        $separarFecha = explode("/", $fecha);
        $ano_real = $separarFecha[0];
        $mesesPago = (int)$separarFecha[1];
        $flag = "NO";
        $date_payment = Carbon::now()->startOfMonth();
        if($estado->status == "Borrador"){
            $estado->status = $estado->status == 'Borrador' ? 'Aprobado' : 'Borrador';
            $valurDeuda = $estado->value_total;
            for($i = 0; $i<$estado->months; $i++){
                $pagosMeses= $i;
                $mesesPago = $mesesPago +1;
                if($mesesPago == 13){
                    $mesesPago = 1;
                    $ano_real = $ano_real+1;
                    /*$fecha2 = Carbon::now()->format('Y/m/d');
                    $endDate = $fecha2->addYear();
                    $ano_proximo = $endDate->format('Y/m/d');
                    $ano_real1 = explode("/", $ano_proximo);
                    $ano_real = $ano_real1[0];*/
                }
                if($estado->type_prestamo == "A"){
                    $temp_1 = $date_payment->addMonth()->startOfMonth();
                    $flag = "SI";
                    $valorMensual = number_format($estado->value_total/$estado->months, 4, '.', "");
                    DB::table('detail_advance_loan')->insert([
                        'id_advances_loan' =>  $id,
                        'value_unit' => $valorMensual,
                        'month_payment' => $pagosMeses+1,
                        'status' =>  "PENDIENTE",
                        'value_interes' => 0,
                        'month' => $mesesPago ,
                        'year' => $ano_real,
                        'date_payment' => $temp_1->format('Y-m').'-'.date( 't', strtotime( $date_payment->startOfMonth()->format('Y-m-d') )),
                    ]);
                }else{
                    if($estado->type_formula == "AL"){
                        $temp_1 = $date_payment->addMonth()->startOfMonth();
                        $porcentaje = DB::table('items_percentage')->where('id', $estado->id_percentaje)->first();
                        if(isset($porcentaje)){
                            $valorNeto = number_format($estado->value_total/$estado->months, 4, '.', "");
                            $valorinteres = number_format($valurDeuda*($porcentaje->value/100), 4, '.', "");
                            $valorMensual = number_format($valorNeto+$valorinteres, 4, '.', "");
                            $valurDeuda = number_format($valurDeuda-$valorNeto, 4, '.', "");
                            DB::table('detail_advance_loan')->insert([
                                'id_advances_loan' =>  $id,
                                'value_unit' => $valorMensual,
                                'month_payment' => $pagosMeses+1,
                                'status' =>  "PENDIENTE",
                                'value_interes' => number_format($valorInteres, 4, '.', "") ,
                                'value_pending' =>$valurDeuda,
                                'month' => $mesesPago ,
                                'year' => $ano_real,
                                'date_payment' => $temp_1->format('Y-m').'-'.date( 't', strtotime( $date_payment->startOfMonth()->format('Y-m-d') )),
                            ]);
                            $flag = "SI";
                        }else{
                            $flag = "NO";
                        }
                    }else{
                        $temp_1 = $date_payment->addMonth()->startOfMonth();
                        $porcentaje = DB::table('items_percentage')->where('id', $estado->id_percentaje)->first();
                        if(isset($porcentaje)){
                           /* $divideno =$estado->value_total*($porcentaje->value/100);
                            $divisor =  (1 - pow((1 +($porcentaje->value/100)), -$estado->months));
                            $division = number_format($divideno/$divisor, 4, '.', "");
                            $intereses = $valurDeuda*($porcentaje->value/100)*1; 
                            $valorCapital = $division-$intereses;
                            $valurDeuda = number_format($valurDeuda-$valorCapital, 4, '.', "");
                            DB::table('detail_advance_loan')->insert([
                                'id_advances_loan' =>  $id,
                                'value_unit' => $division,
                                'month_payment' => $i,
                                'status' =>  "PENDIENTE",
                                'value_interes' => $intereses,
                                'value_pending' =>$valurDeuda,
                                'month' => $mesesPago ,
                                'year' => $ano_real,
                                'date_payment' => $temp_1->format('Y-m').'-'.date( 't', strtotime( $date_payment->startOfMonth()->format('Y-m-d') )),
                            ]);*/
                            $interestotal =$estado->value_total*($porcentaje->value/100);
                            $totalPagar = $estado->value_total + $interestotal;
                            $CuotasPagar = $totalPagar/$estado->months;
                            $valorInteres = $interestotal/$estado->months;
                            $valornetoDeuda = $CuotasPagar-$valorInteres;
                            $valurDeuda = number_format($valurDeuda-$valornetoDeuda, 4, '.', "");
                            DB::table('detail_advance_loan')->insert([
                                'id_advances_loan' =>  $id,
                                'value_unit' => $CuotasPagar,
                                'month_payment' => $pagosMeses+1,
                                'status' =>  "PENDIENTE",
                                'value_interes' =>number_format($valorInteres, 4, '.', "") ,
                                'value_pending' =>$valurDeuda,
                                'month' => $mesesPago ,
                                'year' => $ano_real,
                                'date_payment' => $temp_1->format('Y-m').'-'.date( 't', strtotime( $date_payment->startOfMonth()->format('Y-m-d') )),
                            ]);
                            $flag = "SI";
                        }else{
                            $flag = "NO";
                        }
                    }
                }
                
            }
            if($flag == "NO"){
                $this->emit('info',['mensaje' => 'Configura un porcentaje de interes para este prestamo']);
            }else{
                $estado->save();
                $this->emit('info',['mensaje' => $estado->status == 'Aprobado' ? 'Estado Aprobado Correctamente' : 'Su prestamo o Anticipo ya se encuentra Aprobado']);
            }
            
            
       }else{
            $this->emit('info',['mensaje' => $estado->status == 'Aprobado' ? 'Su prestamo o Anticipo ya se encuentra Aprobado' : '']);
       }
        

   }
   public function eliminarAdvances($id)
   {
       $c = ConfiguracionAdvances::find($id);
       
       $tipo= $c->type_prestamo;
       $c->delete();
       DB::table('detail_advance_loan')->where('id_advances_loan',$id)->delete();
       if($tipo == "A"){
            $this->emit('info',['mensaje' => 'Anticipo Eliminado Correctamente']);
       }else{
            $this->emit('info',['mensaje' => 'Prestamo Eliminado Correctamente']);
       }
       
    }
}

