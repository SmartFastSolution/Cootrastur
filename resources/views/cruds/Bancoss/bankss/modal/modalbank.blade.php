<div wire:ignore.self class="modal fade" id="createBanco" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createBancoLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Banco</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Banco</h5>
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
                    <button type="button" wire:click="updateBank" class="btn btn-warning">Actualizar Banco</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="createBank" class="btn btn-primary">Crear Banco</button>
                @endif
            </div>
        </div>
    </div>
</div>

@section('js')
    <script >
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