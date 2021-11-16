<div>
   @include('cruds.advaanceloans.advanceslo.modal.modaladvances')
   <div class="card-body">
       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAdvances"> Crear Préstamos y Anticipos</button>
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
                <input wire:model="search" class="form-control" type="text" placeholder="Buscar Préstamo y Anticipo...">
            </div>
        </div>

        <div class="row table-responsive">
         <table class="table table-striped">
             <thead>
                 <tr>           
                    <th class="px-4 py-2 text-center">Socio</th>
                     <th class="px-4 py-2 text-center ">
                        Tipo Deuda
                         <a class="text-primary" wire:click.prevent="sortBy('nombre')" role="button">

                             @include('includes._sort-icon', ['field' => 'nombre'])
                         </a>
                     </th>
                     <th class="px-4 py-2 text-center">Valor Total</th>
                     <th class="px-4 py-2 text-center">Meses Diferidos</th>
                     <th class="px-4 py-2 text-center">Valor Pendiente</th>
                     <th class="px-4 py-2 text-center">Cuenta Contable</th>
                     <th style='font-size:15px' class="px-4 py-2 text-center">Estado</th>
                     <th class="px-4 py-2 text-center" colspan="2">Acción</th>
                 </tr>
             </thead>
             <tbody>
                 @if ($data->isNotEmpty())
                     @foreach ($data as $p)
                         <tr>
                            <td class="text-center ">{{ $p->name_partner }}</td>
                            @if($p->type_prestamo == "P")
                                <td class="text-center ">Préstamo</td>
                            @else
                                <td class="text-center ">Anticipo</td>
                            @endif
                            <td class="text-center ">{{ $p->value_total }}</td>
                            <td class="text-center ">{{ $p->months }}</td>
                            <td class="text-center ">{{ $p->value_pending }}</td>
                            <td class="text-center ">{{ $p->description }}</td>
                            <td class="text-center ">
                                <span style="cursor: pointer;"
                                    wire:click.prevent="estadochange('{{ $p->id }}')"
                                    class="badge @if ($p->status == 'Borrador') badge-success
                                             @else
                                    badge-danger @endif">{{ $p->status }}</span>
                                    </td>
                            <td width="10px">
                                 <button class="btn btn-success" data-toggle="modal" data-target="#createAdvances"
                                     wire:click.prevent="editAdvances({{ $p->id }})" >
                                     Editar
                                 </button>
                            </td>
                            <td width="10px">
                                 <button class="btn btn-danger"
                                     wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Préstamo o Anticipo?','eliminarAdvances', {{ $p->id }})">
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
