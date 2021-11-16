@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Administración de Rubros y Porcentajes</h1>

<div class="card-body">
    <a type="button" class="btn btn-primary" href="{{route('charges.charges.create')}}" > Crear Rubro y Porcentaje</a>
</div>

@livewire('Itempercentages.rubros.rubrosPorcentaje')
@endsection