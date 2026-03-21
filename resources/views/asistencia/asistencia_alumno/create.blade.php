@extends('layouts.dashboard')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            📋 {{ $curso->nivel->nombre ?? 'Sin nivel' }} - {{ $curso->division }}
        </h1>
        <p class="text-gray-500 text-sm">
            Fecha: {{ $fecha }}
        </p>
    </div>

    {{-- 🔴 ERRORES DE VALIDACIÓN --}}
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('asistencia.asistencia_alumno.store') }}" method="POST">
        @csrf

        <input type="hidden" name="curso_id" value="{{ $curso->id }}">
        <input type="hidden" name="fecha" value="{{ $fecha }}">
        <input type="hidden" name="anio" value="{{ $anio }}"> {{-- ✅ FIX CLAVE --}}

        <div class="bg-white rounded-xl shadow overflow-hidden">

            <table class="min-w-full text-sm">

                <thead class="bg-blue-600 text-white uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Apellido</th>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-center">Asistencia</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($alumnos as $alumno)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4">#{{ $alumno->id }}</td>

                        <td class="px-6 py-4 font-semibold">
                            {{ $alumno->apellido }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $alumno->nombre }}
                        </td>

                        <td class="px-6 py-4 text-center">

                            <select name="asistencias[{{ $alumno->id }}]"
                                    class="border rounded-lg px-3 py-1">
                                <option value="presente">P</option>
                                <option value="ausente">A</option>
                            </select>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-400">
                            No hay alumnos en este curso.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div><br>

        <!-- BOTONES -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('asistencia.asistencia_alumno.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-xl shadow transition">
                Cancelar
            </a>

            <button type="submit"
                    class="bg-gradient-to-r from-blue-600 to-blue-800 hover:scale-105 transition transform text-white px-5 py-2 rounded-xl shadow-lg">
                Guardar Asistencia
            </button>
        </div>

    </form>

</div>

@endsection