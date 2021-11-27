<div>
    @include('cruds.account.cuenta.modal.modalseat')
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAsiento" onclick="mostrarBoton();"> Crear Asiento</button>         
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
                 <input wire:model="search_code" class="form-control" type="text" placeholder="Buscar Comprobante...">
             </div>
         </div>
 
         <div class="row table-responsive">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th class="px-4 py-2 text-center">Numero Comprobante </th>
 
                      <th class="px-4 py-2 text-center ">
                          Descripción
                          <a class="text-primary" wire:click.prevent="sortBy('nombre')" role="button">
 
                              @include('includes._sort-icon', ['field' => 'nombre'])
                          </a>
                      </th>
                      <th class="px-4 py-2 text-center">Fecha</th>
                      <th class="px-4 py-2 text-center">Estado</th>
                      <th class="px-4 py-2 text-center" colspan="2">Acción</th>
                      <th class="px-4 py-2 text-center">Descargar</th>
                  </tr>
              </thead>
              <tbody>
                  @if ($data->isNotEmpty())
                      @foreach ($data as $p)
                          <tr>
                              <td class="text-center ">{{ $p->number_voucher }}</td>
                              <td class="text-center ">{{ $p->header_description }}</td>
                              <td class="text-center ">{{ $p->date_voucher }}</td>
                              <td class="text-center ">
                                 <span style="cursor: pointer;"
                                     onclick="aprobarAsiento({{ $p->id }});"
                                     class="badge @if ($p->status == 'BORRADOR') badge-success
                                              @else
                                     badge-danger @endif">{{ $p->status }}</span>
                                     </td>
                              <td width="10px">
                                  <button class="btn btn-success" data-toggle="modal" data-target="#createAsiento"
                                    onclick="buscarDetalle({{ $p->id }});">
                                      Editar
                                  </button>
                              </td>
                              <td width="10px">
                                  <button class="btn btn-danger"
                                    onclick="EliminarAsiento({{ $p->id }});">
                                      Eliminar
                                  </button>
                              </td>
                              <td class="text-center " width="20px">
                                <a href="{{ route('account.asientopdf') }}?comp={{$p->id}}" onclick="mensajepdf();" download="Reporte" id="descagadirecta" class="btn btn-danger">PDF</a>
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
