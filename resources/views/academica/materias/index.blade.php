@extends('layouts.dashboard')

@section('content')

<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📚 Gestión de Materias</h1>
            <p class="text-gray-500 text-sm">Administración de materias del sistema</p>
        </div>

        <a href="{{ route('academica.materias.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg w-full sm:w-auto text-center">
            Nueva Materia
        </a>
    </div>

    <!-- MENSAJES -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- BUSCADOR -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <form method="GET" action="{{ route('academica.materias.index') }}">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔎 Buscar materia..."
                       class="w-full border rounded-lg px-4 py-2">
                <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg w-full sm:w-auto">
                    Buscar
                </button>
            </div>
        </form>
    </div>

    <!-- TABLA -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm">

            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Materia</th>
                    <th class="px-6 py-3 text-left">Profesor</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($materias as $materia)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">#{{ $materia->id }}</td>
                    <td class="px-6 py-4 font-medium">{{ $materia->nombre }}</td>
                    <td class="px-6 py-4">{{ $materia->profesor->nombre ?? '-' }} {{ $materia->profesor->apellido ?? '' }}</td>
                    <td class="px-6 py-4">
                        @if($materia->activo)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Activa</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Inactiva</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex flex-col sm:flex-row justify-end gap-2">
                            <a href="{{ route('academica.materias.edit', $materia) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs text-center">
                               Editar
                            </a>
                            <form action="{{ route('academica.materias.destroy', $materia) }}" method="POST"
                                  onsubmit="return confirm('¿Cambiar estado de la materia?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 rounded-lg text-xs text-white
                                    {{ $materia->activo ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
                                    {{ $materia->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-400">
                        No hay materias registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $materias->appends(request()->query())->links() }}
    </div>

</div>

@endsection