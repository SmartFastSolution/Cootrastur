<div wire:ignore.self class="modal fade" id="estadoCuenta" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="estadoCuentaLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80%;" role="document" id="modalCreacion">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Estado de Cuenta</h5>
            </div>
                <div class="modal-body">
                    <section class="section">
                        <div class="section-body">
                            <div class="card">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="home-tab2" data-toggle="tab" href="#datos" role="tab"aria-selected="true">Datos Personales</a></li>
                                    <li class="nav-item"><a class="nav-link" id="pagos-tab2" data-toggle="tab" href="#pagos"role="tab" aria-selected="false">Pagos</a></li>
                                    <li class="nav-item"><a class="nav-link" id="cobros-tab2" data-toggle="tab" href="#cobros"role="tab" aria-selected="false">Cobros</a></li>
                                    <li class="nav-item"><a class="nav-link" id="deudas-tab2" data-toggle="tab" href="#deudas"role="tab" aria-selected="false">deudas</a></li>
                                </ul>
                                <div class="tab-content tab-bordered" id="myTab3Content">
                                    <div class="tab-pane fade show active" id="datos" role="tabpanel"aria-labelledby="home-tab2">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Nombres Socio</label>
                                                <input type="text" style="background-color: white" id="name_partner" class="form-control" readonly >
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Fecha Nacimiento</label>
                                                <input type="date" style="background-color: white" id="date_registre" class="form-control" readonly>
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label for="email" class="control-label">identifiación Proveedor</label>
                                                <input class="form-control" style="background-color: white" name="identification" type="text" id="identification" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Placa Vehiculo</label>
                                                <input class="form-control" style="background-color: white" name="placa" type="text" id="placa" readonly>
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Correo Electronico</label>
                                                <input type="text" style="background-color: white" class="form-control" id="mail" readonly>
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Direccion</label>
                                                <input type="text" style="background-color: white" class="form-control" id="address" readonly>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Código</label>
                                                <input class="form-control" style="background-color: white" name="code" type="text" id="code" readonly>
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>Telefono</label>
                                                <input type="text" style="background-color: white" class="form-control" id="phone1" readonly>
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label>telefono</label>
                                                <input type="text" style="background-color: white" class="form-control" id="phone2" readonly>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pagos" role="tabpanel"aria-labelledby="pagos-tab2">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 form-group">
                                                <label for="email" class="control-label">Fecha Inicio</label>
                                                <input type="date" style="background-color: white" id="date_ini" class="form-control">
                                            </div>
                                            <div class="col-xs-12 col-md-5 form-group">
                                                <label for="email" class="control-label">Fecha Fin</label>
                                                
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="date" style="background-color: white" id="date_fin" class="form-control">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="input-group-btn ">
                                                            <button type="button" class="btn btn-info form-control" onclick="buscarEstado();"><i class="fa fa-fw fa-search"></i></button>
                                                        </span>
                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-2 form-group">
                                                
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-12 form-group">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="tablapagos">
                                                    <thead style='font-size:15px'>
                                                        <tr>
                                                            <th style='font-size:15px'>Fecha</th>
                                                            <th style='font-size:15px'>Cuenta Paga</th>
                                                            <th style='font-size:15px'>Comprobante</th>
                                                            <th style='font-size:15px'>total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> 
                                        
                                    </div>
                                    <div class="tab-pane fade" id="cobros" role="tabpanel"aria-labelledby="cobros-tab2">
                                        <div class="col-xs-12 col-md-12 form-group">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="tablasientos">
                                                    <thead style='font-size:15px'>
                                                        <tr>
                                                            <th style='font-size:15px'>Fecha Comprobante</th>
                                                            <th style='font-size:15px'>Comprobante</th>
                                                            <th style='font-size:15px'>Cuota Admist.</th>
                                                            <th style='font-size:15px'>Certifica Aport.</th>
                                                            <th style='font-size:15px'>Dolar Social</th>
                                                            <th style='font-size:15px'>Unión Coope.</th>
                                                            <th style='font-size:15px'>Ahorro CXC</th>
                                                            <th style='font-size:15px'>Varias CTA.</th>
                                                            <th style='font-size:15px'>Multa</th>
                                                            <th style='font-size:15px'>Gestion Cobranz</th>
                                                            <th style='font-size:15px'>Fondo Ayuda</th>
                                                            <th style='font-size:15px'>Cuota Ingreso</th>
                                                            <th style='font-size:15px'>Prestamo</th>
                                                            <th style='font-size:15px'>Anticipo</th>
                                                            <th style='font-size:15px'>Punto Emi.</th>
                                                            <th style='font-size:15px'>Total Comprobante</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> 
                                        
                                    </div>
                                    <div class="tab-pane fade" id="deudas" role="tabpanel"aria-labelledby="deudas-tab2">
                                        <div class="col-xs-12 col-md-12 form-group">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="tabladeudas">
                                                    <thead style='font-size:15px'>
                                                        <tr>
                                                            <th style='font-size:15px'>Fecha Comprobante</th>
                                                            <th style='font-size:15px'>Comprobante</th>
                                                            <th style='font-size:15px'>Cuota Admist.</th>
                                                            <th style='font-size:15px'>Certifica Aport.</th>
                                                            <th style='font-size:15px'>Dolar Social</th>
                                                            <th style='font-size:15px'>Unión Coope.</th>
                                                            <th style='font-size:15px'>Ahorro CXC</th>
                                                            <th style='font-size:15px'>Varias CTA.</th>
                                                            <th style='font-size:15px'>Multa</th>
                                                            <th style='font-size:15px'>Gestion Cobranz</th>
                                                            <th style='font-size:15px'>Fondo Ayuda</th>
                                                            <th style='font-size:15px'>Cuota Ingreso</th>
                                                            <th style='font-size:15px'>Prestamo</th>
                                                            <th style='font-size:15px'>Anticipo</th>
                                                            <th style='font-size:15px'>Punto Emi.</th>
                                                            <th style='font-size:15px'>Total Comprobante</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> 
                                        
                                    </div>
                                </div>
                                <div class="modal-footer bg-whitesmoke br">
                                    <button type="button" class="btn btn-danger " data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </section>
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
var tablasientos=$('#tablasientos').DataTable({
         "deferRender": true,  destroy: true,searching: false,bPaginate: false, autoWidth: true,responsive: true,"ordering": false,
         "aoColumnDefs":[
        { "width": "60px", "targets": [1,2,3,4,5,6,7,8,9,10,11,12,13,14]},
        ]
,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        });
        var tabladeudas=$('#tabladeudas').DataTable({
         "deferRender": true,  destroy: true,searching: false,bPaginate: false, autoWidth: true,responsive: true,"ordering": false,
         "aoColumnDefs":[
        { "width": "60px", "targets": [1,2,3,4,5,6,7,8,9,10,11,12,13,14]},
        ]
,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        });

        var tablapagos=$('#tablapagos').DataTable({
         "deferRender": true,  destroy: true,searching: false,bPaginate: false, autoWidth: true,responsive: true,"ordering": false,
         "aoColumnDefs":[
            { "width": "60px", "targets": 0},
           { "width": "500px", "targets": 1},
           { "width": "55px", "targets": 2},
        ]
,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        });
        var Socio = "";
        function buscarDetalle(id) {
            Socio = id;
            tablapagos.clear().draw();
            tablasientos.clear().draw();
            tabladeudas.clear().draw();
            $("#date_ini").val("");
            $("#date_fin").val("");
            $.get('{!! route('accountstatus.buscar') !!}'+'?id='+id, function( datos ) {
                    $("#name_partner").val(datos[0].name_partner);
                    $("#date_registre").val(datos[0].birthday);
                    $("#identification").val(datos[0].identification);
                    $("#placa").val(datos[0].license_plate);
                    $("#mail").val(datos[0].email);
                    $("#address").val(datos[0].address_partner);
                    $("#code").val(datos[0].code_trans);
                    $("#phone1").val(datos[0].phone1);
                    $("#phone2").val(datos[0].phone2);
                    $('#estadoCuenta').modal('show');
            }).fail(function() {
                iziToast.error({
                    title: 'Transporte',
                    message: "Error al buscar detalle de factura",
                    position: 'topRight'
                });
            });
        } 

        function buscarEstado() {
            tablapagos.clear().draw();
            tablasientos.clear().draw();
            tabladeudas.clear().draw();
            $.get('{!! route('accountstatus.estadocuenta') !!}', {
                socio:Socio,
                fecha1:$("#date_ini").val(),
                fecha2:$("#date_fin").val()
            }, function( pagos ) {
                if(pagos.length > 0){
                    for (var i = 0; i < pagos.length; i++) {
                        if(pagos[i].tabla == "P"){
                            tablapagos.row.add([
                                '<input type="text" name="debe" value="'+pagos[i].date_registre+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].cuenta+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].comprobante+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].pago+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                            ]).draw( false );
                        }else if(pagos[i].tabla == "C"){
                            tablasientos.row.add([
                                '<input type="text" name="debe" value="'+pagos[i].date_registre+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].comprobante+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].cuotaAd+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].certificado+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].dolar+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].union+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].ahorro+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].varias+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].multas+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+0+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].fondo+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].cuotaIng+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].prestamo+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].anticipo+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].puntoEmi+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].total+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                            ]).draw( false );
                        }else if(pagos[i].tabla == "D"){
                            tabladeudas.row.add([
                                '<input type="text" name="debe" value="'+pagos[i].date_registre+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].comprobante+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].cuotaAd+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].certificado+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].dolar+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].union+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].ahorro+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].varias+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].multas+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+0+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].fondo+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].cuotaIng+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: center;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+parseFloat(pagos[i].prestamo).toFixed(2)+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+parseFloat(pagos[i].anticipo).toFixed(2)+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].puntoEmi+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                                '<input type="text" name="debe" value="'+pagos[i].total+'" onchange="Decimal(this)" style="width:100%;pading-top:-50px;text-align: right;" class="custom" onkeyup="checkDec(this);" readonly>',
                            ]).draw( false );
                        }
                    
                    }
                }else{
                    iziToast.success({
                        title: 'Transporte',
                        message: "No existe estado de cuenta para el socio "+$("#name_partner").val(),
                        position: 'topRight'
                    });
                }
                        
            }).fail(function() {
    
            });
        } 


function mensaje(){
    iziToast.success({
        title: 'Transporte',
        message: "Descargando Excel Espere...",
        position: 'topRight'
    });
}

    </script>
@endsection