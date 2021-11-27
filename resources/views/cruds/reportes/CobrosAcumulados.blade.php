@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Cobros Acumulados Socios</h1>
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
                    <label>Socios</label>
                    <select  wire:model.defer="id_partner" class="form-control @error('id_partner') is-invalid @enderror" onchange="descargaReporte();" id="id_partner">
                        <option value="ALL">TODOS</option>
                        <?php foreach($bancos as $bank): ?>                
                            <option value="<?php echo $bank->id ?>"><?php echo $bank->name_partner ?></option>
                        <?php endforeach; ?>
                    </select>
                        @error('id_partner')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
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
        $('#descargaexcel a').prop('href', '{!!  route('reportes.vercobrosa') !!}?fechaini='+$("#fechaini").val()+'&fechafin='+$("#fechafin").val()+'&partner='+$("#id_partner").val());
    }

</script>
@endsection