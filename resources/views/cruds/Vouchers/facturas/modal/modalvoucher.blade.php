<div wire:ignore.self class="modal fade" id="createFacturas" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createFacturasLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80%;" role="document" id="modalCreacion">
        <div class="modal-content" >
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Factura</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Factura</h5>
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
                                                <label>Cta. Corriente</label>
                                                <select  wire:model.defer="id_bank" class="form-control @error('id_bank') is-invalid @enderror" id="id_bank">
                                                    <?php foreach($bancos as $bank): ?>                
                                                        <option value="<?php echo $bank->id ?>"><?php echo $bank->description ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                    <input type="hidden" wire:model.defer="account_id" id="account_id" class="form-control @error('account_id') is-invalid @enderror" >
                                                    <input type="hidden" wire:model.defer="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                                    @error('id_bank')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Fecha</label>
                                                <input type="date" wire:model.defer="date_registre" id="date_registre" class="form-control @error('date_registre') is-invalid @enderror">
                                                @error('date_registre')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label for="email" class="control-label">identifiaci??n Proveedor</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" wire:model.defer="name_proveedor" class="form-control @error('name_proveedor') is-invalid @enderror" id="name_proveedor">
                                                        <input class="form-control"  wire:model.defer="id_proveedor" name="id_proveedor" type="hidden" id="id_proveedor" onfocusout="">
                                                        <span class="input-group-btn ">
                                                            <button type="button" class="btn btn-info form-control" onclick="buscarProveedor();"><i class="fa fa-fw fa-search"></i></button>
                                                        </span>
                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Tipo Documento</label>
                                                <select  wire:model.defer="type_document" class="form-control @error('type_document') is-invalid @enderror" id="type_document">
                                                    <option value="" >Elige un Tipo Documento</option>
                                                    <option value="F" >FACTURA</option>
                                                    <option value="C" >CHEQUE</option>
                                                </select>
                                                @error('type_document')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Numero Documento</label>
                                                <input type="number" wire:model.defer="number_check" class="form-control @error('number_check') is-invalid @enderror" id="number_check" placeholder="Numero Chque">
                                                @error('number_check')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Fecha Documento</label>
                                                <input type="date" wire:model.defer="date_check" id="date_check" class="form-control @error('date_check') is-invalid @enderror" id="date_check">
                                                @error('date_check')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Beneficiario</label>
                                                <input type="text" wire:model.defer="beneficiario" class="form-control @error('beneficiario') is-invalid @enderror" id="beneficiario" readonly>
                                                @error('number_check')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Valor</label>
                                                <input type="number" wire:model.defer="total_value" class="form-control @error('total_value') is-invalid @enderror" placeholder="0.00" id="total_value">
                                                @error('total_value')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Numero Cheque</label>
                                                <input type="number" wire:model.defer="number_check_voucher" class="form-control @error('number_check_voucher') is-invalid @enderror"  id="number_check_voucher">
                                                @error('number_check_voucher')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Numero Autorizaci??n Documento</label>
                                                <input type="text" wire:model.defer="number_autorization" class="form-control @error('number_autorization') is-invalid @enderror" id="number_autorization">
                                                @error('number_autorization')
                                                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12 form-group">
                                                <label>Detealle</label>
                                                <input type="text" wire:model.defer="detail_voucher" class="form-control @error('detail_voucher') is-invalid @enderror" id="detail_voucher" placeholder="Descripcion Asiento">
                                                @error('detail_voucher')
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
                                                <table class="table table-striped" id="tablasientos">
                                                    <thead style='font-size:15px'>
                                                        <tr>
                                                        <th style='font-size:15px'>Acci??n</th>
                                                        <th style='font-size:15px'>Clave</th>
                                                        <th style='font-size:15px'>N??mero cuenta</th>
                                                        <th style='font-size:15px'>Nombre</th>
                                                        <th style='font-size:15px'>D??bito</th>
                                                        <th style='font-size:15px'>Cr??dito</th>
                                                        <th style='font-size:15px'>Referencia</th>
                                                        <th style='font-size:15px; display:none;'>id</th>
                                                        <th style='font-size:15px; display:none;'>voucher</th>
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
                                    <button id="actualizar" onclick="actualizarA();" class="btn btn-warning" style="display: none;">Actualizar Factura</button>
                                    @if ($editMode)
                                    @else
                                        @if ($createMode) disabled @endif
                                        <button id="crear" onclick="guardarA();" class="btn btn-primary">Crear Factura</button> 
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
                    <thead >
                        <tr>
                            <th class="px-4 py-2 text-center">Clave Cuenta </th>
                            <th class="px-4 py-2 text-center">Numero Cuenta </th>
                        </tr>
                    </thead>

                </table>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProveedores" >
    <div class="modal-dialog" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lista de Socios</h5>
            </div>
            <div class="modal-body">
                <table class="table table-striped  datatable dt-select" id="tablaproveedor">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center">identificacion </th>
                            <th class="px-4 py-2 text-center">Nombre</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger " data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<style>
    .acction { transition: all .2s ease-in-out; }
    .acction:hover { transform: scale(1.4);
    cursor:pointer;}
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
var api = "";


  
        $("#tablasientos").on('click', '#delete', function () {
       
            var t = $('#tablasientos').DataTable();
            let $tr = $(this).parent().parent();
            t.row($tr).remove().draw(false);
                calculonuevo();      
        });
        var footerTabla = "";
        function buscarDetalle(id) {
            
            $('#actualizar').show();
            $('#crear').hide();
            $('#createFacturas').modal('show');
            tablasientos.clear().draw();
                $.get('{!! route('vouchers.buscardetalle') !!}'+'?id='+id, function( datos ) {
                    $("#id_bank").val(datos[0].banco);
                    $("#date_registre").val(datos[0].fecha);
                    $("#number_check").val(datos[0].numeroDocumento);
                    $("#detail_voucher").val(datos[0].detalle);
                    $("#id_proveedor").val(datos[0].idProveedor);
                    $("#date_check").val(datos[0].fechaDocumento);
                    $("#total_value").val(datos[0].valor);
                    $("#account_id").val(id);
                    $("#name_proveedor").val(datos[0].identificacion);
                    $("#beneficiario").val(datos[0].beneficiario);
                    $("#type_document").val(datos[0].tipoDocumento);
                    $("#number_check_voucher").val(datos[0].cheque_factura);
                    $("#number_autorization").val(datos[0].autorizacion);
                    for (var i = 0; i < datos.length; i++) {
                        if(datos[0].estado == "BORRADOR"){
                            if( datos[0].valor_retener != "N"){
                                tablasientos.row.add([
                                    '<button id="delete"  type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>',
                                    datos[i].key_account,
                                    datos[i].code_account,
                                    datos[i].description,
                                    '<input type="text" name="debe" value="'+datos[i].value_debito+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                    "-"+'<input type="text" name="haber" value="'+parseFloat(datos[i].value_credito*-1).toFixed(2)+'" onchange="Decimal(this)" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                    '<input type="text" style="width:100%;pading-top:-50px"  class="custom" value="'+datos[i].reference_voucher+'">',
                                    datos[i].valor_retener,
                                    datos[i].numerodeuda,
                                ]).draw( false );
                            }else{
                                tablasientos.row.add([
                                    '<button id="delete"  type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>',
                                    datos[i].key_account,
                                    datos[i].code_account,
                                    datos[i].description,
                                    '<input type="text" name="debe" value="'+datos[i].value_debito+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                    "-"+'<input type="text" name="haber" value="'+parseFloat(datos[i].value_credito*-1).toFixed(2)+'" onchange="Decimal(this)" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                    '<input type="text" style="width:100%;pading-top:-50px"  class="custom" value="'+datos[i].reference_voucher+'">',
                                    "N",
                                    datos[i].numerodeuda,
                                ]).draw( false );
                            }
                            
                            footerTabla = "1";
                        }else{
                            $('#actualizar').hide();
                            footerTabla = "2";
                            tablasientos.row.add([
                                '',
                                datos[i].key_account,
                                datos[i].code_account,
                                datos[i].description,
                                datos[i].value_debito,
                                datos[i].value_credito,
                               datos[i].reference_voucher,
                               "N",
                               0,
                            ]).draw( false );
                        }
                    }
                    calculonuevo();  
                }).fail(function() {
                    iziToast.error({
                        title: 'Transporte',
                        message: "Error al buscar detalle de factura",
                        position: 'topRight'
                    });
                   
                });
                //calculonuevo();
        } 

        
        function buscarProveedor() {
                
            $.get('{!! route('vouchers.socios') !!}'+'?identification='+$("#name_proveedor").val(), function( datosproveedor ) {
                if(datosproveedor == "" || datosproveedor == null){
                    iziToast.warning({
                            title: 'Transporte',
                            message: "No se encontro el socio con la identifaci??n "+$("#name_proveedor").val(),
                            position: 'topRight'
                    });
                }else{
                    $("#id_proveedor").val(datosproveedor[0].id);
                    $("#beneficiario").val(datosproveedor[0].name_partner);
                    CuentasProveedor();
                }
                    
            }).fail(function() {

            });
        } 
        $('#tablasientos').on('change', '[name="debe"]', function () {
            calculonuevo();
            $('#tablasientos tbody tr').each(function( index) {
                    if(tablasientos.row(index).data()[7] != "N"){
                        var pageParamTable = $('#tablasientos').DataTable();  
                        var tableRow = pageParamTable.row($(this).parents('tr'));
                        indexa = $(this).closest('tr').index();
                        var table = $("#tablasientos").DataTable();
                        var result = pageParamTable.row($(this).parents('tr')).data();
                        var tableRow = table.row($(this).parents("tr"));
                        $("#tablasientos tr").each(function() {
                            $(this).find("td:eq(1)").each(function() {
                                var rowIdx = table.cell(this).index().row;
                                if (rowIdx==indexa) {
                                    var nuevoValor = parseFloat(tablasientos.row(rowIdx).data()[7]).toFixed(2);
                                    var porcentaje = nuevoValor/100;
                                    var valorRetenido = parseFloat(valorRetener*porcentaje).toFixed(2);
                                    table.cell( rowIdx,5).data(["-"+'<input type="text" name="haber" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);" value="'+valorRetenido+'">']);
                                }
                            });
                        });
                    }
            });
            
        });
        $('#tablasientos').on('change', '[name="haber"]', function () {
            calculonuevo();
        });
var valorRetener=0;
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
                    valorRetener = 0;
                    column = tablasientos.column( 4 );
                    $( column.footer() ).html("$0.00");
                    column = tablasientos.column( 5 );
                    $( column.footer() ).html("$0.00");
                    column = tablasientos.column( 6 );
                    $( column.footer() ).html("$0.00");
                }else{
                    valorRetener = parseFloat(debe).toFixed(2);
                    column = tablasientos.column( 4 );
                    $( column.footer() ).html("$"+parseFloat(debe).toFixed(2));
                    column = tablasientos.column( 5 );
                    $( column.footer() ).html("$"+parseFloat(haber).toFixed(2));
                    column = tablasientos.column( 6 );
                    $( column.footer() ).html("$"+parseFloat(total).toFixed(2));
                }
                
                
}
       
                function buscarCuenta() {
                    if(tablasientos.rows().count() > 1){
                        calculonuevo();
                    }
                    if($("#codigo_cuenta").val()==""){
                        iziToast.error({
                            title: 'Transporte',
                            message: "Ingrese una clave o c??digo de cuenta",
                            position: 'topRight'
                        });
                    }else{
                        //$('#createFacturas').modal('hide');
                   
                        
                        //$('#loader1').modal('show');
                        $.get('{!! route('vouchers.listacuentas') !!}'+'?code='+$("#codigo_cuenta").val(), function( datos ) {
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
                                    if(datos[0].valor_retener == "N"){

                                        if(datos[0].valor_normal != "N"){
                                            tablasientos.row.add([
                                                '<button id="delete"  type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>',
                                                datos[0].key_account,
                                                datos[0].code_account,
                                                datos[0].description,
                                                '<input type="text" name="debe" value="0" onchange="Decimal(this)" style="width:100%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                                "-"+'<input type="text" name="haber" value="'+datos[0].valor_normal+'" onchange="Decimal(this)" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                                '<input type="text" style="width:100%;pading-top:-50px"  class="custom">',
                                                "N",
                                                datos[0].numerodeuda,
                                            ]).draw( false );
                                        }else{
                                            tablasientos.row.add([
                                                '<button id="delete"  type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>',
                                                datos[0].key_account,
                                                datos[0].code_account,
                                                datos[0].description,
                                                '<input type="text" name="debe" value="0" onchange="Decimal(this)" style="width:100%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                                "-"+'<input type="text" name="haber" value="0" onchange="Decimal(this)" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                                '<input type="text" style="width:100%;pading-top:-50px"  class="custom">',
                                                "N",
                                                datos[0].numerodeuda,
                                            ]).draw( false );
                                        }
                                        
                                    }else{
                                        if(valorRetener > 0){
                                            var porcentaje = datos[0].valor_retener/100;
                                            var valorRetenido = parseFloat(valorRetener*porcentaje).toFixed(2)
                                            tablasientos.row.add([
                                                '<button id="delete"  type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>',
                                                datos[0].key_account,
                                                datos[0].code_account,
                                                datos[0].description,
                                                '<input type="text" name="debe" value="0" onchange="Decimal(this)" style="width:100%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                                "-"+'<input type="text" name="haber" value="'+valorRetenido+'" onchange="Decimal(this)" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                                '<input type="text" style="width:100%;pading-top:-50px"  class="custom">',
                                                datos[0].valor_retener,
                                                datos[0].numerodeuda,
                                            ]).draw( false );
                                        }else{
                                            tablasientos.row.add([
                                                '<button id="delete"  type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>',
                                                datos[0].key_account,
                                                datos[0].code_account,
                                                datos[0].description,
                                                '<input type="text" name="debe" value="0" onchange="Decimal(this)" style="width:100%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                                "-"+'<input type="text" name="haber" value="0" onchange="Decimal(this)" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                                                '<input type="text" style="width:100%;pading-top:-50px"  class="custom">',
                                                "N",
                                                datos[0].numerodeuda,
                                            ]).draw( false );
                                        }
                                    }
                                    
                                }
                            }
                                $("#codigo_cuenta").val("");
                                
                                //$('#loader1').modal('hide');
                                //$('#createFacturas').modal('show');
                            
                        }).fail(function() {
                            
                            //$('#loader1').modal('hide');
                            //$('#createFacturas').modal('show');
                        });
                        
                    }
                }   

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
            
         "deferRender": true,  destroy: true,searching: false,bPaginate: false, autoWidth: true,responsive: true,"ordering": false,
         "aoColumnDefs":[
        { "bVisible": false, "aTargets": [7,8] },
        { "width": "60px", "targets": [0,4,5]},
           { "width": "50px", "targets": 1},
           { "width": "75px", "targets": 2},
            { "width": "500px", "targets": 3},
            { "width": "80px", "targets": 6},
        ]
,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        });;
function mostrarBoton() {
    
     
    $('#actualizar').hide();
    $('#crear').show();
    tablasientos.clear().draw();
    $("#id_bank").val(1);
    $("#date_registre").val("");
    $("#number_check").val("");
    $("#detail_voucher").val("");
    $("#id_proveedor").val("");
    $("#date_check").val("");
    $("#total_value").val("");
    $("#account_id").val("");
    $("#name_proveedor").val("");
    $("#beneficiario").val("");
    $("#type_document").val("");
    footerTabla = "1";
   
}

var total = 0;
function guardarA() {
    
    if( $("#code_account").val()== "" && $("#date_registre").val()== "" && $("#number_check").val()== ""  && $("#date_check").val()== "" && $("#total_value").val()== "" && $("#id_proveedor").val()== "" && $("#type_document").val()== ""){
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese datos en la cabecera",
                        position: 'topRight'
        });
    }else if($("#code_account").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese C??digo Comprobante",
                        position: 'topRight'
        });
    }else if($("#date_registre").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese Fecha Registro",
                        position: 'topRight'
        });
    }else if($("#id_proveedor").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese un Socio",
                        position: 'topRight'
        });
    }else if($("#number_check").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese un numero documento",
                        position: 'topRight'
        });
    }else if($("#date_check").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese un la fecha documento",
                        position: 'topRight'
        });
    }else if($("#total_value").val()== ""){     
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese el total del documento",
                        position: 'topRight'
        });
    }else if($("#type_document").val()== ""){     
        iziToast.warning({
                        title: 'Transporte',
                        message: "Seleccione un tipo de documento",
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
            $('#createFacturas').modal('hide');
            
            $('#tablasientos tbody tr').each(function( index) {

                detalle.push({
                    "key_account":             tablasientos.row(index).data()[1],
                    "code_account"  :             tablasientos.row(index).data()[2],
                    "debe" :       tablasientos.cell(index,4).nodes().to$().find('input').val(),
                    "haber" :       tablasientos.cell(index,5).nodes().to$().find('input').val(),
                    "referencia" :       tablasientos.cell(index,6).nodes().to$().find('input').val(),
                    "voucher_deuda" :       tablasientos.row(index).data()[8],
                });
            });
            $('#loader1').modal('show');
            $.get('{!! route('vouchers.savesvoucher') !!}',{
                    detail:detalle,
                    code_account:$("#id_bank").val(),
                    date_registre:$("#date_registre").val(),
                    number_check:$("#number_check").val(),
                    header_description:$("#detail_voucher").val(),
                    id_proveedor:$("#id_proveedor").val(),
                    date_check:$("#date_check").val(),
                    total_value:$("#total_value").val(),
                    tipo_documento:$("#type_document").val(),
                    number_cheque:$("#number_check_voucher").val(),
                    number_autorization:$("#number_autorization").val(),
                },function(data) {
                    if(data !="NO"){
                        iziToast.success({
                            title: 'Transporte',
                            message: "Factura Creada Correctamente #Comprobante: "+data,
                            position: 'topRight'
                        });
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 3000);
                    }else{
                        $('#loader1').modal('hide');
                        iziToast.error({
                            title: 'Transporte',
                            message: "Error al crear Factura",
                            position: 'topRight'
                        });
                        $('#createFacturas').modal('show');
                    }
                    
                
                }).fail(function() {
                    $('#loader1').modal('hide');
                    iziToast.error({
                            title: 'Transporte',
                            message: "Error al crear Factura",
                            position: 'topRight'
                        });
                        $('#createFacturas').modal('show');
            });
        }
    }
}

function actualizarA() {
    
    if( $("#code_account").val()== "" && $("#date_registre").val()== "" && $("#number_check").val()== ""  && $("#date_check").val()== "" && $("#total_value").val()== "" && $("#id_proveedor").val()== "" && $("#type_document").val()== ""){
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese datos en la cabecera",
                        position: 'topRight'
        });
    }else if($("#code_account").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese C??digo Comprobante",
                        position: 'topRight'
        });
    }else if($("#date_registre").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese Fecha Registro",
                        position: 'topRight'
        });
    }else if($("#id_proveedor").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese un Socio",
                        position: 'topRight'
        });
    }else if($("#number_check").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese un numero documento",
                        position: 'topRight'
        });
    }else if($("#date_check").val()== ""){    
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese un la fecha documento",
                        position: 'topRight'
        });
    }else if($("#total_value").val()== ""){     
        iziToast.warning({
                        title: 'Transporte',
                        message: "Ingrese el total del documento",
                        position: 'topRight'
        });
    }else if($("#type_document").val()== ""){     
        iziToast.warning({
                        title: 'Transporte',
                        message: "Seleccione un tipo de documento",
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
            $('#createFacturas').modal('hide');
            
            $('#tablasientos tbody tr').each(function( index) {

                detalle.push({
                    "key_account":             tablasientos.row(index).data()[1],
                    "code_account"  :             tablasientos.row(index).data()[2],
                    "descripcionAsiento" :             tablasientos.row(index).data()[3],
                    "debe" :       tablasientos.cell(index,4).nodes().to$().find('input').val(),
                    "haber" :       tablasientos.cell(index,5).nodes().to$().find('input').val(),
                    "referencia" :       tablasientos.cell(index,6).nodes().to$().find('input').val(),
                    "voucher_deuda" :       tablasientos.row(index).data()[8],
                });
            });
            $('#loader1').modal('show');
            $.get('{!! route('vouchers.updatevoucher') !!}',{
                    code_account:$("#id_bank").val(),
                    date_registre:$("#date_registre").val(),
                    number_check:$("#number_check").val(),
                    header_description:$("#detail_voucher").val(),
                    id_proveedor:$("#id_proveedor").val(),
                    date_check:$("#date_check").val(),
                    total_value:$("#total_value").val(),
                    id_vheader:$("#account_id").val(),
                    tipo_documento:$("#type_document").val(),
                    number_cheque:$("#number_check_voucher").val(),
                    number_autorization:$("#number_autorization").val(),
                    detail:detalle,
                },function(data) {
                    if(data !="NO"){
                        iziToast.success({
                            title: 'Transporte',
                            message: "Factura Actualizado Correctamente #Comprobante: "+data,
                            position: 'topRight'
                        });
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 3000);
                    }else{
                        $('#loader1').modal('hide');
                        iziToast.error({
                            title: 'Transporte',
                            message: "Error al actualizar Factura",
                            position: 'topRight'
                        });
                        $('#createFacturas').modal('show');
                    }
                    
                
                }).fail(function() {
                    $('#loader1').modal('hide');
                    iziToast.error({
                            title: 'Transporte',
                            message: "Error al actualizar Factura",
                            position: 'topRight'
                        });
                        $('#createFacturas').modal('show');
            });
        }
    }
}

function mensaje(){
    iziToast.success({
        title: 'Transporte',
        message: "Descargando Excel Espere...",
        position: 'topRight'
    });
}

function mensajepdf(){
    iziToast.success({
        title: 'Transporte',
        message: "Descargando PDF Espere...",
        position: 'topRight'
    });
}

    function CuentasProveedor() {
        
        tablasientos.clear().draw();
        $.get('{!! route('vouchers.autoaccount') !!}'+'?code='+$("#id_proveedor").val(), function( cuentas ) {
            var rowCount =document.getElementById("tablasientos").rows.length;
            if(cuentas == "ERROR"){
                iziToast.error({
                    title: 'Transporte',
                    message: "Error al cargar cuentas del proveedor "+$("#beneficiario").val(),
                    position: 'topRight'
                });
            }else{
                for (var i = 0; i < cuentas.length; i++) {
                    if(cuentas[i].tipo_valor == "V"){
                        tablasientos.row.add([
                            '<button id="delete"  type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>',
                            cuentas[i].key,
                            cuentas[i].codigo,
                            cuentas[i].descripcion,
                            '<input type="text" name="debe" value="'+cuentas[i].valor_debito+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                            "-"+'<input type="text" name="haber" value="'+cuentas[i].valor_credito+'" onchange="Decimal(this)" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                            '<input type="text" style="width:100%;pading-top:-50px"  class="custom">',
                            "N",
                            cuentas[i].numerodeuda,
                        ]).draw( false );
                    }else{
                        tablasientos.row.add([
                            '<button id="delete"  type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>',
                            cuentas[i].key,
                            cuentas[i].codigo,
                            cuentas[i].descripcion,
                            '<input type="text" name="debe" value="'+cuentas[i].valor_debito+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                            "-"+'<input type="text" name="haber" value="'+cuentas[i].valor_credito+'" onchange="Decimal(this)" style="width:70%;pading-top:-50px" class="custom" onkeyup="checkDec(this);">',
                            '<input type="text" style="width:100%;pading-top:-50px"  class="custom">',
                            cuentas[i].valor_porcentaje,
                            cuentas[i].numerodeuda,
                        ]).draw( false );
                    }
                    
                }
                calculonuevo();
            }                            
        }).fail(function() {
                            
        });
                        
    }

    function EliminarFactura(id) {
        Swal.fire({
            title: "Seguro que deseas eliminar este Documento?",
            text: "Esta acci??n ya no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'Cancelar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#loader1').modal('show');
                $.get('{!! route('vouchers.deletefact') !!}'+'?id='+id, function( deleteData ) {
                   if(deleteData == "OK"){
                       iziToast.success({
                               title: 'Transporte',
                               message: "Factura Eliminado Correctamente",
                               position: 'topRight'
                       });
                       setTimeout(function(){
                            window.location.reload(1);
                        }, 3000);
                   }else{
                        $('#loader1').modal('hide');
                        iziToast.error({
                               title: 'Transporte',
                               message: "Error al Eliminar Factura",
                               position: 'topRight'
                        });
                   }
                       
               }).fail(function() {
                    $('#loader1').modal('hide');
                    iziToast.error({
                        title: 'Transporte',
                        message: "Error al Eliminar Factura",
                        position: 'topRight'
                    }); 
               });
            }
        });
                
    } 

    function aprobarFactura(id) {
        
        $('#loader1').modal('show');
        $.get('{!! route('vouchers.aprobarfact') !!}'+'?id='+id, function( aprobado ) {
            if(aprobado == "OK"){
                iziToast.success({
                    title: 'Transporte',
                    message: "Factura Arobada Correctamente",
                    position: 'topRight'
                });
                setTimeout(function(){
                    window.location.reload(1);
                }, 3000);
            }else{
                $('#loader1').modal('hide');
                iziToast.success({
                    title: 'Transporte',
                    message: "Esta Factura se encuentra Aprobada",
                    position: 'topRight'
                });
            }
                       
        }).fail(function() {
            $('#loader1').modal('hide');
            iziToast.error({
                title: 'Transporte',
                message: "Error al Aprobar Factura",
                position: 'topRight'
            }); 
        });
                
    } 
    </script>
@endsection