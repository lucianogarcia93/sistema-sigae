@extends('layouts.dashboard')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📊 Reporte de Asistencias</h1>
            <p class="text-gray-500 text-sm">Resumen estadístico de alumnos</p>
        </div>
    </div>

    <!-- FILTRO POR FECHA -->
    <div class="bg-white p-4 rounded-xl shadow mb-8">
        <form method="GET" action="{{ route('reportes.generales') }}">
            <div class="flex gap-4">

                <select name="fecha"
                        onchange="this.form.submit()"
                        class="border rounded-lg px-4 py-2 w-56 focus:ring-2 focus:ring-blue-500">

                    @forelse($fechas as $fecha)
                        <option value="{{ $fecha }}"
                            {{ $fecha == $fechaSeleccionada ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                        </option>
                    @empty
                        <option disabled>No hay registros</option>
                    @endforelse

                </select>

            </div>
        </form>
    </div>

    <!-- CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

        <div class="bg-white shadow-lg rounded-xl p-6 text-center">
            <p class="text-gray-500 text-sm">Total Registros</p>
            <p class="text-3xl font-bold text-gray-800">{{ $total }}</p>
        </div>

        <div class="bg-green-100 shadow-lg rounded-xl p-6 text-center">
            <p class="text-green-700 text-sm font-semibold">Presentes</p>
            <p class="text-3xl font-bold text-green-700">{{ $presentes }}</p>
        </div>

        <div class="bg-red-100 shadow-lg rounded-xl p-6 text-center">
            <p class="text-red-700 text-sm font-semibold">Ausentes</p>
            <p class="text-3xl font-bold text-red-700">{{ $ausentes }}</p>
        </div>

        <div class="bg-blue-100 shadow-lg rounded-xl p-6 text-center">
            <p class="text-blue-700 text-sm font-semibold">% Asistencia</p>
            <p class="text-3xl font-bold text-blue-700">{{ $porcentaje }}%</p>
        </div>

    </div>

    <!-- GRÁFICO -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            📈 Distribución de Asistencia
        </h2>
        <canvas id="graficoAsistencia"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('graficoAsistencia');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Presentes', 'Ausentes'],
            datasets: [{
                label: 'Asistencia',
                data: [{{ $presentes }}, {{ $ausentes }}],
                backgroundColor: [
                    'rgba(34,197,94,0.7)',
                    'rgba(239,68,68,0.7)'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

@endsection