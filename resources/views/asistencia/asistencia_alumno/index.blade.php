@extends('layouts.dashboard')

@section('content')

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    ⚠️ {{ session('error') }}
</div>
@endif

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📅 Asistencia de Alumnos</h1>
            <p class="text-gray-500 text-sm">Registro diario por curso</p>
        </div>
    </div>

    <!-- FORMULARIO CARGA PLANILLA -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">

        <form action="{{ route('asistencia.asistencia_alumno.create') }}" method="GET">

            <div class="grid grid-cols-3 gap-4">

                <div>
                    <label class="text-sm text-gray-600">Nivel - Curso</label>
                    <select name="curso_id" required
                            class="w-full border rounded-lg px-4 py-2">
                        <option value="">Seleccionar curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}">
                                {{ $curso->nivel->nombre ?? 'Sin nivel' }} - {{ $curso->division }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Fecha</label>
                    <input type="date"
                           name="fecha"
                           value="{{ date('Y-m-d') }}"
                           required
                           class="w-full border rounded-lg px-4 py-2">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-800 hover:scale-105 transition text-white px-4 py-2 rounded-xl shadow-lg">
                        Cargar Planilla
                    </button>
                </div>

            </div>

        </form>
    </div>

    <!-- PLANILLAS CARGADAS -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Curso</th>
                    <th class="px-6 py-3 text-left">Fecha</th>
                    <th class="px-6 py-3 text-left">Registros</th>
                    <th class="px-6 py-3 text-right">Acción</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($planillas as $planilla)

                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4 font-semibold text-gray-800">
                        {{ $planilla->curso->division ?? '-' }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $planilla->fecha }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $planilla->total ?? 0 }}
                    </td>

                    <td class="px-6 py-4 text-right">

                        <a href="{{ route('asistencia.asistencia_alumno.edit',[
                            'curso_id'=>$planilla->curso_id,
                            'fecha'=>$planilla->fecha
                        ]) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-xs shadow">
                            Ver Planilla
                        </a>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-400">
                        No hay planillas cargadas.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection