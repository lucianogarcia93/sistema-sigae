@extends('layouts.dashboard')

@section('content')

<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📅 Gestión de Días No Laborales</h1>
            <p class="text-gray-500 text-sm">Feriados y días sin clases</p>
        </div>

        <a href="{{ route('calendario.feriados.create') }}"
           class="bg-gradient-to-r from-blue-600 to-blue-800 hover:scale-105 transition transform text-white px-5 py-2 rounded-xl shadow-lg w-full sm:w-auto text-center">
            Nuevo Registro
        </a>
    </div>

    <!-- BUSCADOR -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">

        <form method="GET" action="{{ route('calendario.feriados.index') }}">

            <div class="flex flex-col sm:flex-row gap-3">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="🔎 Buscar feriado..."
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
                    <th class="px-6 py-3 text-left">Fecha</th>
                    <th class="px-6 py-3 text-left">Descripción</th>
                    <th class="px-6 py-3 text-left">Tipo de Día</th>
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

                    <td class="px-6 py-4">
                        {{ $feriado->descripcion }}
                    </td>

                    <td class="px-6 py-4">
                        @if($feriado->tipo == 'feriado')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Feriado
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Sin clases
                            </span>
                        @endif
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

                    <td class="px-6 py-4 text-right">
                        <div class="flex flex-col sm:flex-row justify-end gap-2">

                            <a href="{{ route('calendario.feriados.edit',$feriado->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs shadow text-center">
                                Editar
                            </a>

                            <form action="{{ route('calendario.feriados.destroy',$feriado->id) }}"
                                method="POST"
                                onsubmit="return confirm('¿Seguro que deseas cambiar el estado del registro?')">

                                @csrf
                                @method('DELETE')

                                <button class="w-full sm:w-auto px-3 py-1 rounded-lg text-xs text-white shadow
                                {{ $feriado->activo ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                                    {{ $feriado->activo ? 'Desactivar' : 'Activar' }}
                                </button>

                            </form>

                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-400">
                        No hay registros cargados.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection