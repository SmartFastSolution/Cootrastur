@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Lista de Servicios</h1>

<div class="row">
    @if ($data->isNotEmpty())
    @foreach ($data as $p)
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
      <article class="article article-style-b">
        <div class="article-header">
          <div class="article-image" data-background="">
            @isset($p->documento->archivo)
            <img class="article-image" src="{{$p->documento->archivo}}" alt="">
            @endisset 
          </div>
          <div class="article-badge">
         
          </div>
        </div>
        <div class="article-details">
          <div class="article-title">
            <h2><a href="#">{{$p->nombre}}</a></h2>
          </div>
          <p>
            {!!htmlspecialchars_decode($p->descripcion)!!}
          </p>
          <div class="article-cta">
            <a href="{{route('subservicios', $p->id)}}"> Leer Más <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </article>
    </div>
    @endforeach
    @endif
</div>
<div class="row">
    <div class="col-center">
        {{ $data->links() }}
    </div>
    <div class="col text-right text-muted">
        Mostrar {{ $data->firstItem() }} a {{ $data->lastItem() }} de
        {{ $data->total() }} registros
    </div>
</div>




@endsection