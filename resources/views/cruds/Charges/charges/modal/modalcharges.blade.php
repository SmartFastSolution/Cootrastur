<div wire:ignore.self class="modal fade" id="createCobros" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createCobrosLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Cobro</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Cobro</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " >
                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Descripción</label>
                        <input type="text" wire:model.defer="description" class="form-control @error('description') is-invalid @enderror" placeholder="Nombres Cobro">
                        @error('description')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Tipo Cobro</label>
                        <select  wire:model.defer="type_charges" class="form-control @error('type_charges') is-invalid @enderror">
                            <option value="" >Elige un Tipo Cobro</option>
                            <option value="P" >Porcentaje</option>
                            <option value="V" >Valor</option>
                        </select>
                        @error('type_charges')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Valor</label>
                        <input type="number" wire:model.defer="value" class="form-control @error('value') is-invalid @enderror" placeholder="0.00">
                        @error('value')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
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
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Tipo Cobro</label>
                        <select  wire:model.defer="type_cobros" class="form-control @error('type_cobros') is-invalid @enderror" id="type_cobros">
                            <option value="">Elige un Tipo Cobro</option>
                            <?php foreach($cobrosconfig as $config): ?>                
                                <option value="<?php echo $config->id ?>"><?php echo $config->description ?></option>
                            <?php endforeach; ?>
                        </select>
                            @error('type_cobros')
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
                    <button type="button" wire:click="updateCharges" class="btn btn-warning">Actualizar Cobro</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="createCharges" class="btn btn-primary">Crear Cobro</button>
                @endif
            </div>
        </div>
    </div>
</div>

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

</script>
@endsection