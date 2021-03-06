<div wire:ignore.self class="modal fade" id="createSocios" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createSociosLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Socio</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Socio</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <section class="section">
                        <div class="section-body">
                            <div class="card">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"aria-selected="true">Datos Personales</a></li>
                                    <li class="nav-item"><a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings"role="tab" aria-selected="false">Datos Adicionales</a></li>
                                </ul>
                                <div class="tab-content tab-bordered" id="myTab3Content">
                                    <div class="tab-pane fade show active" id="about" role="tabpanel"aria-labelledby="home-tab2">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Código</label>
                                                @if ($editMode)
                                                    <input type="text" wire:model.defer="code_trans" class="form-control @error('code_trans') is-invalid @enderror" placeholder="Código" readonly>
                                                @else
                                                    <input type="text" wire:model.defer="code_trans" class="form-control @error('code_trans') is-invalid @enderror" placeholder="Código">
                                                @endif
                                                
                                                @error('code_trans')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>identificación</label>
                                                <input type="text" wire:model.defer="identification" class="form-control @error('identification') is-invalid @enderror" placeholder="Identificación">
                                                @error('identification')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Nombre</label>
                                                <input type="text" wire:model.defer="name_partner" class="form-control @error('name_partner') is-invalid @enderror" placeholder="Nombres Completos">
                                                @error('name_partner')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Dirreción</label>
                                                <input type="text" wire:model.defer="address_partner" class="form-control @error('address_partner') is-invalid @enderror" placeholder="Dirección">
                                                @error('address_partner')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Fecha Nacimiento</label>
                                                <input type="date" wire:model.defer="birthday" class="form-control @error('birthday') is-invalid @enderror" placeholder="Contacto">
                                                @error('birthday')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label class="font-weight-bold text-dark" for="inputPassword4">Correo</label>
                                                <input type="email" wire:model.defer="email" class="form-control @error('email') is-invalid @enderror" placeholder="Correo Socio">
                                                @error('email')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Telefono 1</label>
                                                <input type="tel" wire:model.defer="phone1" class="form-control @error('phone1') is-invalid @enderror" placeholder="Telefono">
                                                @error('phone1')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Telefono 2</label>
                                                <input type="tel" wire:model.defer="phone2" class="form-control @error('phone2') is-invalid @enderror" placeholder="Telefono">
                                                @error('phone2')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Fecha Registro</label>
                                                <input type="date" wire:model.defer="date_begin" class="form-control @error('date_begin') is-invalid @enderror" >
                                                @error('date_begin')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Placa</label>
                                                <input type="text" wire:model.defer="license_plate" class="form-control @error('license_plate') is-invalid @enderror" placeholder="Placa Vehiculo">
                                                @error('license_plate')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Chasis</label>
                                                <input type="text" wire:model.defer="chasis" class="form-control @error('chasis') is-invalid @enderror" placeholder="Chasis">
                                                @error('chasis')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>#Motor</label>
                                                <input type="number" wire:model.defer="motor" class="form-control @error('motor') is-invalid @enderror" placeholder="#Motor">
                                                @error('motor')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Chofer</label>
                                                <input type="text" wire:model.defer="driver" class="form-control @error('driver') is-invalid @enderror" placeholder="Chofer">
                                                @error('driver')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Año Vehiculo</label>
                                                <input type="text" wire:model.defer="year_vehicle" class="form-control @error('year_vehicle') is-invalid @enderror" placeholder="Año Vehiculo 1999">
                                                @error('year_vehicle')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Banco</label>
                                                <input type="text" wire:model.defer="bank" class="form-control @error('bank') is-invalid @enderror" placeholder="Nombre Banco">
                                                @error('bank')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label for="email" class="control-label">Código Cuenta Contable</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" wire:model.defer="code_account" class="form-control @error('code_account') is-invalid @enderror" id="code_account" onchange="buscarCuenta();">
                                                        <span class="input-group-btn ">
                                                            <button type="button" class="btn btn-info form-control" onclick="buscarCuenta();"><i class="fa fa-fw fa-search"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Descripción Cuenta Contable</label>
                                                <input type="text" wire:model.defer="description_account" class="form-control @error('description_account') is-invalid @enderror" id="description_account" placeholder="" readonly>
                                                @error('line')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Linea</label>
                                                <input type="text" wire:model.defer="line" class="form-control @error('line') is-invalid @enderror" placeholder="Linea">
                                                @error('line')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Tipo Cuenta</label>
                                                <input type="text" wire:model.defer="type_account" class="form-control @error('type_account') is-invalid @enderror" placeholder="Tipo Cuenta Bancaria">
                                                @error('type_account')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Numero Cuenta</label>
                                                <input type="text" wire:model.defer="account_bank" class="form-control @error('account_bank') is-invalid @enderror" placeholder="Numero Cuenta">
                                                @error('account_bank')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="selectgroup selectgroup-pills">
                                            <span class="font-weight-bold text-dark" >Estado:</span>
                                            <label class="selectgroup-item">
                                                <input type="radio" wire:model="status" name="status" value="activo" class="selectgroup-input">
                                                <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-toggle-on"></i></span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" wire:model="status" name="status" value="inactivo" class="selectgroup-input">
                                                <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-toggle-off"></i></span>
                                            </label>
                                            <span class="badge @if ($status == 'activo')
                                                badge-success @else badge-danger
                                            @endif">{{ $status }}</span>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="settings" role="tabpanel"aria-labelledby="profile-tab2">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Tipo Vehiculo</label>
                                                <select  wire:model.defer="type_vehicule" class="form-control @error('type_vehicule') is-invalid @enderror">
                                                    <option value="" >Elige un Tipo</option>
                                                    <option value="1" >Grande</option>
                                                    <option value="2" >Mediano</option>
                                                </select>
                                                @error('type_vehicule')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Cuota Ad.</label>
                                                <input type="number" wire:model.defer="payment_aditional" class="form-control @error('payment_aditional') is-invalid @enderror" placeholder="0.00">
                                                @error('payment_aditional')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Seguro Veh.</label>
                                                <input type="number" wire:model.defer="safe_vehicule" class="form-control @error('safe_vehicule') is-invalid @enderror" placeholder="0.00">
                                                @error('safe_vehicule')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Satélital</label>
                                                <input type="number" wire:model.defer="satellite" class="form-control @error('satellite') is-invalid @enderror" placeholder="0.00">
                                                @error('satellite')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Ptmo</label>
                                                <input type="number" wire:model.defer="ptmo" class="form-control @error('ptmo') is-invalid @enderror" placeholder="0.00">
                                                @error('ptmo')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Ahorro</label>
                                                <input type="number" wire:model.defer="saving" class="form-control @error('saving') is-invalid @enderror" placeholder="0.00">
                                                @error('saving')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>IESS</label>
                                                <input type="number" wire:model.defer="iess" class="form-control @error('iess') is-invalid @enderror" placeholder="0.00">
                                                @error('iess')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Garaje</label>
                                                <input type="number" wire:model.defer="garage" class="form-control @error('garage') is-invalid @enderror" placeholder="0.00">
                                                @error('garage')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Limpieza</label>
                                                <input type="number" wire:model.defer="cleaning" class="form-control @error('cleaning') is-invalid @enderror" placeholder="0.00">
                                                @error('cleaning')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Seguro Interno</label>
                                                <input type="number" wire:model.defer="safe_internal" class="form-control @error('safe_internal') is-invalid @enderror" placeholder="0.00">
                                                @error('safe_internal')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Almacén</label>
                                                <input type="number" wire:model.defer="store" class="form-control @error('store') is-invalid @enderror" placeholder="0.00">
                                                @error('store')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Afilización</label>
                                                <input type="number" wire:model.defer="membership" class="form-control @error('membership') is-invalid @enderror" placeholder="0.00">
                                                @error('membership')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Multa</label>
                                                <input type="number" wire:model.defer="penalty_fee" class="form-control @error('penalty_fee') is-invalid @enderror" placeholder="0.00">
                                                @error('penalty_fee')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>#Sensor</label>
                                                <input type="number" wire:model.defer="sensor" class="form-control @error('sensor') is-invalid @enderror" placeholder="0.00">
                                                @error('sensor')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Otros</label>
                                                <input type="number" wire:model.defer="other" class="form-control @error('other') is-invalid @enderror" placeholder="0.00">
                                                @error('other')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-whitesmoke br">
                                    
                                    @if ($editMode)
                                        <button type="button" wire:click="updatePartner" class="btn btn-warning">Actualizar Socio</button>
                                    @else
                                        @if ($createMode) disabled @endif
                                        <button type="button" @if ($createMode) disabled @endif wire:click="createPartner" class="btn btn-primary">Crear Socio</button> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
    </div>
</div>

<style>

    .file { transition: all .2s ease-in-out; }
    .file:hover { transform: scale(1.1);
        cursor:pointer;}
    
    .tooltip .tooltip-inner {
      background-color: #222d32;
      color:white;
    }
    
    .tooltip .arrow::before {
      border-left-color: #222d32;
        color:white;
    }
    
    .btncustom{
    
        border-radius: 25px !important;
        border: 1px solid black !important;
    }
        .custom{
    
            background-color: transparent;
            border-style: none;
        }
    
        .custom:focus, input:focus{
        outline: none;
        }
        .modal-open {
    overflow: scroll;
}
        </style>
@section('js')
    <script >
function buscarCuenta() {
    $.get('{!! route('partner.cuentas') !!}'+'?code='+$("#code_account").val(), function( datos ) {
        if(datos =="" || datos== null){
            iziToast.error({
            title: 'Transporte',
            message: "No existe cuenta con clave "+$("#code_account").val(),
            position: 'topRight'
        });
        }else{
            $("#description_account").val(datos)
        }
        
    }).fail(function() {
        iziToast.error({
            title: 'Transporte',
            message: "Error al buscar Cuenta Contable",
            position: 'topRight'
        });
    });
    
} 

var DATA = "";
$("#my-awesome-dropzone1").dropzone({
            maxFile:1,
                 maxFilesize: 200,
    addRemoveLinks:true,
    acceptedFiles: ".xlsx,.xls,.csv",
    autoProcessQueue:false,

  init: function() {

    this.on("addedfile", function(file) {
      if (this.files[1]!=null){
        this.removeFile(this.files[0]);
      }

        $(".dz-remove").html("Eliminar");
        $('.dz-progress').hide();
        var url ="{{ url('/imagenes/spreadsheet.png')}}";
        $('.dz-image').css('background', 'url(' + url + ')');
        $('.dz-image').css('background-size', '100% 100%');

          var FR = new FileReader();
               FR.onload = function(e) {
                 var data = new Uint8Array(e.target.result);
                 var workbook = XLSX.read(data, {type: 'array'});
                 var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    var result =XLSX.utils.sheet_to_json(firstSheet, {header:[
                        "CODIGO" ,
                        "IDENTIFICACION" ,
                        "NOMBRES" ,
                        "DIRECCION",
                        "FECHA NACIMIENTO",
                        "CORREO",
                        "TELEFONO 1",
                        "TELEFONO 2",
                        "CUENTA CONTABLE",
                        "FECHA REGISTRO",
                        "PLACA",
                        "CHASIS",
                        "MOTOR",
                        "CHOFER",
                        "AÑO VEHICULO",
                        "BANCO",
                        "TIPO CUENTA",
                        "NUMERO CUENTA",
                        "LINEA",
                        "TIPO VEHICULO",
                        "CUOTA AD.",
                        "SEGURO VEH.",
                        "SATELITAL",
                        "PTMO.",
                        "AHORRO",
                        "OTROS",
                        "IESS",
                        "GRAJE",
                        "LIMPIEZA",
                        "MULTA",
                        "SEGURO INTERNO",
                        "ALMACEN",
                        "AFILIACION",
                        "SENSOR",
                        
                        ],raw: true, defval:null,range:1});
                         DATA=result;
                         console.log(result);
                                        };
              FR.readAsArrayBuffer(file);
                });
  }
});
function ocultarmodal(){
    
    $.get('{!! route('partner.import') !!}',{
            json:DATA,
            _token:'{{csrf_token()}}'

        },function(data) {
            if(data == "OK"){
                $('#loader1').modal('show');
                $("#ImportarSocios").modal('hide');
               
                iziToast.success({
                        title: 'Transporte',
                        message: "Socio importados Correctamente",
                        position: 'topRight'
                    });
                setTimeout(function(){
                            window.location.reload(1);
                    }, 5000);
            }else{
                    iziToast.error({
                        title: 'Transporte',
                        message: data,
                        position: 'topRight'
                    });

            }
            
           
        }).fail(function() {
            iziToast.error({
                        title: 'Transporte',
                        message: "Error al importar Socios",
                        position: 'topRight'
                    });
      });
    
}

</script>
@endsection