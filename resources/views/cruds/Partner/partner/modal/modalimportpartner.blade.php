
<div wire:ignore.self class="modal fade" id="ImportarSocios" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="ImportarSociosLabel"
    aria-hidden="true">
    <div class="modal-dialog"  role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Importar Socios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="row" >
                        <div class="col-xs-12 col-md-12 form-group">
                            <form action="#" class="dropzone needsclick dz-clickable" id="my-awesome-dropzone1">  
                                <input type="hidden" wire:model.defer="import_data" class="form-control @error('import_data') is-invalid @enderror" name="import_data[]" id="import_data[]" placeholder="Autorizacion">  
                                  <div class="dz-message needsclick">
                                  <img class="file" style="width:50px" src="{{ url('/imagenes/upload.png')}}" >
                                  <br>
                                  <label style="font-weight: 400" class="note needsclick" >Cargar Documentos</label>
                                  </div>
                                  @csrf
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button  onclick="ocultarmodal();" class="btn btn-primary" >  Importar Socios  </button>
                    </div>
                </div>
            </div>
    </div>
</div>


@section('js')
<script>

</script>
@endsection