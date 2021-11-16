<div wire:ignore.self class="modal fade" id="createAdvances" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createAdvancesLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Préstamos y Anticipos</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Préstamos y Anticipos</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " >
                <div class="row">
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
                        <label for="email" class="control-label">Código Cuenta Contable</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" wire:model.defer="code_account" class="form-control @error('code_account') is-invalid @enderror" id="code_account" onchange="buscarCuentaCodigo();">
                                @error('code_account')
                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Nombre Socio</label>
                        <input type="text" wire:model.defer="beneficiario" class="form-control @error('beneficiario') is-invalid @enderror" id="beneficiario" readonly>
                        @error('number_check')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-md-4 form-group" >
                        <label>Tipo Préstamos</label>
                        <select  wire:model.defer="type_prestamo" class="form-control @error('type_prestamo') is-invalid @enderror" id="type_prestamo" onchange="tipodeuda();">
                            <option value="" >Elige un Tipo</option>
                            <option value="P" >Préstamos</option>
                            <option value="A" >Anticipo</option>
                        </select>
                        @error('type_prestamo')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Valor</label>
                        <input type="number" wire:model.defer="value_total" class="form-control @error('value_total') is-invalid @enderror" id="value_total" onchange="valor();" placeholder="0.00">
                        @error('value_total')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    @if($type_prestamo == "A")
                    <div class="col-xs-12 col-md-4 form-group" id="interes" style="display: none">
                        <label>Intereses</label>
                        <select  wire:model.defer="id_percentaje" class="form-control @error('id_percentaje') is-invalid @enderror" id="id_percentaje">
                            <option value="">Eligue un porcentaje de interes</option>
                            <?php foreach($intereces as $interes): ?>                
                                <option value="<?php echo $interes->id ?>"><?php echo $interes->description ?></option>
                            <?php endforeach; ?>
                        </select>
                        @error('id_percentaje')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-md-4 form-group" id="formula" style="display: none">
                        <label>Tipo Formula</label>
                        <select  wire:model.defer="type_formula" class="form-control @error('type_formula') is-invalid @enderror" id="type_formula">
                            <option value="" >Elige un Tipo Formula</option>
                            <option value="AL" >Alemana</option>
                            <option value="FA" >Francesa</option>
                        </select>
                        @error('type_formula')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    @else
                    <div class="col-xs-12 col-md-4 form-group" id="interes" >
                        <label>Intereses</label>
                        <select  wire:model.defer="id_percentaje" class="form-control @error('id_percentaje') is-invalid @enderror" id="id_percentaje">
                            <option value="">Eligue un porcentaje de interes</option>
                            <?php foreach($intereces as $interes): ?>                
                                <option value="<?php echo $interes->id ?>"><?php echo $interes->description ?></option>
                            <?php endforeach; ?>
                        </select>
                        @error('id_percentaje')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-md-4 form-group" id="formula" >
                        <label>Tipo Formula</label>
                        <select  wire:model.defer="type_formula" class="form-control @error('type_formula') is-invalid @enderror" id="type_formula">
                            <option value="" >Elige un Tipo Formula</option>
                            <option value="AL" >Alemana</option>
                            <option value="FA" >Francesa</option>
                        </select>
                        @error('type_formula')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    @endif
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Valor Pendiente</label>
                        <input type="number" wire:model.defer="value_pending" class="form-control @error('value_pending') is-invalid @enderror" id="value_pending" readonly>
                        @error('value_pending')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Meses</label>
                        <input type="number" wire:model.defer="months" class="form-control @error('months') is-invalid @enderror" id="months">
                        @error('months')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
                
            <div class="modal-footer bg-whitesmoke br">
                @if ($editMode)
                    <button type="button" wire:click="updateAdvances" class="btn btn-warning">Actualizar</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="createAdvances" class="btn btn-primary">Crear</button>
                @endif
            </div>
        </div>
    </div>
</div>

@section('js')
    <script >

function tipodeuda() {
    if($.trim($('#type_prestamo').val()) != 'A'){
        $("#interes").fadeIn();
        $("#formula").fadeIn();
    }else{
        $("#interes").fadeOut();
        $("#formula").fadeOut();
    }
}
function valor() {
    $("#value_pending").val($("#value_total").val());
    @this.set("value_pending", $('#value_pending').val());
    tipodeuda();
}
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