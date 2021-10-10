<div>
   @include('cruds.supplier.supplier.modal.modalproveedor')
   <div class="card-body">
       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createProveedor"> Crear un Proveedor</button>
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
                <input wire:model="search" class="form-control" type="text" placeholder="Buscar Proveedor...">
            </div>
        </div>

        <div class="row table-responsive">
         <table class="table table-striped">
             <thead>
                 <tr>
                     <th class="px-4 py-2 text-center">Codigo</th>
                     <th class="px-4 py-2 text-center">identificacion</th>
                     <th class="px-4 py-2 text-center ">
                         Nombre
                         <a class="text-primary" wire:click.prevent="sortBy('nombre')" role="button">

                             @include('includes._sort-icon', ['field' => 'nombre'])
                         </a>
                     </th>
                     <th class="px-4 py-2 text-center">Direccion</th>
                     <th class="px-4 py-2 text-center">Estado</th>
                     <th class="px-4 py-2 text-center" colspan="2">Acción</th>
                 </tr>
             </thead>
             <tbody>
                 @if ($data->isNotEmpty())
                     @foreach ($data as $p)
                         <tr>
                             <td class="text-center ">{{ $p->code }}</td>
                             <td class="text-center ">{{ $p->identification }}</td>
                             <td class="text-center ">{{ $p->name }}</td>
                             <td class="text-center ">{{ $p->address }}</td>
                             <td class="text-center ">
                              <span style="cursor: pointer;"
                                  wire:click.prevent="estadochange('{{ $p->id }}')"
                                  class="badge @if ($p->status == 'activo') badge-success
                                           @else
                                  badge-danger @endif">{{ $p->status }}</span>
                                  </td>
                             <td width="10px">
                                 <button class="btn btn-success" data-toggle="modal" data-target="#createProveedor"
                                     wire:click.prevent="editProveedor({{ $p->id }})">
                                     Editar
                                 </button>
                             </td>
                             <td width="10px">
                                 <button class="btn btn-danger"
                                     wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Proveedor?','eliminarProveedor', {{ $p->id }})">
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
