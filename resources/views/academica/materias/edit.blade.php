@extends('layouts.dashboard')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Editar Materia</h1>
        <p class="text-gray-500 text-sm">Modificar datos de la materia</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">

        <form action="{{ route('academica.materias.update', $materia) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium mb-1">Nombre</label>

                    <input type="text"
                           name="nombre"
                           value="{{ $materia->nombre }}"
                           class="w-full border rounded-lg px-4 py-2"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Código</label>

                    <input type="text"
                           name="codigo"
                           value="{{ $materia->codigo }}"
                           class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Profesor</label>

                    <select name="profesor_id" class="w-full border rounded-lg px-4 py-2">

                        @foreach($profesores as $profesor)

                        <option value="{{ $profesor->id }}"
                            {{ $materia->profesor_id == $profesor->id ? 'selected' : '' }}>

                            {{ $profesor->nombre }} {{ $profesor->apellido }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Curso</label>

                    <select name="curso_id" class="w-full border rounded-lg px-4 py-2">

                        @foreach($cursos as $curso)

                        <option value="{{ $curso->id }}"
                            {{ $materia->curso_id == $curso->id ? 'selected' : '' }}>

                            {{ $curso->division }}

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

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Actualizar
                </button>

            </div>

        </form>

    </div>

</div>

@endsection