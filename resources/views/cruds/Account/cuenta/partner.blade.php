@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Administración de Socios</h1>

<div class="card-body">
    <a type="button" class="btn btn-primary" href="{{route('partner.partner.create')}}" > Crear Socio</a>
</div>

@livewire('Partner.socios.socios')
@endsection