
<div wire:ignore.self class="modal fade" id="createAccount" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createAccountLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Cuenta</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Cuenta</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " >
                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Nivel Cuenta</label>
                        <select  wire:model.defer="level" class="form-control @error('level') is-invalid @enderror" id="level"  onchange="nivelCuenta()">
                            <option value="" >Elige un Tipo</option>
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

                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Codigo Cuenta</label>
                        <input type="text" wire:model.defer="code_account" class="form-control @error('code_account') is-invalid @enderror" placeholder="Código Cuenta" id="code_account" readonly>
                        @error('code_account')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Clave Cuenta</label>
                        <input type="text" wire:model.defer="key_account" class="form-control @error('key_account') is-invalid @enderror" placeholder="Clave Cuenta">
                        @error('key_account')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Descripcion</label>
                        <input type="text" wire:model.defer="description" class="form-control @error('description') is-invalid @enderror"  placeholder="Descripcion">
                        @error('description')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Tipo Cuenta</label>
                        <input type="text" wire:model.defer="account_type" class="form-control @error('account_type') is-invalid @enderror" id="account_type" onchange="nivelCuenta()" placeholder="Tipo Cuenta">
                        @error('account_type')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Subtipo Cuenta</label>
                        <input type="text" wire:model.defer="sub_account" class="form-control @error('sub_account') is-invalid @enderror" id="sub_account" onchange="nivelCuenta()" placeholder="Subtipo Cuenta">
                        @error('adsub_accountdress')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    
                </div>
                <div class="row">
                    
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Objeto</label>
                        <input type="text" wire:model.defer="object" class="form-control @error('object') is-invalid @enderror" id="object" onchange="nivelCuenta()" placeholder="Objeto">
                        @error('object')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Detalle</label>
                        <input type="text" wire:model.defer="detail" class="form-control @error('detail') is-invalid @enderror" id="detail" onchange="nivelCuenta()" placeholder="Objeto">
                        @error('detail')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Auxiliar 1</label>
                        <input type="text" wire:model.defer="aux1" class="form-control @error('aux1') is-invalid @enderror" id="aux1" onchange="nivelCuenta()" placeholder="Auxiliar 1">
                        @error('aux1')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    
                </div>

                <div class="row">

                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Auxiliar 2</label>
                        <input type="text" wire:model.defer="aux2" class="form-control @error('aux2') is-invalid @enderror"  id="aux2" onchange="nivelCuenta()" placeholder="Auxiliar 2">
                        @error('aux2')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Auxiliar 3</label>
                        <input type="text" wire:model.defer="aux3" class="form-control @error('aux3') is-invalid @enderror" id="aux3" onchange="nivelCuenta()" placeholder="Auxiliar 3">
                        @error('aux3')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-md-4 form-group">
                        <label>Visualizacion</label>
                        <select  wire:model.defer="display" class="form-control @error('display') is-invalid @enderror">
                            <option value="" >Elige un Tipo</option>
                            <option value="S" >SI</option>
                            <option value="N" >NO</option>

                        </select>
                        @error('display')
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
                    <button type="button" wire:click="updateAccount" class="btn btn-warning">Actualizar Cuenta</button>
                @else
                    @if ($createMode) disabled @endif
                        <button  type="button" wire:click="createAccount" class="btn btn-primary">Crear Cuentas</button>
                @endif
            </div>
        </div>
    </div>
</div>

@section('js')
<script >
    
function nivelCuenta(){
        console.log($("#level").val());
            if($('#sub_account').val() == ''){
                $("#level").val('1');
                $('#object').val('');
                $('#detail').val('');
                $('#aux1').val('');
                $('#aux2').val('');
                $('#aux3').val('');
                $('#code_account').val($("#account_type").val());
            }else{
                $("#level").val('2');
                $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val());
                if($('#object').val() == ''){
                    $("#level").val('2');
                    $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val());
                }else{
                    $("#level").val('3');
                    $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val()+"."+$('#object').val());
                    if($('#detail').val() == ''){
                        $("#level").val('3');
                        $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val()+"."+$('#object').val());
                    }else{
                        $("#level").val('4');
                         $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val()+"."+$('#object').val()+"."+$('#detail').val());
                        if($('#aux1').val() == ''){
                            $("#level").val('4');
                            $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val()+"."+$('#object').val()+"."+$('#detail').val());
                        }else{
                            $("#level").val('5');
                            $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val()+"."+$('#object').val()+"."+$('#detail').val()+"."+$('#aux1').val());
                            if($('#aux2').val() == ''){
                                $("#level").val('5');
                                $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val()+"."+$('#object').val()+"."+$('#detail').val()+"."+$('#aux1').val());
                            }else{
                                $("#level").val('6');
                                $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val()+"."+$('#object').val()+"."+$('#detail').val()+"."+$('#aux1').val()+"."+$('#aux2').val());
                                if($('#aux3').val() == ''){
                                    $("#level").val('6');
                                    $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val()+"."+$('#object').val()+"."+$('#detail').val()+"."+$('#aux1').val()+"."+$('#aux2').val());
                                }else{
                                    $("#level").val('7');
                                    $('#code_account').val($("#account_type").val()+"."+$('#sub_account').val()+"."+$('#object').val()+"."+$('#detail').val()+"."+$('#aux1').val()+"."+$('#aux2').val()+"."+$('#aux3').val());
                                    
                                }
                            }
                        }
                    }
                }
            }
            @this.set("code_account", $('#code_account').val());
            @this.set("level", $('#level').val());
        }

        var DATA = "";
$("#my-awesome-dropzone").dropzone({
            maxFile:1,
                 maxFilesize: 200,
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
                        "CODIGO CUENTA" ,
                        "DESCRIPCION" ,
                        "CLAVE",
                        "VISUALIZACION" ,
                        
                        ],raw: true, defval:null,range:1});
                         DATA=result;
                                        };
              FR.readAsArrayBuffer(file);
                });
  }
});
var tablasientos=$('#tablasientos').DataTable({"dom": 'lrtip',
                        "deferRender": true,  destroy: true,searching: false,autoWidth: true,responsive: true,"ordering": false,
                        "aoColumnDefs": [{ "width": "15%", "targets": 0 }]
                        ,
                            language: {
                                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                                }
                            });

function ocultarmodal(){
    //$(".loader1").modal('show');
      $('#loader1').modal('show');
    $.get('{!! route('account.import') !!}',{
            cuentas:DATA,
            _token:'{{csrf_token()}}'

        },function(data) {
            if(data == "OK"){
                $("#ImportarAccount").modal('hide');
               
                iziToast.success({
                        title: 'Transporte',
                        message: "Plan Cuentas importados Correctamente",
                        position: 'topRight'
                    });
                    setTimeout(function(){
                    window.location.reload(1);
                }, 5000);
            }else{
                //
                //$('#modalLoader').modal('hide');
                $('.loader1').hide();
                $('#loader1').modal('hide');
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