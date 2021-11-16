<div wire:ignore.self class="modal fade" id="createParametro" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createParametroLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Parametros</h5>
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
                        <label>Código</label>
                        <input type="text" wire:model.defer="code" class="form-control @error('code') is-invalid @enderror" readonly>
                        @error('code')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Descripción</label>
                        <input type="text" wire:model.defer="description" class="form-control @error('description') is-invalid @enderror" placeholder="Nombres Cobro">
                        @error('description')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Niveles</label>
                        <select  wire:model.defer="level" class="form-control @error('level') is-invalid @enderror" id="level">
                            <option value="" >Elige un Nivel</option>
                            <option value="1" >Nivel 1</option>
                            <option value="2" >Nivel 2</option>
                            <option value="3" >Nivel 3</option>
                            <option value="4" >Nivel 4</option>
                            <option value="5" >Nivel 5</option>
                            <option value="6" >Nivel 6</option>
                            <option value="7" >Nivel 7</option>
                        </select>
                        @error('level')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label for="email" class="control-label">Código Cuenta Contable Inicio</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" wire:model.defer="account1" class="form-control @error('account1') is-invalid @enderror" id="account1" onchange="buscarCuentaClave();">
                                @error('account1')
                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <label for="email" class="control-label">Código Cuenta Contable Fin</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" wire:model.defer="account2" class="form-control @error('account2') is-invalid @enderror" id="account2" onchange="buscarCuentaCodigo();">
                                @error('account2')
                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
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
    $.get('{!! route('parameter.buscarcuenta') !!}'+'?code='+$("#account1").val()+'&'+'level='+$("#level").val(), function( datos ) {
        if(datos =="" || datos== null){
                iziToast.error({
                    title: 'Transporte',
                    message: "No existe cuenta con el código "+$("#account1").val(),
                    position: 'topRight'
                });
                $("#account1").val("");
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
    $.get('{!! route('parameter.buscarcuenta') !!}'+'?code='+$("#account2").val()+'&'+'level='+$("#level").val(), function( datos ) {
        if(datos =="" || datos== null){
                iziToast.error({
                    title: 'Transporte',
                    message: "No existe cuenta el clave código "+$("#account2").val(),
                    position: 'topRight'
                });
                $("#account2").val("");
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