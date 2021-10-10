<div wire:ignore.self class="modal fade" id="createEmpresa" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createPostLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Empresa <i class="fas fa-building"></i></h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Añadir Empresa <i class="fas fa-building"></i></h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Ruc</label>
                    <input wire:model.defer="ruc" type="number" class="form-control">
                </div>

                <div class="form-group">
                    <label>Razón Social</label>
                    <input wire:model.defer="razon_social"  type="text" class="form-control">
                   
                </div>
                <div class="form-group">
                    <label>Clave de Acceso</label>
                    <input wire:model.defer="clave_acceso"  type="text" class="form-control">
                   
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                @if ($editMode)
                    <button type="button" wire:click="updateEmpresa" class="btn btn-warning">Actualizar Empresa</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="CrearEmpresa" class="btn btn-primary">Añadir Empresa</button>
                @endif
            </div>
        </div>
    </div>
</div>