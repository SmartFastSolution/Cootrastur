
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
                            <form action="#" class="dropzone needsclick dz-clickable" id="my-awesome-dropzone">  
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
                        <button  onclick="ocultarmodal();" class="btn btn-primary" >  Actualizar Documentos  </button>
                    </div>
                </div>
            </div>
    </div>
</div>


@section('js')
<script>
var DATA = "";
$("#my-awesome-dropzone").dropzone({
            maxFile:1,
                 maxFilesize: 3,
    addRemoveLinks:true,
    acceptedFiles: ".xlsx,.xls,.csv",
    autoProcessQueue:false,

  init: function() {

    this.on("addedfile", function(file) {
      if (this.files[1]!=null){
        this.removeFile(this.files[0]);
      }

        $(".dz-remove").html("Eliminar");
        $('.dz-progress').hide();
        var url ="{{ url('/imagenes/spreadsheet.png')}}";
        $('.dz-image').css('background', 'url(' + url + ')');
        $('.dz-image').css('background-size', '100% 100%');

          var FR = new FileReader();
               FR.onload = function(e) {
                 var data = new Uint8Array(e.target.result);
                 var workbook = XLSX.read(data, {type: 'array'});
                 var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    var result =XLSX.utils.sheet_to_json(firstSheet, {header:[
                        "CODIGO" ,
                        "IDENTIFICACION" ,
                        "NOMBRES" ,
                        "DIRECCION",
                        "FECHA NACIMIENTO",
                        "CORREO",
                        "TELEFONO 1",
                        "TELEFONO 2",
                        "FECHA REGISTRO",
                        "PLACA",
                        "CHASIS",
                        "MOTOR",
                        "CHOFER",
                        "AÑO VEHICULO",
                        "BANCO",
                        "TIPO CUENTA",
                        "NUMERO CUENTA",
                        "LINEA",
                        "TIPO VEHICULO",
                        "CUOTA AD.",
                        "SEGURO VEH.",
                        "SATELITAL",
                        "PTMO.",
                        "AHORRO",
                        "OTROS",
                        "IESS",
                        "GRAJE",
                        "LIMPIEZA",
                        "MULTA",
                        "SEGURO INTERNO",
                        "ALMACEN",
                        "AFILIACION",
                        "SENSOR",
                        
                        ],raw: true, defval:null,range:1});
                         DATA=result;
                         console.log(result);
                                        };
              FR.readAsArrayBuffer(file);
                });
  }
});
function ocultarmodal(){
    $.post('{!! route('partner.import') !!}',{
            json:DATA,
            _token:'{{csrf_token()}}'

        },function(data) {
            if(data == "OK"){
                $("#ImportarSocios").modal('hide');
               
                iziToast.success({
                        title: 'Transporte',
                        message: "Socio importados Correctamente",
                        position: 'topRight'
                    });
            }else{
                    iziToast.error({
                        title: 'Transporte',
                        message: data,
                        position: 'topRight'
                    });

            }
            
           
        }).fail(function() {
           
      });
    
}

</script>
@endsection