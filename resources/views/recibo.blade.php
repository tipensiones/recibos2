<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Recibos de nomina</title>
    <style>
    *{
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        margin: 0;
        padding: 0;
        /* Imagen de fondo */
        background-image: url("{{ public_path('recibofondo.png') }}");
        background-size: 24.94cm 19cm; /* carta horizontal: ancho x alto */
        background-position: center;  /* Centra la imagen */
        background-repeat: no-repeat; /* No repetir */
    }

    .page-break {
        page-break-after: always;
    }
</style>
</head>

<!-- aqui va el body -->

<body>
    <img 
        src="{{ public_path('logo2.png') }}" 
        style="
            position: fixed;
            top: 0.001cm;      /* distancia desde la parte superior */
            left: 0.1cm;     /* distancia desde la izquierda */
            width: 8.2cm;    /* ancho de la imagen */
            height: auto;  /* mantiene proporción */
            z-index: 2;    /* encima del fondo */
        "
    >    

    @foreach($datosPorTipo as $tipo => $grupo)
        <!-- PARTE DE LA FECHA -->
        <table style="position:absolute; top:2.1cm; left:22.35cm; border-collapse:collapse; font-family: Arial, sans-serif; font-size:12pt; text-align:center;">
            <tr><td style="width:2.7cm; border:none;">{{ $grupo['fecha'] }}</td></tr>
        </table>

        <!-- PARTE DEL PERIODO -->
        <table style="position:absolute; top:2.3cm; left:11.7cm; border-collapse:collapse; font-family: Arial, sans-serif; font-size:11pt; text-align:left; font-weight:bold;">
            <tr><td style="width:10cm; border:none;">{{ $grupo['periodo'] }}</td></tr>
        </table>

        <!-- PARTE DEL NOMBRE Y JPP -->
        <table style="position:absolute; top:4.01cm; left:0.5cm; border-collapse:collapse; font-family: Arial, sans-serif; font-size:11pt; text-align:center;">
            <tr>
                <td style="width:3.5cm; border:none;">{{ $grupo['maestro']->proyecto }}</td>
                <td style="width:11cm; border:none;">{{ $grupo['maestro']->nombre }}</td>
            </tr>
        </table>

        <!-- PARTE DEL CURP Y RFC -->
        <table style="position:absolute; top:5.7cm; left:0.5cm; border-collapse:collapse; font-family: Arial, sans-serif; font-size:11pt; text-align:center;">
            <tr>
                <td style="width:4.8cm; border:none;">{{ $grupo['maestro']->curp }}</td>
                <td style="width:4.8cm; border:none;">{{ $grupo['maestro']->rfc }}</td>
                <td style="width:4.8cm; border:none;">{{ $grupo['maestro']->imss }}</td>
                <td style="width:9.9cm; border:none;">{{ $grupo['maestro']->categ }}</td>
            </tr>
        </table>

         <!-- PARTE DE LAS PERCEPCIONES -->
        <table style="position:absolute; top:8.3cm; left:0.5cm; border-collapse:collapse; font-family: Arial, sans-serif; font-size:6pt; text-align:center;">
            @php $totalPercepciones = 0; @endphp
            @foreach($grupo['percepciones'] as $item)
                @php $totalPercepciones += $item->monto; @endphp
                <tr>
                    <td style="width:1.5cm; border:none;">{{ $item->clave }}</td>
                    <td style="width:8.2cm; border:none;">{{ $item->descri }}</td>
                    <td style="width:2.3cm; border:none;">{{ number_format($item->monto, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </table>

        <!-- PARTE DE LAS DEDUCCIONES -->
        <table style="position:absolute; top:8.3cm; left:12.72cm; border-collapse:collapse; font-family: Arial, sans-serif; font-size:6pt; text-align:center;">
            @php $totalDeducciones = 0; @endphp
            @foreach($grupo['deducciones'] as $item)
                @php $totalDeducciones += $item->monto; @endphp
                <tr>
                    <td style="width:1.5cm; border:none;">{{ $item->clave }}</td>
                    <td style="width:7.3cm; border:none;">{{ $item->descri }}</td>
                    <td style="width:1cm; border:none;">{{ $item->pagot != 0 ? $item->pago4.'/'.$item->pagot : '' }}</td>
                    <td style="width:2.3cm; border:none;">{{ number_format($item->monto, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </table>

        @php
            $neto = $totalPercepciones - $totalDeducciones;
        @endphp

        <!-- PARTE DE LOS TOTALES PERCEPCIONES -->
        <table style="position:absolute; top:17.3cm; left:10.5cm; border-collapse:collapse; font-family: Arial, sans-serif; font-size:9.5pt; text-align:center;">
            <tr>
                <td style="width:2cm; border:none;">${{ number_format($totalPercepciones, 2, '.', ',') }}</td>
            </tr>
        </table>

        <!-- PARTE DE LOS TOTALES DEDUCCIONES -->
        <table style="position:absolute; top:17.3cm; left:22.8cm; border-collapse:collapse; font-family: Arial, sans-serif; font-size:9.5pt; text-align:center;">
            <tr>
                <td style="width:2cm; border:none;">${{ number_format($totalDeducciones, 2, '.', ',') }}</td>
            </tr>
        </table>

        <!-- PARTE DEL NETO -->
        <table style="position:absolute; top:18.3cm; left:22.8cm; border-collapse:collapse; font-family: Arial, sans-serif; font-size:9.5pt; text-align:center;">
            <tr>
                <td style="width:2cm; border:none;">${{ number_format($neto, 2, '.', ',') }}</td>
            </tr>
        </table>

        @if(!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach




</body>
</html>
