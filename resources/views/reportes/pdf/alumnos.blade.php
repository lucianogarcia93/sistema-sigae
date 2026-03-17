<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Alumnos</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        th {
            background-color: #2563eb;
            color: white;
        }
    </style>
</head>
<body>

    <h2>Listado General de Alumnos</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Curso</th>
                <th>Nivel</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->id }}</td>
                <td>{{ $alumno->nombre }} {{ $alumno->apellido }}</td>
                <td>{{ $alumno->curso->division ?? '-' }}</td>
                <td>{{ $alumno->curso->nivel->nombre ?? '-' }}</td>
                <td>{{ $alumno->activo ? 'Activo' : 'Inactivo' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>