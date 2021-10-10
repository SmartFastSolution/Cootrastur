@extends('layouts.app')
@section('content')
{{--
<div>
    <h1 class="text-center font-weight-bold">Ingreso Manual de Comprobantes Electronicos</h1>
    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pills-ingreso-tab" data-toggle="pill" href="#pills-ingreso" role="tab" aria-controls="pills-ingreso" aria-selected="true">Ingresos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="pills-gasto-tab" data-toggle="pill" href="#pills-gasto" role="tab" aria-controls="pills-gasto" aria-selected="false">Gastos</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-ingreso" role="tabpanel" aria-labelledby="pills-ingreso-tab">
            <ingreso-factura-component />
        </div>
        <div class="tab-pane fade" id="pills-gasto" role="tabpanel" aria-labelledby="pills-gasto-tab">
            <gasto-factura-component />
        </div>
    </div>
</div>
--}}
<div id="app">
    <h2 class="text-center font-weight-bold">Ingreso Manual de Comprobantes Electronicos</h2>
    <ingreso-manual-component />
</div>
@endsection
@section('style')
<style>
.nav-pills .nav-link {
    border-radius: 0px !important;
}

#pills-tab {
    border-bottom: 0.5px solid rgba(0,0,0,0.2);
}
</style
@endsection
