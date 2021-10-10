@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold">Vista Cliente</h1>

    <section class="section">
        <div class="section-body">

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Datos de Compra</h4>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        Especialista a Cargo:
                                    </span>
                                    <span class="float-right text-muted">
                                      <strong>{{ $compra->especialista->name }}</strong>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Fecha de Compra
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $compra->created_at->diffForHumans() }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Estado
                                    </span>
                                    <span class="float-right  badge badge-danger">
                                        {{ $compra->estado }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Tipo Plan
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $compra->tipoplan->nombre }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Costo del Plan
                                    </span>
                                    <span class="float-right ">
                                        <strong>${{ $compra->costo }}</strong>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                                        aria-selected="true">Subservicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                                        aria-selected="false">Plan</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="card-header">
                                        <h4>Detalle Subservicio</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="m-t-30">


                                            {!!htmlspecialchars_decode($compra->subservicio->descripcion)!!}
                                        </p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card-header">
                                        <h4>Detalle del Plan</h4>
                                    </div>
                                    <div class="card-body">


                                        <p class="m-t-30">
                                            {!!htmlspecialchars_decode($compra->plan->descripcion)!!}

                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
