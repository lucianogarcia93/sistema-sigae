@extends('layouts.dashboard')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">🎒 Gestión de Alumnos</h1>
            <p class="text-gray-500 text-sm">Administración de estudiantes del sistema</p>
        </div>
    </div>

    <!-- MENSAJES DEL SISTEMA -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if(session('success_password'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
        🔑 Contraseña generada para el alumno:
        <strong class="text-lg">{{ session('success_password') }}</strong>
    </div>
    @endif

    <!-- BUSCADOR -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <form method="GET" action="{{ route('academica.alumnos.index') }}">
            <div class="flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔎 Buscar alumno..."
                       class="w-full border rounded-lg px-4 py-2">
                <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg">
                    Buscar
                </button>
            </div>
        </form>
    </div>

    <!-- TABLA -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Apellido</th>
                    <th class="px-6 py-3 text-left">DNI</th>
                    <th class="px-6 py-3 text-left">Curso</th>
                    <th class="px-6 py-3 text-left">Año</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($alumnos as $alumno)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">#{{ $alumno->id }}</td>
                    <td class="px-6 py-4">{{ $alumno->nombre }}</td>
                    <td class="px-6 py-4">{{ $alumno->apellido }}</td>
                    <td class="px-6 py-4">{{ $alumno->dni }}</td>
                    <td class="px-6 py-4">{{ optional($alumno->curso)->division ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $alumno->anio }}</td>
                    <td class="px-6 py-4">
                        @if($alumno->estado == 'aprobado')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Aprobado</span>
                        @elseif($alumno->estado == 'rechazado')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Rechazado</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('academica.alumnos.edit', $alumno) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs">
                                Editar
                            </a>

                            <form action="{{ route('academica.alumnos.destroy', $alumno) }}" method="POST"
                                  onsubmit="return confirm('¿Cambiar estado del alumno?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 rounded-lg text-xs text-white
                                {{ $alumno->activo ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
                                    {{ $alumno->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-400">
                        No hay alumnos registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $alumnos->links() }}
    </div>
</div>

@endsection