<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Estadísticas del Alumno</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            margin: 20px;
        }

        /* 🔹 Encabezados */
        h2 {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }

        h3 {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 15px;
        }

        /* 🔹 Sección */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-top: 25px;
            margin-bottom: 8px;
        }

        /* 🔹 Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center; /* 🔹 Centrado de valores */
        }

        th {
            background-color: #2563eb;
            color: white;
            font-size: 14px;
        }

        td {
            font-size: 12px;
        }

        /* 🔹 Filas alternadas para mejor lectura */
        tr:nth-child(even) {
            background-color: #f3f4f6;
        }

        /* 🔹 Mensajes de tabla vacía */
        .empty {
            text-align: center;
            font-style: italic;
            color: #6b7280;
        }
    </style>
</head>
<body>

    <h2>Estadísticas de {{ $alumno->nombre }} {{ $alumno->apellido }}</h2>
    <h3>Resumen Académico</h3>

    <!-- Asistencias -->
    <div class="section-title">Total de Asistencias</div>
    <table>
        <thead>
            <tr>
                <th>Presentes</th>
                <th>Ausentes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $totalAsistencias }}</td>
                <td>{{ $totalFaltas }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Calificaciones -->
    <div class="section-title">Notas Cargadas</div>
    <table>
        <thead>
            <tr>
                <th>Materia</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            @forelse($calificaciones as $nota)
            <tr>
                <td>
                    {{ $nota->materiaCurso?->materia?->nombre ?? 'Sin materia' }}
                    @if($nota->tipo)
                        (
                        @switch($nota->tipo)
                            @case('pri_cuatrimestre')
                                1° Cuatrimestre
                                @break
                            @case('seg_cuatrimestre')
                                2° Cuatrimestre
                                @break
                            @case('nota_final')
                                Nota Final
                                @break
                            @case('tp')
                                Trabajo Práctico
                                @break
                            @default
                                {{ $nota->tipo }}
                        @endswitch
                        )
                    @endif
                </td>
                <td>{{ $nota->nota }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="empty">No hay calificaciones disponibles</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>