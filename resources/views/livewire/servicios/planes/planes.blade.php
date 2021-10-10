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
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Sub Servicio...">
                </div>
            </div>

            <div class="row table-responsive">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th class="px-4 py-2 text-center ">
                          Sub Servicio
                           <a class="text-primary" wire:click.prevent="sortBy('subservicio')" role="button">
         
                               @include('includes._sort-icon', ['field' => 'subservicio'])
                           </a>
                       </th>
                         <th class="px-4 py-2 text-center ">
                             Tipo  Plan
                             <a class="text-primary" wire:click.prevent="sortBy('tipoplan')" role="button">
         
                                 @include('includes._sort-icon', ['field' => 'tipoplan'])
                             </a>
                         </th>
                         {{-- <th class="px-4 py-2 text-center ">
                             Descripción
                             <a class="text-primary" wire:click.prevent="sortBy('descripcion')" role="button">
         
                                 @include('includes._sort-icon', ['field' => 'descripcion'])
                             </a>
                         </th> --}}
                         <th class="px-4 py-2 text-center">Precio</th>
                         <th class="px-4 py-2 text-center">Estado</th>
                         <th class="px-4 py-2 text-center" colspan="2">Acción</th>
                     </tr>
                 </thead>
                  <tbody>
                     @if ($data->isNotEmpty())
                     @foreach ($data as $plan)
                     <tr>
                        <td class="text-center ">{{ $plan->subservicio }}</td>
                        <td class="text-center ">{{ $plan->tipoplan }}</td>
                        {{-- <td class="text-center ">{{ $plan->descripcion }}</td> --}}
                        <td class="text-center ">${{ $plan->costo }}</td>
                        <td class="text-center ">
                           <span style="cursor: pointer;"
                               wire:click.prevent="estadochange('{{ $plan->id }}')"
                               class="badge @if ($plan->estado == 'activo') badge-success
                           @else
                               badge-danger @endif">{{ $plan->estado }}</span>
                       </td>
                       <td width="10px">
                        <button class="btn btn-success" data-toggle="modal" data-target="#createService"
                            wire:click.prevent="editPlan({{ $plan->id }})">
                            Editar
                        </button>
                    </td>
                    <td width="10px">
                        <button class="btn btn-danger"
                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Servicio?','eliminarPlan', {{ $plan->id }})">
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
