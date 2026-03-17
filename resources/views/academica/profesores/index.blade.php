@extends('layouts.dashboard')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">👨‍🏫 Gestión de Profesores</h1>
            <p class="text-gray-500 text-sm">Administración de docentes del sistema</p>
        </div>

        <a href="{{ route('academica.profesores.create') }}"
           class="bg-gradient-to-r from-blue-600 to-blue-800 hover:scale-105 transition transform text-white px-5 py-2 rounded-xl shadow-lg">
            Nuevo Profesor
        </a>
    </div>

    <!-- BUSCADOR -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">

        <form method="GET" action="{{ route('academica.profesores.index') }}">

            <div class="flex gap-3">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="🔎 Buscar profesor..."
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">

                <button type="submit"
                        class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg transition">
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
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="min-w-full text-sm">

            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Apellido</th>
                    <th class="px-6 py-3 text-left">DNI</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($profesores as $profesor)

                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4">
                        #{{ $profesor->id }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $profesor->nombre }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $profesor->apellido }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $profesor->dni }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $profesor->email ?? '-' }}
                    </td>

                    <td class="px-6 py-4">

                        @if($profesor->activo)
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

                        <a href="{{ route('academica.profesores.edit', $profesor) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs shadow">
                            Editar
                        </a>

                        <form action="{{ route('academica.profesores.destroy', $profesor) }}"
                              method="POST"
                              onsubmit="return confirm('¿Seguro que deseas cambiar el estado del profesor?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="px-3 py-1 rounded-lg text-xs shadow text-white transition
                                    {{ $profesor->activo ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">

                                {{ $profesor->activo ? 'Desactivar' : 'Activar' }}

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-400">
                        No hay profesores registrados.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PAGINACIÓN -->
    <div class="mt-6 flex justify-center">
        {{ $profesores->links() }}
    </div>

</div>

@endsection