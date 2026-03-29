@extends('layouts.dashboard')

@section('content')

<div class="max-w-3xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">📚 Crear Curso</h1>
        <p class="text-gray-500 text-sm">Registrar nuevo curso académico</p>
    </div>

    <!-- ERRORES DE VALIDACIÓN -->
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORMULARIO -->
    <div class="bg-white shadow rounded-xl p-6">

        <form action="{{ route('academica.cursos.store') }}" method="POST">
            @csrf

            <!-- CURSO -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Curso
                </label>
                <input type="text"
                       name="division"
                       value="{{ old('division') }}"
                       placeholder="Ej: A"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                       required>
            </div>

            <!-- NIVEL -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Nivel
                </label>
                <select name="nivel_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                        required>
                    <option value="">Seleccione un nivel</option>

                    @foreach($niveles as $nivel)
                        <option value="{{ $nivel->id }}"
                            {{ old('nivel_id') == $nivel->id ? 'selected' : '' }}>
                            {{ $nivel->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- TURNO -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Turno
                </label>
                <select name="turno"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                    <option value="">Seleccione turno</option>
                    <option value="Mañana" {{ old('turno') == 'Mañana' ? 'selected' : '' }}>Mañana</option>
                    <option value="Tarde" {{ old('turno') == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                    <option value="Noche" {{ old('turno') == 'Noche' ? 'selected' : '' }}>Noche</option>
                </select>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('academica.cursos.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    Cancelar
                </a>

                <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-800 hover:scale-105 transition transform text-white px-5 py-2 rounded-xl shadow-lg">
                    Guardar Curso
                </button>
            </div>

        </form>

    </div>

</div>

@endsection