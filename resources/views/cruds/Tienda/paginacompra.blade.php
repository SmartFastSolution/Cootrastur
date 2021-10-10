@extends('layouts.app')

@section('content')

    <div id="compraservicio">
        <section class="section">
            <div class="section-body">
                @if ($data->isNotEmpty())
                    @foreach ($data as $key => $p)

                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="invoice-title">
                                            <h2>{{ $p->nombre }}</h2>
                                            <div class="invoice-number"></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address>
                                                    <strong>{{ $p->nombre }}</strong><br>
                                                    <p>
                                                        {!!htmlspecialchars_decode($p->descripcion)!!}
                                                    </p>
                                                </address>
                                            </div>
                                            <div class="col-md-6 text-md-right">

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4>Planes</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                            <li class="nav-item" v-for="(tipo, index) in tipoplans" :key="tipo.id">
                                                                <a class="nav-link " ref="index" :class="index == 0 ? 'active' : '' "  id="home-tab2"
                                                                    data-toggle="tab" href="#home" role="tab"
                                                                    aria-controls="home"
                                                                    aria-selected="true" @click="mostrardetalle(tipo)" >@{{ tipo . nombre }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content tab-bordered" id="myTab3Content">
                                                            <div class="tab-pane fade show active"  id="home"
                                                                role="tabpanel" aria-labelledby="home-tab2">
                                                              
                                                                <p><span align="left" v-html="detalle.descripcion"></span></p>
                                                                <br>
                                                                <h3><strong >$ @{{detalle.costo}}</strong></h3>
                                                                <br>
                                                                <div class="text-md-right">
                                                                    <div class="float-lg-left mb-lg-0 mb-3">
                                                                       <button class="btn btn-primary btn-icon icon-left" :disabled="buttonDisable"
                                                                        @click.prevent="validaciones('pendiente')"> <i class="fas fa-credit-card"></i> Seleccionar Plan</button>
                                                                       
                                                                    </div>
                                                                    <br>
                                                                    {{-- <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6 text-md-right">
                                                {{-- <address>
                                                    <strong>Order Date:</strong><br>
                                                    June 26, 2018<br><br>
                                                </address> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">
                                    <a type="button" class="btn btn-danger btn-icon icon-left" href="{{route('tienda.index',)}}" > <i class="fas fa-times"></i>Cancelar</a>
                                 
                                  
                                        
                                </div>
                                <br>
                                {{-- <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button> --}}
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </section>

    </div>

@endsection


@section('js')

    <script type="text/javascript">
         class Errors {
            constructor() {
                this.errors = {}
            }
            has(field) {
                return this.errors.hasOwnProperty(field);
            }
            get(field) {
                if (this.errors[field]) {
                    return this.errors[field][0]
                }
            }
            record(errors) {
                this.errors = errors;
            }
            any() {
                return Object.keys(this.errors).length > 0;
            }
            anyfiles(query) {
                const asArray = Object.entries(this.errors);
                //const atLeast9Wins = asArray.filter(([key, value]) => key !== 'fecha_atencion' && key !== 'responsable_id' && key !== 'detalle_atencion' && key !== 'observacion' );
                const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                    1);
                const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);

                return Object.keys(atLeast9WinsObject).length > 0;
            }
            archivos(query) {
                const asArray = Object.entries(this.errors);
                //const atLeast9Wins = asArray.filter(([key, value]) => key !== 'fecha_atencion' && key !== 'responsable_id' && key !== 'detalle_atencion' && key !== 'observacion' );
                const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                    1);
                const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);
                return atLeast9WinsObject;
            }

        }

        let plans = @json($tipoplan);
        const compraservicio = new Vue({
            el: "#compraservicio",
            name: "Compra Servicios",
            data: {
                tipoplans: plans,
               
                buttonDisable: false,
                plans: [],
                detalle:{
                    costo:'',
                    descripcion:'',
                    subservice_id:'',
                    errors: new Errors,
                    tipoplan_id: '',
                    plan_id:'',

                },
            },

            mounted() {
     
              var tp = this.tipoplans;
              
              this.tipoplans.forEach((element ,index, array) => {
                  console.log(element);
                  if (index == 0) {
                    this.detalle.costo = element.costo;
                    this.detalle.descripcion = element.descripcion;
                    this.detalle.subservice_id = element.subservice_id;
                    this.detalle.tipoplan_id = element.tipoplan_id;
                    this.detalle.plan_id = element.id;
                    
                  }
                                  
              });
            },

            methods: {

            
                mostrardetalle(tipo){
                  
                    this.detalle.costo = tipo.costo;
                    this.detalle.descripcion = tipo.descripcion;
                    this.detalle.subservice_id = tipo.subservice_id;
                    this.detalle.tipoplan_id = tipo.tipoplan_id;
                }, //end mostrardetalle

                validaciones(estado){
                    let datos = this.createData(estado);
                    return this.StoreData(datos);
                    console.log(datos);
                }, //end validacion 

                createData(estado){
                    let set = this;
                    let url ='/tienda/storeplan';
                    
                    let data = new FormData();
                    data.append('subservice_id', this.detalle.subservice_id);
                    data.append('tipoplan_id', this.detalle.tipoplan_id);
                    data.append('costo', this.detalle.costo);
                    data.append('plan_id', this.detalle.plan_id);
                    data.append('estado', estado);
                    
                    let datos ={
                        url: url,
                        data: data 
                    };
                    return datos;
                    console.log(datos);

                }, //createdata End
                
                StoreData(data){
                    let set = this;
                    axios.post(data.url, data.data)
                        .then(function(res){
                            console.log(res.data);
                            this.buttonDisable = true;
                            let link = '{{ route('tienda.index')}}';
                            window.location = link;
                        })
                        .catch(function(error) {
                            if (error.response.status == 422) {
                                set.errors.record(error.response.data.errors);
                            }
                            set.buttonDisable = false;
                         });

                }, //end storedata
                
            },

        });
    </script>




@endsection
