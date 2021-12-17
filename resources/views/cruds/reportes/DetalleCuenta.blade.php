@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Detalle de movimientos por cuenta </h1>
<br>
<div>
     <div class="card">
         <div class="card-body">
            <div class="row mb-4 ">
                <div class="col-xs-12 col-md-3 form-group">
                    <label>Fecha Inicio:</label> 
                    <input class="form-control" type="date" id="fechaini" onchange="descargaReporte();">
                </div>
    
                <div class="col-xs-12 col-md-3 form-group">
                    <label>Fecha Final:</label> 
                    <input class="form-control" type="date"id="fechafin" onchange="descargaReporte();">
                </div>
                
                <div class="col-xs-12 col-md-3 form-group">
                    <label>Codigo/Clave cuenta</label>
                    <input class="form-control" type="text"id="cuenta" onchange="descargaReporte();">
                    <input class="form-control" type="hidden"id="codigo" onchange="descargaReporte();">
                </div>
                <div class="col-xs-1 col-md-1">
                    <label for="pago" class="control-label">&nbsp;</label>
                    <div class="form-group">
                        <button type="button" class="btn btn-info form-control" onclick="buscarCuenta();"><i class="fa fa-fw fa-search"></i></button>
                    </div>
                </div>
                <div class="col-xs-1 col-md-1" id="descargaexcel">
                    <label for="pago" class="control-label">&nbsp;</label>
                    <div class="form-group">
                        <a  href="" download id="descagadirecta"><img  onclick="mensaje();"  class="file" src="{{ url('/adminlte/img/files/xls.png') }}" style="width:33px"></a>
                    </div>
                </div>
                <div class="col-xs-1 col-md-1" id="descargapdf">
                    <label for="pago" class="control-label">&nbsp;</label>
                    <div class="form-group">
                        <a  href="" download id="descagadirecta"><img  onclick="mensajePDF();"  class="file" src="{{ url('/adminlte/img/files/pdf.png') }}" style="width:33px"></a>
                    </div>
                </div>
            </div>
         </div>
     </div>
 
 </div>
 
@endsection

@section('js')
    <script>
function mensaje(){
    iziToast.success({
        title: 'Transporte',
        message: "Descargando Excel Espere...",
        position: 'topRight'
    });
}
function mensajePDF(){
    iziToast.success({
        title: 'Transporte',
        message: "Descargando PDF Espere...",
        position: 'topRight'
    });
}

    function descargaReporte() {
        $('#descargaexcel a').prop('href', '{!!  route('reportes.verdetallecuentaexcel') !!}?fechaini='+$("#fechaini").val()+'&fechafin='+$("#fechafin").val()+'&cuenta='+$("#cuenta").val()+'&codigo='+$("#codigo").val());
        $('#descargapdf a').prop('href', '{!!  route('reportes.verdetallecuenta') !!}?fechaini='+$("#fechaini").val()+'&fechafin='+$("#fechafin").val()+'&cuenta='+$("#cuenta").val()+'&codigo='+$("#codigo").val());
    }

    function buscarCuenta() {
        if($("#cuenta").val()==""){
            iziToast.error({
                title: 'Transporte',
                message: "Ingrese una clave o código de cuenta",
                position: 'topRight'
            });
        }else{
            $("#codigo").val("");
            $.get('{!! route('reportes.buscarcuenta') !!}'+'?code='+$("#cuenta").val(), function( datos ) {
                if(datos == "ERROR"){
                    iziToast.error({
                        title: 'Transporte',
                        message: "No existe Clave/Codigo de cuenta "+ $("#cuenta").val(),
                        position: 'topRight'
                    });
                }else{
                    //console.log(datos)
                    $("#codigo").val(datos);
                    iziToast.success({
                        title: 'Transporte',
                        message: "Clave/Codigo de cuenta correcta",
                        position: 'topRight'
                    });
                    descargaReporte();
                }
            }).fail(function() {
                iziToast.error({
                    title: 'Transporte',
                    message: "Error al buscar cuenta",
                    position: 'topRight'
                });
            });
        }
    }

</script>
@endsection