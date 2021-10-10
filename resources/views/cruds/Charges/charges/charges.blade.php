@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Administración de Cobros</h1>

<div class="card-body">
    <a type="button" class="btn btn-primary" href="{{route('charges.charges.create')}}" > Crear Cobros</a>
</div>

@livewire('Charges.cobros.cobro')
@endsection