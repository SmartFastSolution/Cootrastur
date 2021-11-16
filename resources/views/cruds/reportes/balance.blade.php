@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Balance General</h1>
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
                <div class="col-xs-1 col-md-1" id="descargaexcel">
                    <label for="pago" class="control-label">&nbsp;</label>
                    <div class="form-group">
                        <a  href="" download id="descagadirecta"><img  onclick="mensaje();"  class="file" src="{{ url('/adminlte/img/files/xls.png') }}" style="width:33px"></a>
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

    function descargaReporte() {
        $('#descargaexcel a').prop('href', '{!!  route('reportes.verblance') !!}?fechaini='+$("#fechaini").val()+'&fechafin='+$("#fechafin").val());
    }

</script>
@endsection