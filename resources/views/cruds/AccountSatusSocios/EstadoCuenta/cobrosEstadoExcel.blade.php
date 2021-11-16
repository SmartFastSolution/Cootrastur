<table class="table table-bordered table-striped datatable  dt-select" id="tablauser">
    <thead style='background-color:#167F92; color:white; font-size:12px'>
        <tr>
            <th>Fecha Comprobante</th>
            <th>Comprobante</th>
            <th>Cuota Admist.</th>
            <th>Certifica Aport.</th>
            <th>Dolar Social</th>
            <th>Unión Coope.</th>
            <th>Ahorro CXC</th>
            <th>Varias CTA.</th>
            <th>Multa</th>
            <th>Gestion Cobranz</th>
            <th>Fondo Ayuda</th>
            <th>Cuota Ingreso</th>
            <th>Prestamo</th>
            <th>Anticipo</th>
            <th>Punto Emi.</th>
            <th>Total Comprobante</th>
        </tr>
    </thead>
    <tbody>
        @if (count($pagos) > 0)
            @foreach ($pagos as $cobros)
                <tr>
                    <td style="vertical-align:middle;">{{ $cobros["date_registre"] }}</td>
                    <td style="vertical-align:middle;">{{ $cobros["comprobante"] }}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["cuotaAd"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["certificado"] , 2, '.', "")}}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["dolar"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["union"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["ahorro"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["varias"] , 2, '.', "")}}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["multas"] , 2, '.', "")}}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["gestion"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["fondo"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["cuotaIng"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["prestamo"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["anticipo"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["puntoEmi"] , 2, '.', "")}}</td>
                    <td style="vertical-align:middle;">${{ number_format($cobros["total"], 2, '.', "") }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    
</table>