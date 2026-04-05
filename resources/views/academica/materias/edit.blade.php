@extends('layouts.dashboard')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">📚 Editar Materia</h1>
        <p class="text-gray-500 text-sm">Modificar datos de la materia</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('academica.materias.update', $materia) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="flex flex-col gap-6">

                <div>
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text"
                           name="nombre"
                           value="{{ old('nombre', $materia->nombre) }}"
                           class="w-full border rounded-lg px-4 py-2"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Código</label>
                    <input type="text"
                           name="codigo"
                           value="{{ old('codigo', $materia->codigo) }}"
                           class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Profesor</label>
                    <select name="profesor_id" class="w-full border rounded-lg px-4 py-2" required>
                        <option value="">Seleccionar Profesor</option>
                        @foreach($profesores as $profesor)
                            <option value="{{ $profesor->id }}"
                                {{ old('profesor_id', $materia->profesor_id) == $profesor->id ? 'selected' : '' }}>
                                {{ $profesor->nombre }} {{ $profesor->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-3">

                <a href="{{ route('academica.materias.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                   Cancelar
                </a>

                <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-800 hover:scale-105 transition transform text-white px-5 py-2 rounded-xl shadow-lg">
                    Actualizar
                </button>

            </div>

        </form>

    </div>

</div>

@endsection