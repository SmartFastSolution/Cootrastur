<div wire:ignore.self class="modal fade bd-example-modal-lg" id="createCuenta" tabindex="-1" data-keyboard="false"
    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="myLargeModalLabel">Actualizar Datos </h5>
                @else
                    <h5 class="modal-title" id="myLargeModalLabel">Crear Datos</h5>
                @endif

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Mis Empresas</label>
                        <select wire:model="user_empresa_id" class="form-control @error('user_empresa_id') is-invalid @enderror">
                            <option value="" selected disabled="">Elija una Empresa</option>
                            @foreach ($empresas as $ro)
                                <option value="{{ $ro->id }}">{{ $ro->razon_social }}</option>
                            @endforeach
                        </select>
                        @error('user_empresa_id')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Tipo Cuenta</label>
                        <select wire:model="tipocuenta_id" class="form-control @error('tipocuenta_id') is-invalid @enderror">
                            <option value="" selected disabled="">Elija un Tipo Cuenta</option>
                            @foreach ($tipocuenta as $ro)
                                <option value="{{ $ro->id }}">{{ $ro->descripcion }}</option>
                            @endforeach
                        </select>
                        @error('tipocuenta_id')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Cuenta</label>
                        <input type="text" wire:model.defer="cuenta"
                            class="form-control @error('cuenta') is-invalid @enderror" placeholder="Cuenta">
                        @error('cuenta')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Codigo</label>
                        <input type="numb" wire:model.defer="codigo"
                            class="form-control @error('codigo') is-invalid @enderror" placeholder="Codigo">
                        @error('codigo')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Nivel</label>
                        <input type="text" wire:model.defer="nivel"
                            class="form-control @error('nivel') is-invalid @enderror" placeholder="Nivel">
                        @error('nivel')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                  
                </div>
            
                <div class="row">
                    <div class="form-group col-md-8">
                        <div class="selectgroup selectgroup-pills">
                            <span class="font-weight-bold text-dark"> Estado:</span>
                            <label class="selectgroup-item">
                                <input type="radio" wire:model="estado" name="estado" value="activo"
                                    class="selectgroup-input">
                                <span class="selectgroup-button selectgroup-button-icon"><i
                                        class="fas fa-toggle-on"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" wire:model="estado" name="estado" value="inactivo"
                                    class="selectgroup-input">
                                <span class="selectgroup-button selectgroup-button-icon"><i
                                        class="fas fa-toggle-off"></i></span>
                            </label>
                            <span class="badge @if ($estado=='activo' ) badge-success @else badge-danger @endif">{{ $estado }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer br">

                @if ($editMode)
                    <button type="button" class="btn btn-warning" wire:click="Update">Actualizar Plan Contable</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" class="btn btn-primary" @if ($createMode) disabled @endif wire:click="Create">Crear Plan Contable</button>
                @endif

            </div>
        </div>
    </div>
</div>
