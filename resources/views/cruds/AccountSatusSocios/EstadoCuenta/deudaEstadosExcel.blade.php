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
            @foreach ($pagos as $deudas)
                <tr>
                    <td style="vertical-align:middle;">{{ $deudas["date_registre"] }}</td>
                    <td style="vertical-align:middle;">{{ $deudas["comprobante"] }}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["cuotaAd"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["certificado"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["dolar"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["union"] , 2, '.', "")}}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["ahorro"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["varias"] , 2, '.', "")}}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["multas"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["gestion"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["fondo"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["cuotaIng"] , 2, '.', "")}}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["prestamo"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["anticipo"], 2, '.', "") }}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["puntoEmi"], 2, '.', "")}}</td>
                    <td style="vertical-align:middle;">${{ number_format($deudas["total"] , 2, '.', "")}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>

</table>