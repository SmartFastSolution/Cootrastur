<div>
    @include('cruds.recibocomp.recibosocio.modal.modalrecibo')
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRecibo" onclick="mostrarBoton();"> Ingresar Comprobante Recibo</button>         
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
            <table id="tablauser" class="table table-striped" >
                <thead style='font-size:15px'>
                    <tr >
                        <th style='font-size:15px' class="px-4 py-2 text-center">Numero Comprobante </th>
                        <th style='font-size:15px' class="px-4 py-2 text-center ">
                            Descripción
                            <a class="text-primary" wire:click.prevent="sortBy('nombre')" role="button">
                                @include('includes._sort-icon', ['field' => 'nombre'])
                            </a>
                        </th>
                        <th style='font-size:15px' class="px-4 py-2 text-center">Fecha/Hora</th>
                        <th style='font-size:15px' class="px-4 py-2 text-center">Socio</th>
                        <th style='font-size:15px' class="px-4 py-2 text-center">Tipo Documento</th>
                        <th style='font-size:15px' class="px-4 py-2 text-center">Estado</th>
                        <th style='font-size:15px' class="px-4 py-2 text-center" colspan="2">Acción</th>
                        <th style='font-size:15px' class="px-4 py-2 text-center" colspan="2">Descargar</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isNotEmpty())
                        @foreach ($data as $p)
                          <tr data-entry-id="{{ $p->id }}">
                                <td class="text-center ">{{ $p->number_voucher }}</td>
                                <td class="text-center ">{{ $p->detail_voucher }}</td>
                                <td class="text-center ">{{ $p->date_voucher }}</td>
                                <td class="text-center ">{{ $p->name_partner }}</td>
                                <td class="text-center ">{{ ($p->type_document == "C"? "CHEQUE" :($p->type_document == "F"? "FACTURA" : "")) }}</td>
                                <td class="text-center ">
                                    <span style="cursor: pointer;"
                                        onclick="aprobarFactura({{ $p->id }});"
                                        class="badge @if ($p->status == 'BORRADOR') badge-success
                                                @else
                                        badge-primary @endif">{{ $p->status }}
                                    </span>
                                </td>
                                <td width="10px">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#createRecibo"
                                         onclick="buscarDetalle({{ $p->id }});">
                                        Editar
                                    </button>
                                </td>
                                <td width="10px">
                                    <button class="btn btn-danger"
                                        onclick="EliminarFactura({{ $p->id }});">
                                        Eliminar
                                    </button>
                                </td>
                                <td width="10px">
                                    <a href="{{ route('vouchers.comprobante') }}?comp={{ $p->id }}" onclick="mensaje();"  download="Reporte" id="descagadirecta" class="btn btn-success">Excel</a>
                                    
                                </td>
                                <td width="10px">
                                    <a href="{{ route('vouchers.comprobantepdf') }}?comp={{$p->id}}" onclick="mensajepdf();" download="Reporte" id="descagadirecta" class="btn btn-danger">PDF</a>
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

 @section('js')
 <script >
    
</script>
@endsection