@extends('layouts.dashboard')

@section('content')

<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                📄 Gestión de Justificaciones
            </h1>
            <p class="text-gray-500 text-sm">
                Administración de justificaciones de inasistencias
            </p>
        </div>
    </div>

    <!-- BUSCADOR -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">

        <form method="GET" action="{{ route('calendario.justificaciones.index') }}">

            <div class="flex flex-col sm:flex-row gap-3">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="🔎 Buscar justificación..."
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">

                <button type="submit"
                        class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg transition w-full sm:w-auto">
                    Buscar
                </button>

            </div>

        </form>
    </div>

    <!-- MENSAJE SUCCESS -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLA -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="min-w-full text-sm">

            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Alumno</th>
                    <th class="px-6 py-3 text-left">Fecha</th>
                    <th class="px-6 py-3 text-left">Motivo</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($justificaciones as $justificacion)

                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4 font-medium text-gray-700">
                        {{ $justificacion->asistenciaAlumno->alumno->nombre ?? '-' }}
                        {{ $justificacion->asistenciaAlumno->alumno->apellido ?? '' }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ \Carbon\Carbon::parse($justificacion->asistenciaAlumno->fecha)->format('d/m/Y') ?? '-' }}
                    </td>

                    <td class="px-6 py-4 text-gray-800">
                        {{ $justificacion->motivo }}
                    </td>

                    <td class="px-6 py-4">

                        @if($justificacion->estado == 'pendiente')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Pendiente
                            </span>

                        @elseif($justificacion->estado == 'aprobado')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Aprobada
                            </span>

                        @elseif($justificacion->estado == 'rechazado')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Rechazada
                            </span>
                        @endif

                    </td>

                    <td class="px-6 py-4 text-right">

                        @if($justificacion->estado == 'pendiente')

                        <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">

                            <form method="POST"
                                action="{{ route('calendario.justificaciones.update', $justificacion->id) }}">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="estado" value="aprobado">

                                <button class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded-lg text-xs shadow">
                                    Aprobar
                                </button>

                            </form>

                            <form method="POST"
                                action="{{ route('calendario.justificaciones.update', $justificacion->id) }}">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="estado" value="rechazado">

                                <button class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-lg text-xs shadow">
                                    Rechazar
                                </button>

                            </form>

                        </div>

                        @else
                            <span class="text-gray-400 text-xs italic">Sin acciones</span>
                        @endif

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-400">
                        No hay justificaciones registradas.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection