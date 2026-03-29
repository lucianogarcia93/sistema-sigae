@extends('layouts.dashboard')

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    ✅ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    ⚠️ {!! session('error') !!}
</div>
@endif

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📊 Cargar Notas de Alumnos</h1>
            <p class="text-gray-500 text-sm">Calificaciones por curso, año y materia</p>
        </div>
    </div>

    <!-- FORMULARIO -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <form method="GET" action="{{ route('calendario.calificaciones.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <!-- Curso -->
                <div>
                    <label class="text-sm text-gray-600">Nivel - Curso - Turno</label>
                    <select name="curso_id" class="w-full border rounded-lg px-4 py-2"
                        onchange="this.form.anio.value=''; this.form.submit()">
                        <option value="">Seleccionar curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}"
                                {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nivel->nombre ?? 'Sin nivel' }} - {{ $curso->division }} - {{ $curso->turno }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Año -->
                <div>
                    <label class="text-sm text-gray-600">Año Escolar</label>
                    <select name="anio" class="w-full border rounded-lg px-4 py-2"
                        onchange="this.form.submit()">
                        <option value="">Seleccionar año</option>
                        <option value="2026" {{ request('anio') == 2026 ? 'selected' : '' }}>2026</option>
                        <option value="2027" {{ request('anio') == 2027 ? 'selected' : '' }}>2027</option>
                    </select>
                </div>

                <!-- Materia -->
                <div>
                    <label class="text-sm text-gray-600">Materia</label>
                    <select name="materia_curso_id" class="w-full border rounded-lg px-4 py-2"
                        onchange="this.form.submit()">
                        <option value="">Seleccionar materia</option>
                        @foreach($materiasCurso as $mc)
                            <option value="{{ $mc->id }}"
                                {{ request('materia_curso_id') == $mc->id ? 'selected' : '' }}>
                                {{ $mc->materia->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tipo -->
                <div>
                    <label class="text-sm text-gray-600">Tipo de Nota</label>
                    <select name="tipo_nota" class="w-full border rounded-lg px-4 py-2" onchange="this.form.submit()">
                        <option value="" selected>Seleccionar tipo</option>
                        <option value="pri_cuatrimestre" {{ request('tipo_nota') == 'pri_cuatrimestre' ? 'selected' : '' }}>1 Cuatrimestre</option>
                        <option value="seg_cuatrimestre" {{ request('tipo_nota') == 'seg_cuatrimestre' ? 'selected' : '' }}>2 Cuatrimestre</option>
                        <option value="nota_final" {{ request('tipo_nota') == 'nota_final' ? 'selected' : '' }}>Nota Final</option>
                        <option value="tp" {{ request('tipo_nota') == 'tp' ? 'selected' : '' }}>Trabajo Práctico</option>
                    </select>
                </div>

            </div>
        </form>
    </div>

    <!-- MENSAJE SIN ALUMNOS -->
    @if(request()->filled('curso_id') && request()->filled('anio') && $alumnos->isEmpty())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-4">
            No hay alumnos para el curso y año seleccionado.
        </div>
    @endif

    <!-- TABLA -->
    @if($cursoSeleccionado && request('anio') && request('materia_curso_id') && request('tipo_nota'))
    <div class="bg-white p-6 rounded-xl shadow">

        <form id="formNotas" action="{{ route('calendario.calificaciones.store') }}" method="POST">
            @csrf
            <input type="hidden" name="materia_curso_id" value="{{ request('materia_curso_id') }}">
            <input type="hidden" name="tipo_nota" value="{{ request('tipo_nota') }}">
            <input type="hidden" name="anio" value="{{ request('anio') }}">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-blue-600 text-white uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left">Nombre</th>
                            <th class="px-6 py-3 text-left">Apellido</th>
                            <th class="px-6 py-3 text-left">Nota</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @php $tipoSeleccionado = request('tipo_nota'); @endphp
                        @foreach($alumnos as $alumno)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $alumno->nombre }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $alumno->apellido }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $notaExistente = '';
                                    if(in_array($tipoSeleccionado, ['pri_cuatrimestre','seg_cuatrimestre','nota_final','tp'])) {
                                        $key = $alumno->id . '_' . $tipoSeleccionado;
                                        if(isset($notasExistentes[$key])) {
                                            $notaExistente = $notasExistentes[$key]->nota;
                                        }
                                    }
                                @endphp
                                <input type="number"
                                       step="0.01"
                                       min="0"
                                       max="10"
                                       placeholder="0 - 10"
                                       name="notas[{{ $alumno->id }}]"
                                       value="{{ old('notas.'.$alumno->id, $notaExistente) }}"
                                       class="notaAlumno border rounded-lg px-3 py-1 w-24 focus:ring focus:ring-blue-200"
                                       data-original="{{ $notaExistente }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('calendario.calificaciones.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="ml-2 bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-xl shadow-lg transition">
                    Guardar Notas
                </button>
            </div>
        </form>

    </div>
    @endif

</div>

<script>
document.getElementById('formNotas')?.addEventListener('submit', function(e){
    let inputs = document.querySelectorAll('.notaAlumno');
    let cambio = false;

    inputs.forEach(input => {
        let original = input.dataset.original || '';
        if(input.value !== original && original !== '') {
            cambio = true;
        }
    });

    if(cambio) {
        let confirmar = confirm("Se cambiaron algunas notas en alumnos. ¿Desea modificarlas?");
        if(!confirmar) {
            e.preventDefault();
        }
    }
});
</script>

@endsection