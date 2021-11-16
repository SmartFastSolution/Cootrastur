<div wire:ignore.self class="modal fade" id="createDiscount" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createDiscountLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Configuración</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Configuración</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " >
                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Tipo Cobro</label>
                        <select  wire:model.defer="type_payment" class="form-control @error('type_payment') is-invalid @enderror">
                            <option value="" >Elige un Tipo Cobro</option>
                            <option value="M" >MENSUAL</option>
                            <option value="E" >EVENTUAL</option>
                        </select>
                        @error('type_payment')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Tipo Descuento</label>
                        <select  wire:model.defer="code_discount" class="form-control @error('code_discount') is-invalid @enderror" id="code_discount">
                            <option value="" >Elige un Tipo Descuento</option>
                            <option value="1" >Cuota Ad.</option>
                            <option value="2" >Seguro Veh.</option>
                            <option value="3" >Satelital</option>
                            <option value="4" >Ptmo.</option>
                            <option value="5" >Ahorro</option>
                            <option value="6" >Otros</option>
                            <option value="7" >IESS</option>
                            <option value="8" >Garaje</option>
                            <option value="9" >Limpieza</option>
                            <option value="10" >Multa</option>
                            <option value="11" >Seguro Interno</option>
                            <option value="12" >Almacen</option>
                            <option value="13" >Afiliacion</option>
                        </select>
                        @error('code_discount')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                        <input type="hidden" wire:model.defer="name_discount" class="form-control @error('name_discount') is-invalid @enderror" id="name_discount">
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label for="email" class="control-label">identifiación Socio</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" wire:model.defer="identification" class="form-control @error('identification') is-invalid @enderror" id="identification">
                                <input class="form-control"  wire:model.defer="id_partner" name="id_partner" type="hidden" id="id_partner" onfocusout="">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-info form-control" onclick="buscarProveedor();"><i class="fa fa-fw fa-search"></i></button>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label for="email" class="control-label">Clave Cuenta Contable</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" wire:model.defer="key_account" class="form-control @error('key_account') is-invalid @enderror" id="key_account" onchange="buscarCuentaClave();">
                                @error('key_account')
                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label for="email" class="control-label">Codigo Cuenta Contable</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" wire:model.defer="code_account" class="form-control @error('code_account') is-invalid @enderror" id="code_account" onchange="buscarCuentaCodigo();">
                                @error('code_account')
                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Nombre Socio</label>
                        <input type="text" wire:model.defer="beneficiario" class="form-control @error('beneficiario') is-invalid @enderror" id="beneficiario" readonly>
                        @error('number_check')
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
            <div class="modal-footer bg-whitesmoke br">
                @if ($editMode)
                    <button type="button" wire:click="updateDiscount" class="btn btn-warning">Actualizar Cobro</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="createDiscount" class="btn btn-primary">Crear Cobro</button>
                @endif
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
        
    $('#code_discount').on('change', function () {
      if($.trim($('#code_discount').val()) != ''){
            $("#name_discount").val($('#code_discount option:selected').text());
            @this.set("name_discount", $('#name_discount').val());
        }
});


function buscarCuentaClave() {
    $("#code_account").val("");
    $.get('{!! route('discount.cuentas') !!}'+'?code='+$("#code_account").val()+'&'+'key='+$("#key_account").val(), function( datos ) {
        if(datos =="" || datos== null){
            if($("#code_account").val()==""){
                iziToast.error({
                    title: 'Transporte',
                    message: "No existe cuenta con clave "+$("#key_account").val(),
                    position: 'topRight'
                });
                $("#key_account").val("");
                $("#code_account").val("");
            }else{
                iziToast.error({
                    title: 'Transporte',
                    message: "No existe cuenta con Código "+$("#code_account").val(),
                    position: 'topRight'
                });
                $("#key_account").val("");
                $("#code_account").val("");
            }
            
        }else{
            if($("#code_account").val()==""){
                $("#code_account").val(datos)
                @this.set("code_account", $('#code_account').val());
                
            }else{
                $("#key_account").val(datos)
                @this.set("key_account", $('#key_account').val());
            }
        }
        
    }).fail(function() {
        iziToast.error({
            title: 'Transporte',
            message: "Error al buscar Cuenta Contable",
            position: 'topRight'
        });
    });
    
} 


function buscarCuentaCodigo() {
    $("#key_account").val("")
    $.get('{!! route('discount.cuentas') !!}'+'?code='+$("#code_account").val()+'&'+'key='+$("#key_account").val(), function( datos ) {
        if(datos =="" || datos== null){
            if($("#code_account").val()==""){
                iziToast.error({
                    title: 'Transporte',
                    message: "No existe cuenta con clave "+$("#key_account").val(),
                    position: 'topRight'
                });
                $("#key_account").val("");
                $("#code_account").val("");
            }else{
                iziToast.error({
                    title: 'Transporte',
                    message: "No existe cuenta con Código "+$("#code_account").val(),
                    position: 'topRight'
                });
                $("#key_account").val("");
                $("#code_account").val("");
            }
            
        }else{
            if($("#code_account").val()==""){
                $("#code_account").val(datos)
                @this.set("code_account", $('#code_account').val());
                
            }else{
                $("#key_account").val(datos)
                @this.set("key_account", $('#key_account').val());
            }
        }
        
    }).fail(function() {
        iziToast.error({
            title: 'Transporte',
            message: "Error al buscar Cuenta Contable",
            position: 'topRight'
        });
    });

    
    
} 
function buscarProveedor() {
                
                $.get('{!! route('vouchers.socios') !!}'+'?identification='+$("#identification").val(), function( datosproveedor ) {
                    if(datosproveedor == "" || datosproveedor == null){
                        iziToast.warning({
                                title: 'Transporte',
                                message: "No se encontro el socio con la identifación "+$("#identification").val(),
                                position: 'topRight'
                        });
                    }else{
                        $("#id_partner").val(datosproveedor[0].id);
                        $("#beneficiario").val(datosproveedor[0].name_partner);
                        @this.set("id_partner", $('#id_partner').val());
                        @this.set("beneficiario", $('#beneficiario').val());
                    }
                        
                }).fail(function() {
    
                });
            } 
</script>
@endsection