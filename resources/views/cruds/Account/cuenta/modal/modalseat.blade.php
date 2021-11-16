<div wire:ignore.self class="modal fade" id="createAsiento" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createAsientoLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document" id="modalCreacion">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Asiento</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Asiento</h5>
                @endif
            </div>
                <div class="modal-body">
                    <section class="section">
                        <div class="section-body">
                            <div class="card">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"aria-selected="true">Cabecera</a></li>
                                    <li class="nav-item"><a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings"role="tab" aria-selected="false">Detalle</a></li>
                                </ul>
                                <div class="tab-content tab-bordered" id="myTab3Content">
                                    <div class="tab-pane fade show active" id="about" role="tabpanel"aria-labelledby="home-tab2">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Tipo Cobro</label>
                                                <select  wire:model.defer="code_voucher" class="form-control @error('code_voucher') is-invalid @enderror"  id="code_voucher">
                                                    <option value="" >Elige un Asiento</option>
                                                    <option value="001" >Diario</option>
                                                    <option value="002" >Automatico</option>
                                                </select>
                                                @error('code_voucher')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Fecha</label>
                                                <input type="date" wire:model.defer="date_voucher" id="date_voucher" class="form-control @error('date_voucher') is-invalid @enderror">
                                                @error('date_voucher')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12 form-group">
                                                <label>Detealle</label>
                                                <input type="text" wire:model.defer="header_description" class="form-control @error('header_description') is-invalid @enderror" id="header_description" placeholder="Descripcion Asiento">
                                                @error('header_description')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="settings" role="tabpanel"aria-labelledby="profile-tab2">
                                        <div class="col-xs-12 col-md-6 form-group">
                                            <label for="email" class="control-label">Cuenta/Clave contable</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input class="form-control" name="codigo_cuenta" type="text" id="codigo_cuenta" onfocusout="">
                                                    <span class="input-group-btn ">
                                                        <button type="button" class="btn btn-info form-control" onclick="buscarCuenta();"><i class="fa fa-fw fa-search"></i></button>
                                                    </span>
                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-12 form-group">
                                            <div class="table-responsive">
                                                <table class="table table-striped  datatable dt-select" id="tablasientos">
                                                    <thead>
                                                        <tr>
                                                            <th style='font-size:15px'>Acción</th>
                                                            <th style='font-size:15px'>Clave</th>
                                                            <th style='font-size:15px'>Número cuenta</th>
                                                            <th style='font-size:15px'>Nombre</th>
                                                            <th style='font-size:15px'>Débito</th>
                                                            <th style='font-size:15px'>Crédito</th>
                                                            <th style='font-size:15px'>Referencia</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                    <tfoot >
                                                        <tr style="font-family: Titillium Web;color:#434343;">
                                                             <th colspan="3" style="font-size: 12px;text-align: right;padding: 7px  7px;" >TOTAL</th>
                                                             <th style="font-size: 12px;text-align: right;padding:  7px  7px;"></th>
                                                             <th style="font-size: 12px;text-align: left;padding:  7px  7px;"></th>
                                                             <th style="font-size: 12px;text-align: left;padding:  7px  7px;"></th>
                                                             <th style="font-size: 12px;text-align: left;padding:  7px  7px;"></th>
                                                         </tr>
                                                     </tfoot>
                                                </table>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="modal-footer bg-whitesmoke br">
                                    <button type="button" class="btn btn-danger " data-dismiss="modal">Cerrar</button>
                                    <button id="actualizar" onclick="actualizarA();" class="btn btn-warning" style="display: none;">Actualizar Asiento</button>
                                    @if ($editMode)
                                    @else
                                        @if ($createMode) disabled @endif
                                        <button id="crear" onclick="guardarA();" class="btn btn-primary">Crear Asiento</button> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
    </div>
</div>
<div wire:ignore.self class="modal fade" id="modalCuentas" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalCuentasLabel"
    aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lista de Cuentas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped  datatable dt-select" id="tablacuenta">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center">Numero Cuenta </th>
                            <th class="px-4 py-2 text-center">Numero Cuenta </th>
                        </tr>
                    </thead>

                </table>

            </div>
        </div>
    </div>
</div>
<style>

    .file { transition: all .2s ease-in-out; }
    .file:hover { transform: scale(1.1);
        cursor:pointer;}
    
    .tooltip .tooltip-inner {
      background-color: #222d32;
      color:white;
    }
    
    .tooltip .arrow::before {
      border-left-color: #222d32;
        color:white;
    }
    
    .btncustom{
    
        border-radius: 25px !important;
        border: 1px solid black !important;
    }
        .custom{
    
            background-color: transparent;
            border-style: none;
        }
    
        .custom:focus, input:focus{
        outline: none;
        }
        </style>
@section('js')
    <script >

var tablasientos=$('#tablasientos').DataTable({
    footerCallback: function ( nRow, data, iStart, iEnd, aiDisplay ) {

var total_debitp= 0;
var  total_credito= 0;
var total_cuadrar= 0;
var api = this.api();
for (var i = iStart; i < iEnd; i++) {
    
    total_debitp= parseFloat(parseFloat(total_debitp) + parseFloat(tablasientos.cell(i,4).nodes().to$().find('input').val())).toFixed(2);
    total_credito = parseFloat(parseFloat(total_credito) + parseFloat(tablasientos.cell(i,5).nodes().to$().find('input').val())).toFixed(2);
    //total_debitp = parseFloat(total_debitp + tablasientos.cell(i,4).nodes().to$().find('input').val()).toFixed(2); 
    //total_credito = parseFloat(total_credito + tablasientos.cell(i,5).nodes().to$().find('input').val()).toFixed(2); 
    
    
}

$( api.column( 4 ).footer() ).html("$"+parseFloat(total_debitp).toFixed(2));
$( api.column( 5 ).footer() ).html("$"+parseFloat(total_credito).toFixed(2));
total_cuadrar =parseFloat(parseFloat(parseFloat(total_debitp) - parseFloat(total_credito))).toFixed(2);
$( api.column( 6 ).footer() ).html("$"+parseFloat(total_cuadrar).toFixed(2));
},
         "deferRender": true,  destroy: true,searching: false,bPaginate: false,autoWidth: true,responsive: true,"ordering": false,
         "aoColumnDefs":[
        { "width": "30px", "targets": [0,4,5,6]},
           { "width": "50px", "targets": 1},
           { "width": "50px", "targets": 2},
            { "width": "500px", "targets": 3},
        ]
,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        });
        $("#tablasientos").on('click', '#delete', function () {
       
            var t = $('#tablasientos').DataTable();
            let $tr = $(this).parent().parent();
            t.row($tr).remove().draw(false);
                calculonuevo();      
        });
        function buscarDetalle(id) {
            
            $('#actualizar').show();
            $('#crear').hide();
            
            tablasientos.clear().draw();
                $.get('{!! route('account.buscardetalle') !!}'+'?id='+id, function( datos ) {
                    $("#code_voucher").val(datos[0].code_voucher);
                    $("#date_voucher").val(datos[0].date_voucher);
                    $("#header_description").val(datos[0].header_description);
                    $("#account_id").val(datos[0].id)
                    for (var i = 0; i < datos.length; i++) {
                        if(datos[0].estado == "BORRADOR"){
                                tablasientos.row.add([
                                    '<button id="delete"  type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>',
                                    datos[i].key_account,
                                    datos[i].code_account,
                                    '<input type="text" style="width:100%;pading-top:-50px"  class="custom" value="'+datos[i].header_description+'">',
                                    '<input type="text" name="debe" value="'+datos[i].value_debito+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                    "-"+'<input type="text" name="haber" value="'+parseFloat(datos[i].value_credito*-1).toFixed(2)+'" onchange="Decimal(this)" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                    '<input type="text" style="width:100%;pading-top:-50px"  class="custom" value="'+datos[i].reference+'">',
                                ]).draw( false );
                            footerTabla = "1";
                        }else{
                            $('#actualizar').hide();
                            footerTabla = "2";
                            tablasientos.row.add([
                                '',
                                datos[i].key_account,
                                datos[i].code_account,
                                datos[i].description_account,
                                datos[i].value_debito,
                                datos[i].value_credito,
                               datos[i].reference,
                            ]).draw( false );
                        }
                    }
                    calculonuevo(); 
                    $('#createAsiento').modal('show'); 
                }).fail(function() {
                    iziToast.error({
                        title: 'Transporte',
                        message: "Error al buscar detalle de Asiento",
                        position: 'topRight'
                    });
                   
                });
                //calculonuevo();
        } 

function mostrarBoton() {
    $('#actualizar').hide();
    $('#crear').show();
    tablasientos.clear().draw();
    $("#code_voucher").val("");
    $("#date_voucher").val("");
    $("#header_description").val("");
    footerTabla = "1";
}

function calculonuevo() {

    debe = 0;
                haber = 0;
                total = 0.00;
                if(footerTabla == "1"){
                    $('#tablasientos tbody tr').each(function( index) {
                        debe= parseFloat(parseFloat(debe) + parseFloat(tablasientos.cell(index,4).nodes().to$().find('input').val())).toFixed(2);
                        haber = parseFloat(parseFloat(haber) + parseFloat(tablasientos.cell(index,5).nodes().to$().find('input').val())).toFixed(2);
                        total =parseFloat(parseFloat(parseFloat(debe) - parseFloat(haber))).toFixed(2);
                    });
                }else{

                    $('#tablasientos tbody tr').each(function( index) {
                        debe= parseFloat(parseFloat(debe) + parseFloat(tablasientos.row(index).data()[4])).toFixed(2);
                        haber = parseFloat(parseFloat(haber) + parseFloat(tablasientos.row(index).data()[5])).toFixed(2);
                        total =parseFloat(parseFloat(parseFloat(debe) + parseFloat(haber))).toFixed(2);
                    });
                }
                
                if(tablasientos.rows().count() == 0){
                    column = tablasientos.column( 4 );
                    $( column.footer() ).html("$0.00");
                    column = tablasientos.column( 5 );
                    $( column.footer() ).html("$0.00");
                    column = tablasientos.column( 6 );
                    $( column.footer() ).html("$0.00");
                }else{
                    column = tablasientos.column( 4 );
                    $( column.footer() ).html("$"+parseFloat(debe).toFixed(2));
                    column = tablasientos.column( 5 );
                    $( column.footer() ).html("$"+parseFloat(haber).toFixed(2));
                    column = tablasientos.column( 6 );
                    $( column.footer() ).html("$"+parseFloat(total).toFixed(2));
                }
}
       
                function buscarCuenta() {
                    
                    if($("#codigo_cuenta").val()==""){
                        iziToast.error({
                            title: 'Transporte',
                            message: "Ingrese una clave o código de cuenta",
                            position: 'topRight'
                        });
                    }else{
                        $('#createAsiento').modal('hide');
                   
                        
                        $('#loader1').modal('show');
                        $.get('{!! route('account.listacuentas') !!}'+'?code='+$("#codigo_cuenta").val(), function( datos ) {
                            var rowCount =document.getElementById("tablasientos").rows.length;
                            if(datos.length == 0){
                                iziToast.error({
                                    title: 'Transporte',
                                    message: "No existe cuenta con clave/codigo "+$("#codigo_cuenta").val(),
                                    position: 'topRight'
                                });
                            }else{

                            
                                validacion=false;
                                for (var i = 0; i < rowCount; i++) {
                                    if( tablasientos.cell( i,1 ).data()==datos[0].key_account){
                                        //<input type="text"  value="'+datos[0].code+'" style="width:100%;pading-top:-50px"  class="custom">
                                    validacion=true;
                                    }
                                }
                                if(validacion==false){
                                    tablasientos.row.add([
                                        '<button id="delete"  type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>',
                                        datos[0].key_account,
                                        datos[0].code_account,
                                        '<input type="text" style="width:100%;pading-top:-50px"  class="custom" value="'+datos[0].description+'">',
                                        '<input type="text" name="debe" value="0" onchange="Decimal(this)" style="width:100%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                        "-"+'<input type="text" name="haber" value="0" onchange="Decimal(this)" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                        '<input type="text" style="width:100%;pading-top:-50px"  class="custom">',
                                    ]).draw( false );
                                }
                            }
                                $("#codigo_cuenta").val("");
                                
                                $('#loader1').modal('hide');
                                $('#createAsiento').modal('show');
                            
                        }).fail(function() {
                            
                            $('#loader1').modal('hide');
                            $('#createAsiento').modal('show');
                        });
                        
                    }
                }

        $('#tablasientos').on('change', '[name="debe"]', function () {
            calculonuevo();
        });   
        $('#tablasientos').on('change', '[name="haber"]', function () {
            calculonuevo();
        });
                function checkDec(el){
 var ex = /^[0-9]+\.?[0-9]*$/;
 if(ex.test(el.value)==false){
   el.value = el.value.substring(0,el.value.length - 1);

  }
}

function Decimal(el) {
    var v = parseFloat(el.value);
    el.value = (isNaN(v)) ? '0.00' : v.toFixed(2);
}

var total = 0;
function guardarA() {
    
    if( $("#code_voucher").val()== "" && $("#date_voucher").val()== "" && $("#header_description").val()== ""){
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese datos en la cabecera",
                        position: 'topRight'
        });
    }else if($("#code_voucher").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese Código Comprobante",
                        position: 'topRight'
        });
    }else if($("#date_voucher").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese Fecha asiento",
                        position: 'topRight'
        });

    }else{

    

        
        var flag = "Y";   
            
        calculonuevo(); 
        if(tablasientos.rows().count() < 2){
            iziToast.warning({
                title: 'Transporte',
                message: "Debe ingresar minimo dos cuentas contables",
                position: 'topRight'
            });
            flag = "N";
        
        }else if(tablasientos.rows().count()>=2){
                    if(total > 0){
                        iziToast.warning({
                            title: 'Transporte',
                            message: "La suma entre el debe y haber no puede ser mayor a 0 Total= "+total,
                            position: 'topRight'
                        });
                        flag = "N";
                    
                    }else if(total < 0 ){
                        iziToast.warning({
                            title: 'Transporte',
                            message: "La suma entre el debe y haber no puede ser menor a 0 Total= "+total,
                            position: 'topRight'
                        });
                        flag = "N";
                    
                    }
        }
        var detalle = [];
        
        if(flag == "Y"){
            $('#createAsiento').modal('hide');
            
            $('#tablasientos tbody tr').each(function( index) {

                detalle.push({
                    "key_account":             tablasientos.row(index).data()[1],
                    "code_account"  :             tablasientos.row(index).data()[2],
                    "descripcionAsiento" :             tablasientos.cell(index,3).nodes().to$().find('input').val(),
                    "debe" :       tablasientos.cell(index,4).nodes().to$().find('input').val(),
                    "haber" :       tablasientos.cell(index,5).nodes().to$().find('input').val(),
                    "referencia" :       tablasientos.cell(index,6).nodes().to$().find('input').val(),
                });
            });
            $('#loader1').modal('show');
            $.get('{!! route('account.saveseat') !!}',{
                    detail:detalle,
                    code_voucher:$("#code_voucher").val(),
                    date_voucher:$("#date_voucher").val(),
                    number_voucher:$("#number_voucher").val(),
                    descripcionA:$("#header_description").val(),
                },function(data) {
                    if(data !="NO"){
                        iziToast.success({
                            title: 'Transporte',
                            message: "Asiento Contable Creado Correctamente #Comprobante: "+data,
                            position: 'topRight'
                        });
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 3000);
                    }else{
                        $('#loader1').modal('hide');
                        iziToast.error({
                            title: 'Transporte',
                            message: "Error al crear asiento contable",
                            position: 'topRight'
                        });
                        $('#createAsiento').modal('show');
                    }
                    
                
                }).fail(function() {
                    $('#loader1').modal('hide');
                    iziToast.error({
                            title: 'Transporte',
                            message: "Error al crear asiento contable",
                            position: 'topRight'
                        });
                        $('#createAsiento').modal('show');
            });
        }
    }
}

function actualizarA() {
    
    if( $("#code_voucher").val()== "" && $("#date_voucher").val()== "" && $("#header_description").val()== ""){
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese datos en la cabecera",
                        position: 'topRight'
        });
    }else if($("#code_voucher").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese Código Comprobante",
                        position: 'topRight'
        });
    }else if($("#date_voucher").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese Fecha asiento",
                        position: 'topRight'
        });

    }else{

    

        
        var flag = "Y";   
            
        calculonuevo(); 
        if(tablasientos.rows().count() < 2){
            iziToast.warning({
                title: 'Transporte',
                message: "Debe ingresar minimo dos cuentas contables",
                position: 'topRight'
            });
            flag = "N";
        
        }else if(tablasientos.rows().count()>=2){
                    if(total > 0){
                        iziToast.warning({
                            title: 'Transporte',
                            message: "La suma entre el debe y haber no puede ser mayor a 0 Total= "+total,
                            position: 'topRight'
                        });
                        flag = "N";
                    
                    }else if(total < 0 ){
                        iziToast.warning({
                            title: 'Transporte',
                            message: "La suma entre el debe y haber no puede ser menor a 0 Total= "+total,
                            position: 'topRight'
                        });
                        flag = "N";
                    
                    }
        }
        var detalle = [];
        
        if(flag == "Y"){
            $('#createAsiento').modal('hide');
            
            $('#tablasientos tbody tr').each(function( index) {

                detalle.push({
                    "key_account":             tablasientos.row(index).data()[1],
                    "code_account"  :             tablasientos.row(index).data()[2],
                    "descripcionAsiento" :             tablasientos.cell(index,3).nodes().to$().find('input').val(),
                    "debe" :       tablasientos.cell(index,4).nodes().to$().find('input').val(),
                    "haber" :       tablasientos.cell(index,5).nodes().to$().find('input').val(),
                    "referencia" :       tablasientos.cell(index,6).nodes().to$().find('input').val(),
                });
            });
            $('#loader1').modal('show');
            $.get('{!! route('account.updateseat') !!}',{
                    detail:detalle,
                    code_voucher:$("#code_voucher").val(),
                    date_voucher:$("#date_voucher").val(),
                    number_voucher:$("#number_voucher").val(),
                    descripcionA:$("#header_description").val(),
                    id_header:$("#account_id").val(),
                },function(data) {
                    if(data !="NO"){
                        iziToast.success({
                            title: 'Transporte',
                            message: "Asiento Contable Actualizado Correctamente #Comprobante: "+data,
                            position: 'topRight'
                        });
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 3000);
                    }else{
                        $('#loader1').modal('hide');
                        iziToast.error({
                            title: 'Transporte',
                            message: "Error al crear asiento contable",
                            position: 'topRight'
                        });
                        $('#createAsiento').modal('show');
                    }
                    
                
                }).fail(function() {
                    $('#loader1').modal('hide');
                    iziToast.error({
                            title: 'Transporte',
                            message: "Error al crear asiento contable",
                            position: 'topRight'
                        });
                        $('#createAsiento').modal('show');
            });
        }
    }
}
function EliminarAsiento(id) {
        Swal.fire({
            title: "Seguro que deseas eliminar este Asiento?",
            text: "Esta acción ya no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'Cancelar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#loader1').modal('show');
                $.get('{!! route('account.deleteseat') !!}'+'?id='+id, function( deleteData ) {
                   if(deleteData == "OK"){
                       iziToast.success({
                               title: 'Transporte',
                               message: "Asiento Eliminado Correctamente",
                               position: 'topRight'
                       });
                       setTimeout(function(){
                            window.location.reload(1);
                        }, 3000);
                   }else{
                        $('#loader1').modal('hide');
                        iziToast.error({
                               title: 'Transporte',
                               message: "Error al Eliminar Asiento",
                               position: 'topRight'
                        });
                   }
                       
               }).fail(function() {
                    $('#loader1').modal('hide');
                    iziToast.error({
                        title: 'Transporte',
                        message: "Error al Eliminar Asiento",
                        position: 'topRight'
                    }); 
               });
            }
        });
                
    } 

    function aprobarAsiento(id) {
        
        $('#loader1').modal('show');
        $.get('{!! route('account.aprobarseat') !!}'+'?id='+id, function( aprobado ) {
            if(aprobado == "OK"){
                iziToast.success({
                    title: 'Transporte',
                    message: "Asiento Arobado Correctamente",
                    position: 'topRight'
                });
                setTimeout(function(){
                    window.location.reload(1);
                }, 3000);
            }else{
                $('#loader1').modal('hide');
                iziToast.success({
                    title: 'Transporte',
                    message: "Esta Asiento se encuentra Aprobado",
                    position: 'topRight'
                });
            }
                       
        }).fail(function() {
            $('#loader1').modal('hide');
            iziToast.error({
                title: 'Transporte',
                message: "Error al Aprobar Asiento",
                position: 'topRight'
            }); 
        });
                
    } 
    </script>
@endsection