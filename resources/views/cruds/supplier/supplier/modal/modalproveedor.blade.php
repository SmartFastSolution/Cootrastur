<div wire:ignore.self class="modal fade" id="createProveedor" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createProveedorLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Proveedor</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Proveedor</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " >
                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Código</label>
                        @if ($editMode)
                            <input type="text" wire:model.defer="code" class="form-control @error('code') is-invalid @enderror" placeholder="Código" readonly>
                        @else
                            <input type="text" wire:model.defer="code" class="form-control @error('code') is-invalid @enderror" placeholder="Código">
                        @endif
                        
                        @error('code')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>identificacion</label>
                        <input type="text" wire:model.defer="identification" class="form-control @error('identification') is-invalid @enderror" placeholder="Identificacion">
                        @error('identification')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Nombre</label>
                        <input type="text" wire:model.defer="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nombres Completos">
                        @error('name')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Dirreción</label>
                        <input type="text" wire:model.defer="address" class="form-control @error('address') is-invalid @enderror" placeholder="Dirección">
                        @error('address')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Contacto</label>
                        <input type="text" wire:model.defer="contact" class="form-control @error('contact') is-invalid @enderror" placeholder="Contacto">
                        @error('contact')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-xs-12 col-md-4 form-group">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Correo</label>
                        <input type="email" wire:model.defer="email" class="form-control @error('email') is-invalid @enderror" placeholder="Correo Proveedor">
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
                        <label>Fax</label>
                        <input type="text" wire:model.defer="fax" class="form-control @error('fax') is-invalid @enderror" placeholder="Fax">
                        @error('fax')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Plazos</label>
                        <input type="text" wire:model.defer="plazos" class="form-control @error('plazos') is-invalid @enderror" placeholder="Plazos">
                        @error('plazos')
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
                    
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Clave Cont. Prove</label>
                        <input type="number" wire:model.defer="key_supplier" class="form-control @error('key_supplier') is-invalid @enderror" placeholder="Clave Cont. Prove">
                        @error('key_supplier')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Clave Cont. Anticipo</label>
                        <input type="number" wire:model.defer="key_advance" class="form-control @error('key_advance') is-invalid @enderror" placeholder="Clave Cont. Anticipo">
                        @error('key_advance')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>#Autorizacion</label>
                        <input type="text" wire:model.defer="autorization" class="form-control @error('autorization') is-invalid @enderror" placeholder="Autorizacion">
                        @error('autorization')
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
                    <button type="button" wire:click="updateProveedor" class="btn btn-warning">Actualizar Proveedor</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="createProveedor" class="btn btn-primary">Crear Proveedor</button>
                @endif
            </div>
        </div>
    </div>
</div>