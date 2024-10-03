<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Recibos de nomina</title>
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @foreach ($respaldos as $respaldo)
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 20%;">
                    <img src="{{ public_path('logo.png') }}" alt="" style="width: 100%;">
                </td>
                <td style="width: 65%; font-size: 0.8em;">
                    <div>OPE631216S18 - OFICINA DE PENSIONES DEL ESTADO</div>
                    <div>REGIMEN FISCAL DE PERSONAS MORALES CON FINES NO LUCRATIVOS</div>
                    <div>PERIODO DE PAGO: {{ $periodo }}</div>
                </td>
                <td style="width: 15%;">
                    <table style="width: 100%; margin: 0; padding: 0; border-spacing: 0;">
                        <thead>
                            <tr>
                                <th style="background: #eee; border: 1px solid #000; font-size: 0.8em;">FECHA DE PAGO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border-left: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; font-size: 0.8em;">{{ $fecha }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin: 0; padding: 0; border-spacing: 0; border: 1px solid #000;">
        <thead>
            <tr>
                <th style="background: #eee; border-bottom: 1px solid #000; border-right: 1px solid #000;">NO. BENEFICIARIO</th>
                <th style="background: #eee; border-bottom: 1px solid #000; border-right: 1px solid #000;">NOMBRE</th>
                <th style="background: #eee; border-bottom: 1px solid #000; border-right: 1px solid #000;">PERIODICIDAD</th>
                <th style="background: #eee; border-bottom: 1px solid #000;">FORMA DE PAGO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; border-right: 1px solid #000;">{{ implode('', [Arr::get($maestro, 'jpp'), Arr::get($maestro, 'num')]) }}</td>
                <td style="text-align: center; border-right: 1px solid #000;">{{ Arr::get($maestro, 'nombre') }}</td>
                <td style="text-align: center; border-right: 1px solid #000;">MENSUAL</td>
                <td style="text-align: center;">ELECTRONICO</td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin: 0; padding: 0; border-spacing: 0; border-left: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000;">
        <thead>
            <tr>
                <th style="background: #eee; border-bottom: 1px solid #000; border-right: 1px solid #000;">CURP</th>
                <th style="background: #eee; border-bottom: 1px solid #000; border-right: 1px solid #000;">R.F.C.</th>
                <th style="background: #eee; border-bottom: 1px solid #000; border-right: 1px solid #000;">IMSS</th>
                <th style="background: #eee; border-bottom: 1px solid #000;">MODALIDAD</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; border-right: 1px solid #000;">{{ Arr::get($maestro, 'curp') }}</td>
                <td style="text-align: center; border-right: 1px solid #000;">{{ Arr::get($maestro, 'rfc') }}</td>
                <td style="text-align: center; border-right: 1px solid #000;">{{ Arr::get($maestro, 'imss') }}</td>
                <td style="text-align: center;"></td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin: 0; padding: 0; border-spacing: 0; border-left: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000;">
        <thead>
            <tr>
                <th style="width: 50%; background: #eee; border-right: 1px solid #000;">PERCEPCIONES</th>
                <th style="width: 50%; background: #eee;">DEDUCCIONES</th>
            </tr>
        </thead>
    </table>

    <table style="width: 100%; margin: 0; padding: 0; border-spacing: 0;">
        <thead>
            <tr>
                <th style="width: 10%; background: #eee; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;">CLAVE</th>
                <th style="width: 25%; background: #eee; border-right: 1px solid #000; border-bottom: 1px solid #000;">DESCRIPCIÓN</th>
                <th style="width: 15%; background: #eee; border-right: 1px solid #000; border-bottom: 1px solid #000;">IMPORTE</th>

                <th style="width: 10%; background: #eee; border-right: 1px solid #000; border-bottom: 1px solid #000;">CLAVE</th>
                <th style="width: 25%; background: #eee; border-right: 1px solid #000; border-bottom: 1px solid #000;">DESCRIPCIÓN</th>
                <th style="width: 15%; background: #eee; border-bottom: 1px solid #000; border-right: 1px solid #000;">IMPORTE</th>
            </tr>
        </thead>
    </table>

    <table>
        <tbody>
         <tr><td>
            <table>
            
            @php
                $percepciones = 0;
                $deducciones = 0;
            @endphp
            
            @foreach ($respaldos as $item)
                
                @php
                    $percepciones = $percepciones + Arr::get($item, 'monto', 0);
                @endphp
                
                <tr>
                    <td style="width: 10%; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000;">{{ Arr::get($item, 'clave') }}</td>
                    <td style="width: 25%; text-align: center; border-right: 1px solid #000;">{{ Arr::get($item, 'descri') }}</td>
                    <td style="width: 15%; text-align: right; border-right: 1px solid #000;">{{ implode('', ['$', number_format(Arr::get($item, 'monto', 0), 2)]) }}</td>

                    <td style="width: 10%; text-align: center; border-right: 1px solid #000;">&nbsp;</td>
                    <td style="width: 25%; text-align: center; border-right: 1px solid #000;">&nbsp;</td>
                    <td style="width: 15%; text-align: right; border-right: 1px solid #000;">&nbsp;</td>
                </tr>
                @endforeach
            
            </table>
        </td>
        <td>
            <table>
            @foreach ($respaldos as $item)
                @php
                    $deducciones = $deducciones + Arr::get($item, 'monto', 0);
                @endphp
                
                <tr>
                    <td style="width: 10%; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000;">&nbsp;</td>
                    <td style="width: 25%; text-align: center; border-right: 1px solid #000;">&nbsp;</td>
                    <td style="width: 15%; text-align: right; border-right: 1px solid #000;">&nbsp;</td>

                    <td style="width: 10%; text-align: center; border-right: 1px solid #000;">{{ Arr::get($item, 'clave') }}</td>
                    <td style="width: 25%; text-align: center; border-right: 1px solid #000;">{{ Arr::get($item, 'descri') }}</td>
                    <td style="width: 15%; text-align: right; border-right: 1px solid #000;">{{ implode('', ['$', number_format(Arr::get($item, 'monto', 0), 2)]) }}</td>
                </tr>
            @endforeach
                </table>
            </td></tr>
        </table>
            <tr>
                <td style="width: 10%; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;">&nbsp;</td>
                <td style="width: 25%; text-align: center; border-right: 1px solid #000; border-bottom: 1px solid #000;">&nbsp;</td>
                <td style="width: 15%; text-align: right; border-right: 1px solid #000; border-bottom: 1px solid #000;">&nbsp;</td>

                <td style="width: 10%; text-align: center; border-right: 1px solid #000; border-bottom: 1px solid #000;">&nbsp;</td>
                <td style="width: 25%; text-align: center; border-right: 1px solid #000; border-bottom: 1px solid #000;">&nbsp;</td>
                <td style="width: 15%; text-align: right; border-right: 1px solid #000; border-bottom: 1px solid #000;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;">
                    <strong>TOTAL:</strong>
                </td>
                <td style="text-align: right; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;">
                    ${{ number_format($percepciones, 2) }}
                </td>
                <td>&nbsp;</td>
                <td style="text-align: right;">
                    <strong>TOTAL:</strong>
                </td>
                <td style="text-align: right; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;">
                    ${{ number_format($deducciones, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
                <td>
                    &nbsp;
                </td>
                <td>&nbsp;</td>
                <td style="text-align: right;">
                    &nbsp;
                </td>
                <td style="text-align: right; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;">
                    ${{ number_format($percepciones - $deducciones, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div style="font-size: 0.7em;">Éste es un documento oficial y cualquier alteración de sus partes constituirá un delito conforme lo establecido en el Capitulo II del Código Penal del Estado de Oaxaca.</div>
                </td>
            </tr>
        </tbody>
    </table>
    @if (!$loop->last)
        <div style="break-after: always; page-break-after: always;"></div>
    @endif
    @endforeach
</body>
</html>
