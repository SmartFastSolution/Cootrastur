<table class="table table-bordered table-striped datatable  dt-select" id="tablauser">
    <thead style='background-color:#167F92; color:white; font-size:12px'>
        <tr>
            <th style="text-align:center;" >Codigó</th>
            <th style="text-align:center;" >Identificación</th>
            <th style="text-align:center;" >Nombre Socio</th>
            <th style="text-align:center;" >Cuota ADM</th>
            <th style="text-align:center;" >Certificado Aport</th>
            <th style="text-align:center;" >Dólar Social</th>
            <th style="text-align:center;" >Union Cooper</th>
            <th style="text-align:center;" >Ahorro x Cobrar</th>
            <th style="text-align:center;" >Varias Cuentas</th>
            <th style="text-align:center;" >Multas</th>
            <th style="text-align:center;" >Gestion de Ayuda</th>
            <th style="text-align:center;" >Fondo Ayuda</th>
            <th style="text-align:center;" >Cuota Ingreso</th>
            <th style="text-align:center;" >Prestamos</th>
            <th style="text-align:center;" >Anticipo</th>
            <th style="text-align:center;" >Punto Emision</th>
            <th style="text-align:center;" >Total</th>

        </tr>
    </thead>
    <tbody>
        @if (count($pagos) > 0)
            @foreach ($pagos as $cobros)
            <tr>
                <td style="vertical-align:middle;">{{ $cobros["codigo"] }}</td>
                <td style="vertical-align:middle;">{{ (string)$cobros["identification"] }}</td>
                <td style="vertical-align:middle;">{{ $cobros["socio"] }}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["cuotaAd"]*-1 , 2, '.', "")}}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["certificado"]*-1 , 2, '.', "") }}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["dolar"]*-1 , 2, '.', "") }}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["union"]*-1 , 2, '.', "")}}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["ahorro"]*-1 , 2, '.', "")}}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["varias"]*-1 , 2, '.', "")}}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["multas"]*-1 , 2, '.', "") }}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["gestion"]*-1 , 2, '.', "")}}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["fondo"]*-1 , 2, '.', "") }}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["cuotaIng"]*-1 , 2, '.', "") }}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["prestamo"]*-1 , 2, '.', "")}}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["anticipo"]*-1 , 2, '.', "")}}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["puntoEmi"]*-1 , 2, '.', "")}}</td>
                <td style="vertical-align:middle;">${{ number_format($cobros["total"]*-1 , 2, '.', "") }}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
    
</table>