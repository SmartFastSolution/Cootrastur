<div wire:ignore.self class="modal fade" id="createConfig" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createConfigLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Configuracion</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Configuracion</h5>
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
                    <button type="button" wire:click="updateConfig" class="btn btn-warning">Actualizar Banco</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="createConfig" class="btn btn-primary">Crear Banco</button>
                @endif
            </div>
        </div>
    </div>
</div>
