@extends('layouts.dashboard')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📊 Reporte de Asistencias</h1>
            <p class="text-gray-500 text-sm">Comparativa de alumnos (gráfico de ondas)</p>
        </div>
    </div>

    <!-- FILTROS -->
    <div class="bg-white p-6 rounded-xl shadow mb-8">
    @if(request('curso_id') && request('anio') && empty($datasetsGrafico))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6">
            No hay alumnos o registros de asistencia para el curso y año seleccionado.
        </div>
    @endif
        
        <form method="GET" action="{{ route('reportes.generales') }}" id="formFiltros">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- CURSO -->
                <div>
                    <label class="text-sm text-gray-600">Nivel - Curso</label>
                    <select name="curso_id"
                        onchange="this.form.submit()"
                        class="border rounded-lg px-4 py-2 w-full">

                        <option value="">Seleccionar curso</option>

                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}"
                                {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nivel->nombre ?? '' }} - {{ $curso->division }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- AÑO -->
                <div>
                    <label class="text-sm text-gray-600">Año</label>
                    <select name="anio"
                        onchange="this.form.submit()"
                        class="border rounded-lg px-4 py-2 w-full">

                        <option value="">Seleccionar año</option>
                        <option value="2026" {{ request('anio') == 2026 ? 'selected' : '' }}>2026</option>
                        <option value="2027" {{ request('anio') == 2027 ? 'selected' : '' }}>2027</option>

                    </select>
                </div>

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
            📈 Asistencia por Alumno (Ondas)
        </h2>

        <p class="text-sm text-gray-500 mb-4">
            Evolución de asistencias de los alumnos a lo largo del tiempo
        </p>

        <canvas id="graficoAsistencia"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('graficoAsistencia').getContext('2d');

    const datasets = @json($datasetsGrafico ?? []);

    const colores = [
        'rgba(34,197,94,1)',   // verde
        'rgba(239,68,68,1)',   // rojo
        'rgba(59,130,246,1)',  // azul
        'rgba(168,85,247,1)',  // violeta
        'rgba(249,115,22,1)'   // naranja
    ];

    const datasetsEstilizados = datasets.map((ds, index) => {

        const color = colores[index % colores.length];

        return {
            ...ds,
            borderColor: color,
            backgroundColor: color,
            tension: 0.9, // 🔥 ultra suave
            fill: false,
            pointRadius: 0, // 🔥 sin puntos (onda limpia)
            borderWidth: 3
        };
    });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($fechasGrafico ?? []),
            datasets: datasetsEstilizados
        },
        options: {
            responsive: true,
            animation: {
                duration: 2000,
                easing: 'easeInOutSine' // 🔥 animación onda real
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw > 0 
                                ? context.dataset.label + ': Presente'
                                : context.dataset.label + ': Ausente';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: function(context) {
                            if (context.tick.value === 0) {
                                return '#000'; // 🔥 eje central marcado
                            }
                            return '#e5e7eb';
                        }
                    },
                    ticks: {
                        callback: function(value) {
                            if (value > 0) return '✔';
                            if (value < 0) return '✖';
                            return '0';
                        }
                    }
                }
            }
        }
    });
</script>

@endsection