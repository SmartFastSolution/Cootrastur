
<div>
    @include('cruds.accountsatussocios.estadocuenta.modal.modalestadocuenta')
    <div class="card">
        <div class="card-body">
        <div class="row mb-4 ">
            <div class="col-xs-12 col-md-4 form-group">
                <label>Cedula:</label> 
                <input wire:model="search_cedula" class="form-control" type="text" placeholder="Buscar Cedula...">
            </div>

            <div class="col-xs-12 col-md-4 form-group">
                <label>Codigo:</label> 
                <input wire:model="search_codigo" class="form-control" type="text" placeholder="Buscar Codigo...">
            </div>
            <div class="col-xs-12 col-md-4 form-group">
                <label>Nombres:</label> 
                <input wire:model="search_nombres" class="form-control" type="text" placeholder="Buscar Nombres...">
            </div>
        </div>
        <div class="row mb-4 ">
            <div class="col-xs-12 col-md-4 form-group">
                <label>Fecha Inicio:</label> 
                <input wire:model="search_fecha1" class="form-control" type="date" >
            </div>

            <div class="col-xs-12 col-md-4 form-group">
                <label>Fecha Final:</label> 
                <input wire:model="search_fecha2" class="form-control" type="date" >
            </div>
        </div>

        <div class="row mb-4 justify-content-between">
            <div class="col-lg-4 form-inline">
                Por Pagina: &nbsp;
                <select wire:model="perPage" class="form-control form-control-sm">
                    <option>10</option>
                    <option>15</option>
                    <option>25</option>
                </select>
            </div>
        </div>

        <div class="row table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-center">Código </th>
                        <th class="px-4 py-2 text-center">identificación</th>
                        <th class="px-4 py-2 text-center ">
                            Nombre
                            <a class="text-primary" wire:click.prevent="sortBy('nombre')" role="button">
   
                                @include('includes._sort-icon', ['field' => 'nombre'])
                            </a>
                        </th>
                        <th class="px-4 py-2 text-center">Antiguedad</th>
                        <th class="px-4 py-2 text-center" >Acción</th>
                        <th class="px-4 py-2 text-center"  colspan="2">Descargas Excel</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isNotEmpty())
                        @foreach ($data as $p)
                            <tr>
                                <td class="text-center ">{{ $p->code_trans }}</td>
                                <td class="text-center ">{{ $p->identification }}</td>
                                <td class="text-center ">{{ $p->name_partner }}</td>
                                <td class="text-center ">{{ $p->date_begin }}</td>
                                <td class="text-center ">
                                    <button class="btn btn-success" onclick="buscarDetalle({{ $p->id }});">
                                        Ver
                                    </button>
                                </td>
                                <td  width="20px">
                                    <a href="{{ route('accountstatus.comprobantecobro') }}?comp={{ $p->id }}&fechaini={{ $search_fecha1 }}&fechafin={{ $search_fecha2 }}" onclick="mensaje();"  download="Reporte" id="descagacobros" class="btn btn-success">Cobros</a>
                                </td>
                                <td  width="20px">
                                    <a href="{{ route('accountstatus.comprobantedeuda') }}?comp={{ $p->id }}&fechaini={{ $search_fecha1 }}&fechafin={{ $search_fecha2 }}" onclick="mensaje();"  download="Reporte" id="descagadeudas" class="btn btn-success">Deudas</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">
                                <p class="text-center">No hay resultado para la busqueda
                                    <strong>{{ $search }}</strong> en la pagina
                                    <strong>{{ $page }}</strong> al mostrar
                                    <strong>{{ $perPage }} </strong> por pagina
                                </p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
           </div>

        <div class="row">
            <div class="col">
                {{ $data->links() }}
            </div>
            <div class="col text-right text-muted">
                Mostrar {{ $data->firstItem() }} a {{ $data->lastItem() }} de
                {{ $data->total() }} registros
            </div>
        </div>
        </div>
    </div>

</div>
