@extends('layouts.dashboard')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📥 Exportar Reportes Excel</h1>
            <p class="text-gray-500 text-sm">Selecciona el curso, turno y año que quieres exportar</p>
        </div>
    </div>

    <!-- FORMULARIO -->
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">

    @if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        ⚠️ {{ session('error') }}
    </div>
    @endif

        <form action="{{ route('reportes.export') }}" method="GET" class="space-y-6">

            <!-- CURSO -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Nivel - Curso</label>
                <select name="curso_id" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccionar Curso</option>

                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id }}">
                            {{ $curso->nivel->nombre ?? '-' }} - {{ $curso->division }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- TURNO -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Turno</label>
                <select name="turno" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccionar Turno</option>
                    <option value="mañana">🌅 Mañana</option>
                    <option value="tarde">🌇 Tarde</option>
                    <option value="noche">🌙 Noche</option>
                </select>
            </div>

            <!-- AÑO -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Año</label>
                <select name="anio" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccionar Año</option>
                    @for ($i = date('Y'); $i <= date('Y')+1; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <!-- BOTÓN -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                    📥 Descargar Excel
                </button>
            </div>

        </form>

    </div>

</div>

@endsection