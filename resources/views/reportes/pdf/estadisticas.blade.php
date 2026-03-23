@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📊 Reporte de Alumnos</h1>
            <p class="text-gray-500 text-sm">Consulta y descarga el rendimiento de tus estudiantes</p>
        </div>
    </div>

    <!-- FILTROS -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
    
     @if(request('curso_id') && request('anio') && count($alumnos) == 0)
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-6">
        ⚠️ No hay alumnos registrados para el curso y año seleccionado.
    </div>
    @endif

        <form class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

            <!-- Curso -->
            <div>
                <label class="block text-sm mb-1">Nivel - Curso</label>
                <select name="curso_id" class="border rounded px-3 py-2 w-full" required onchange="this.form.submit()">
                    <option value="">Seleccionar Curso</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id }}" @if(request('curso_id') == $curso->id) selected @endif>
                            {{ $curso->nivel->nombre ?? '-' }} - {{ $curso->division }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Año -->
            <div>
                <label class="block text-sm mb-1">Año Escolar</label>
                <select name="anio" class="border rounded px-3 py-2 w-full" required onchange="this.form.submit()">
                    <option value="">Seleccionar Año</option>
                    <option value="2026" @if(request('anio') == 2026) selected @endif>2026</option>
                    <option value="2027" @if(request('anio') == 2027) selected @endif>2027</option>
                </select>
            </div>

            <!-- Alumno -->
            <div>
                <label class="block text-sm mb-1">Alumno</label>
                <select name="alumno_id" class="border rounded px-3 py-2 w-full" required onchange="this.form.submit()">
                    <option value="">Seleccionar Alumno</option>
                    @foreach($alumnos as $al)
                        <option value="{{ $al->id }}" @if(request('alumno_id') == $al->id) selected @endif>
                            {{ $al->nombre }} {{ $al->apellido }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Botón PDF -->
            <div>
                @if(request('alumno_id') && request('curso_id'))
                <button type="submit" 
                        formaction="{{ route('reportes.alumnos.estadistica.pdf') }}" 
                        formmethod="GET"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">
                    Descargar PDF
                </button>
                @endif
            </div>

        </form>
    </div>

    <!-- RESULTADOS -->
    @if(isset($alumno))
    <div class="bg-white rounded-xl shadow p-6 space-y-6">

        <h2 class="text-xl font-bold mb-2">📄 Estadísticas de {{ $alumno->nombre }} {{ $alumno->apellido }}</h2>

        <!-- Asistencias -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-green-50 p-4 rounded-lg shadow-sm">
                <h3 class="font-semibold mb-2">Presentes</h3>
                <p class="text-2xl font-bold">{{ $totalAsistencias }}</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg shadow-sm">
                <h3 class="font-semibold mb-2">Ausentes</h3>
                <p class="text-2xl font-bold">{{ $totalFaltas }}</p>
            </div>
        </div>

        <!-- Calificaciones -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border text-sm">
                <thead class="bg-gray-200 text-left">
                    <tr>
                        <th class="border px-3 py-2">Materia</th>
                        <th class="border px-3 py-2">Nota</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($calificaciones as $nota)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-3 py-2">
                            {{ $nota->materiaCurso?->materia?->nombre ?? 'Sin materia' }}
                            @if($nota->tipo)
                                (
                                @switch($nota->tipo)
                                    @case('pri_cuatrimestre')
                                        1 Cuatrimestre
                                        @break
                                    @case('seg_cuatrimestre')
                                        2 Cuatrimestre
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
                        <td class="border px-3 py-2">{{ $nota->nota }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="border px-3 py-2 text-center" colspan="2">No hay calificaciones disponibles</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    @endif

</div>
@endsection