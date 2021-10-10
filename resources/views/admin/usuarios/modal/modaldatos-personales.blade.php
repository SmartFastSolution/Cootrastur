<div wire:ignore.self class="modal fade bd-example-modal-lg" id="EditUser" tabindex="-1" data-keyboard="false"
    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="myLargeModalLabel">Actualizar Datos Usuario</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-8">
                        <label>Nombres y Apellidos</label>
                        <input type="text" wire:model.defer="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Nombres y Apellidos">
                        @error('name')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>Cédula</label>
                        <input type="text" wire:model.defer="cedula"
                            class="form-control @error('cedula') is-invalid @enderror" placeholder="Cédula">
                        @error('cedula')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Correo Electrónico</label>
                        <input type="email" wire:model.defer="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Correo Electronico" >
                        @error('email')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Seleccione una Ciudad</label>
                        <select wire:model="city_id" class="form-control @error('city_id') is-invalid @enderror">
                            <option value="" selected disabled="">Seleccione una Ciudad</option>
                            @foreach ($ciudades as $ro)
                                <option value="{{ $ro->id }}">{{ $ro->nombre }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Genero</label>
                        <select wire:model="genero" class="form-control @error('genero') is-invalid @enderror">
                            <option value="" selected disabled="">Seleccione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                        @error('genero')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Edad</label>
                        <input type="number" wire:model.defer="edad"
                            class="form-control @error('edad') is-invalid @enderror" placeholder="Edad" >
                        @error('edad')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Teléfono</label>
                        <input type="text" wire:model.defer="telefono"
                        class="form-control @error('telefono') is-invalid @enderror" placeholder="Teléfono" >
                    @error('telefono')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Domicilio</label>
                        <input type="text" wire:model.defer="domicilio"
                            class="form-control @error('domicilio') is-invalid @enderror" placeholder="Domicilio">
                        @error('domicilio')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Fecha Nacimiento</label>
                        <input type="date" wire:model.defer="fecha_n"
                            class="form-control @error('fecha_n') is-invalid @enderror" placeholder="Fecha de Nacimiento">
                        @error('fecha_n')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer br">
                @if ($editMode)
                    <button type="button" class="btn btn-warning" wire:click="UpdateDatos">Actualizar Usuario</button>
                    @endif
            </div>
        </div>
    </div>
</div>