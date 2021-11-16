<table class="table table-bordered table-striped datatable  dt-select" id="tablauser">
    <thead style='background-color:#167F92; color:white; font-size:12px'>
        <tr>
            <th>Clave cuenta</th>
            <th>Código Cuenta</th>
            <th>Descripcion Cuenta</th>
            <th>Débitos</th>
            <th>Créditos</th>
        </tr>
    </thead>
    <tbody>
        @if (count($data) > 0)
            @foreach ($data as $comprobante)
                <tr>
                    <td style="vertical-align:middle;">{{ $comprobante->key_account }}</td>
                    <td style="vertical-align:middle;">{{ $comprobante->code_account }}</td>
                    <td style="vertical-align:middle;">{{ $comprobante->description }}</td>
                    <td style="vertical-align:middle;">{{ $comprobante->value_debito }}</td>
                    <td style="vertical-align:middle;">{{ $comprobante->value_credito }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot >
        <tr style="font-family: Titillium Web;color:#434343;">
            <th style="font-size: 12px;text-align: left;padding:  7px  7px;"></th>
            <th style="font-size: 12px;text-align: left;padding:  7px  7px;"></th>
            <th style="font-size: 12px;text-align: right;padding: 7px  7px; font-weight:bold;color:black;" >TOTAL</th>
            <th style="font-size: 12px;text-right: left;padding:  7px  7px; font-weight:bold;color:black;">{{ $total_debito->debito }}</th>
            <th style="font-size: 12px;text-right: left;padding:  7px  7px; font-weight:bold;color:black;">{{ $total_crebito->credito }}</th>
        </tr>
     </tfoot>
</table>