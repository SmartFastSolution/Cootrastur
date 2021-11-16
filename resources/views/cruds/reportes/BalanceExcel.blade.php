<table class="table table-bordered table-striped datatable  dt-select" id="tablauser">
    <thead style='background-color:#167F92; color:white; font-size:12px'>
        <tr>
            <th>Código</th>
            <th colspan="3" style="text-align:center;" >Descripción Cuenta Contables</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @if (count($data) > 0)
            @foreach ($data as $balance)
                <tr>
                    <td style="vertical-align:middle;">{{ $balance["colcode"] }}</td>
                    <td style="vertical-align:middle;">{{ $balance["col1"] }}</td>
                    <td style="vertical-align:middle;">{{ $balance["col2"] }}</td>
                    <td style="vertical-align:middle;">{{ $balance["col3"]}}</td>
                    <td style="vertical-align:middle;text-align:right;">{{ ( $balance["col4"] == null ? "" : "$".number_format($balance["col4"], 2, '.', "") )}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    
</table>