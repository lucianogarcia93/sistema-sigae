<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Estadísticas del Alumno</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        th {
            background-color: #2563eb;
            color: white;
        }

        h2, h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        .section-title {
            text-align: left;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

    <h2>Estadísticas de {{ $alumno->nombre }} {{ $alumno->apellido }}</h2>

    <!-- Asistencias -->
    <div class="section-title">Asistencias</div>
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
    <div style="margin-top:30px; font-weight:bold;">Calificaciones</div>
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
                                Primer Cuatrimestre
                                @break
                            @case('seg_cuatrimestre')
                                Segundo Cuatrimestre
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
                <td colspan="2" style="text-align:center;">No hay calificaciones disponibles</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>