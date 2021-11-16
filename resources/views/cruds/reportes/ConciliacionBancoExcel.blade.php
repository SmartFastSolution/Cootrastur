<table class="table table-bordered table-striped datatable  dt-select" id="tablauser">
    <thead style='background-color:#167F92; color:white; font-size:12px'>
        <tr>
            <th colspan="3" style="text-align:center;" >Conceptos</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @if (count($data) > 0)
            @foreach ($data as $conci)
                <tr>
                    <td colspan="3" style="vertical-align:middle;">{{ $conci["col1"] }}</td>
                    <td style="vertical-align:middle;text-align:right;">{{ ( $conci["col4"] == null ? "" : "$".number_format($conci["col4"], 2, '.', "") )}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    
</table>