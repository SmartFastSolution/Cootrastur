@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Administración de Proveedores</h1>

<div class="card-body">
    <a type="button" class="btn btn-primary" href="{{route('supplier.supplier.create')}}" > Crear Proveedores</a>
</div>

@livewire('Supplier.proveedores.proveedor')
@endsection