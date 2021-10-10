<div>
    <div class="card">
        <div class="card-body">

            <div class="row mb-4 justify-content-between">
                <div class="col-lg-4 form-inline">
                    Por Pagina: &nbsp;
                    <select wire:model="perPage" class="form-control form-control-sm">
                        <option>10</option>
                        <option>15</option>
                        <option>25</option>
                    </select>
                </div>

                <div class="col-lg-3">
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Cliente...">
                </div>
            </div>

            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center ">
                                Cliente
                                <a class="text-primary" wire:click.prevent="sortBy('cliente')" role="button">

                                    @include('includes._sort-icon', ['field' => 'cliente'])
                                </a>
                            </th>
                            <th class="px-4 py-2 text-center ">
                                SubServicio
                                <a class="text-primary" wire:click.prevent="sortBy('sub')" role="button">

                                    @include('includes._sort-icon', ['field' => 'sub'])
                                </a>
                            </th>
                            <th class="px-4 py-2 text-center ">
                                Tipo Plan
                                <a class="text-primary" wire:click.prevent="sortBy('tipoplan')" role="button">

                                    @include('includes._sort-icon', ['field' => 'tipoplan'])
                                </a>
                            </th>
                            <th class="px-4 py-2 text-center">Costo</th>
                            <th class="px-4 py-2 text-center">Estado</th>
                            <th class="px-4 py-2 text-center" colspan="2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->isNotEmpty())
                            @foreach ($data as $compra)
                                <tr>
                                    <td class="text-center ">{{ $compra->cliente }}</td>
                                    <td class="text-center ">{{ $compra->sub }}</td>
                                    <td class="text-center ">{{ $compra->tipoplan }}</td>
                                    <td class="text-center ">${{ $compra->costo }}</td>
                                    <td class="text-center ">
                                        <span style="cursor: pointer;"
                                            wire:click.prevent="estadochange('{{ $compra->id }}')"
                                            class="badge @if ($compra->estado == 'aprobada') badge-success
                                        @else
                                            badge-dark @endif">{{ $compra->estado }}</span>
                                    </td>
                                    <td width="10px" class="text-center ">
                                        <button class="btn btn-icon icon-left btn-primary" data-toggle="modal"
                                            data-target="#Show" wire:click.prevent="ShowData({{ $compra->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                    <td width="10px" class="text-center ">
                                      <button class="btn btn-icon icon-left btn-primary" data-toggle="modal"
                                          data-target="#Show" wire:click.prevent="Interaccion({{ $compra->id }})">
                                          <i class="fas fa-inbox"></i>

                                      </button>
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
