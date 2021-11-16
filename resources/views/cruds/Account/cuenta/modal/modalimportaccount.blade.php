
<div wire:ignore.self class="modal fade" id="ImportarAccount" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="ImportarAccountLabel"
    aria-hidden="true">
    <div class="modal-dialog"  role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Importar Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="row" >
                        <div class="col-xs-12 col-md-12 form-group">
                            <form action="#" class="dropzone needsclick dz-clickable" id="my-awesome-dropzone">  
                                  <div class="dz-message needsclick">
                                  <img class="file" style="width:50px" src="{{ url('/imagenes/upload.png')}}" >
                                  <br>
                                  <label style="font-weight: 400" class="note needsclick" >Cargar Documento</label>
                                  </div>
                                  @csrf
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button  onclick="ocultarmodal();" class="btn btn-primary">Importar Plan Cuentas</button>
                    </div>
                </div>
        </div>
    </div>
</div>
