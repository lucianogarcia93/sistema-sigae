@extends('layouts.dashboard')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📅 Gestión de Feriados</h1>
            <p class="text-gray-500 text-sm">Administración de feriados del calendario</p>
        </div>

        <a href="{{ route('calendario.feriados.create') }}"
           class="bg-gradient-to-r from-blue-600 to-blue-800 hover:scale-105 transition transform text-white px-5 py-2 rounded-xl shadow-lg">
            Nuevo Feriado
        </a>
    </div>

    <!-- MENSAJE SUCCESS -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLA -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="min-w-full text-sm">

            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Fecha</th>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y">

            @forelse($feriados as $feriado)

                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4 font-medium text-gray-700">
                        {{ \Carbon\Carbon::parse($feriado->fecha)->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4 font">
                        {{ $feriado->nombre }}
                    </td>

                    <td class="px-6 py-4">

                        @if($feriado->activo)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Activo
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Inactivo
                            </span>
                        @endif

                    </td>

                    <td class="px-6 py-4 text-right flex justify-end gap-2">

                        <!-- EDITAR -->
                        <a href="{{ route('calendario.feriados.edit',$feriado->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs shadow">
                            Editar
                        </a>

                        <!-- TOGGLE ACTIVAR / DESACTIVAR -->
                        <form action="{{ route('calendario.feriados.update',$feriado->id) }}"
                              method="POST">

                            @csrf
                            @method('PUT')

                            <input type="hidden" name="nombre" value="{{ $feriado->nombre }}">
                            <input type="hidden" name="fecha" value="{{ $feriado->fecha }}">
                            <input type="hidden" name="descripcion" value="{{ $feriado->descripcion }}">
                            <input type="hidden" name="activo" value="{{ $feriado->activo ? 0 : 1 }}">

                            <button class="px-3 py-1 rounded-lg text-xs text-white shadow
                            {{ $feriado->activo ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">

                                {{ $feriado->activo ? 'Desactivar' : 'Activar' }}

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-400">
                        No hay feriados registrados.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection