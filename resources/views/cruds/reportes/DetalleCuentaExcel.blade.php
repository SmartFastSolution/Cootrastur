<table class="table table-bordered table-striped datatable  dt-select" id="tablauser">
    <thead style='background-color:#167F92; color:white; font-size:12px'>
        <tr>
            <th style="text-align:center;" >Fecha</th>
            <th style="text-align:center;" >Comprobante</th>
            <th style="text-align:center;" >Débito</th>
            <th style="text-align:center;" >Crédito</th>
            <th style="text-align:center;" >Saldos</th>
            <th style="text-align:center;" >Documento</th>
            <th style="text-align:center;" >Detalle</th>
        </tr>
    </thead>
    <tbody>
        @if (count($data) > 0)
            @foreach ($data as $cobros)
            <tr>
                <td style="vertical-align:middle;">{{ $cobros["col0"] }}</td>
                <td style="text-align:center;vertical-align:middle;">{{ (string)$cobros["col1"] }}</td>
                <td style="text-align:right;">${{ number_format($cobros["col3"] , 2, '.', "")}}</td>
                <td style="text-align:right;">${{ number_format($cobros["col4"] , 2, '.', "") }}</td>
                <td style="text-align:right;">${{ number_format($cobros["col5"] , 2, '.', "") }}</td>
                <td style="vertical-align:middle;">{{ (string)$cobros["col6"] }}</td>
                <td style="vertical-align:middle;">{{ (string)$cobros["col2"] }}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
    
</table>