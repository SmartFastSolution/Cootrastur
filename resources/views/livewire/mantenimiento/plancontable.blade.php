<div>


    @include('cruds.mantenimientos.plancontable.modal.modalplancontable')

    <div class="card-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCuenta"> Crear Plan Contable</button>
    </div>
<div class="card">
    <div class="card-body">
        <div class="col-lg-6 form-inline ">
            Filtro por Nivel : &nbsp; 
             <select wire:model="filternivel" class="form-control form-control-sm">
                 <option value="">Todas</option>
                 <option value="1">1</option>
                 <option value="2">2</option>
                 <option value="3">3</option>
                 <option value="4">4</option>
             </select>
         </div>
    </div>
    
</div>
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
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Servicio...">
                </div>
            </div>

            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center ">
                               Razón Social
                                <a class="text-primary" wire:click.prevent="sortBy('empresa')" role="button">
                                    @include('includes._sort-icon', ['field' => 'empresa'])
                                </a>
                            </th>
                            <th class="px-4 py-2 text-center ">
                               Cuenta
                                 <a class="text-primary" wire:click.prevent="sortBy('cuenta')" role="button">
                                     @include('includes._sort-icon', ['field' => 'cuenta'])
                                 </a>
                             </th>
                             <th class="px-4 py-2 text-center ">
                                Tipo Cuenta
                                  <a class="text-primary" wire:click.prevent="sortBy('tipoc')" role="button">
                                      @include('includes._sort-icon', ['field' => 'tipoc'])
                                  </a>
                              </th>
                            <th class="px-4 py-2 text-center ">
                               Código
                            </th>
                            <th class="px-4 py-2 text-center ">
                                Nivel
                            </th>
                            <th class="px-4 py-2 text-center">Estado</th>
                            <th class="px-4 py-2 text-center" colspan="2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->isNotEmpty())
                            @foreach ($data as $p)
                                <tr>
                                    <td class="text-center "> {{ $p->empresa }}</td>
                                    <td class="text-center "> {{ $p->cuenta  }}</td>
                                    <td class="text-center "> {{ $p->tipoc   }}</td>
                                    <td class="text-center "> {{ $p->codigo  }}</td>
                                    <td class="text-center "> {{ $p->nivel   }}</td>
                                    <td class="text-center ">
                                        <span style="cursor: pointer;"
                                            wire:click.prevent="estadochange('{{ $p->id }}')"
                                            class="badge @if ($p->estado == 'activo') badge-success
                                        @else
                                            badge-danger @endif">{{ $p->estado }}</span>
                                    </td>
                                    <td width="10px">
                                        <button class="btn btn-success" data-toggle="modal"
                                            data-target="#createCuenta"
                                            wire:click.prevent="Edit({{ $p->id }})">
                                            Editar
                                        </button>
                                    </td>
                                    <td width="10px">
                                        <button class="btn btn-danger"
                                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar esta Cuenta?','eliminarCuenta', {{ $p->id }})">
                                            Eliminar
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
