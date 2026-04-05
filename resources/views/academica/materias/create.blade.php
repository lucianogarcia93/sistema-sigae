@extends('layouts.dashboard')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">📚 Crear Materia</h1>
        <p class="text-gray-500 text-sm">Agregar una nueva materia al sistema</p>
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

        <form action="{{ route('academica.materias.store') }}" method="POST">

            @csrf

            <div class="flex flex-col gap-6">

                <div>
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" name="nombre" class="w-full border rounded-lg px-4 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Código</label>
                    <input type="text" name="codigo" class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Profesor</label>
                    <select name="profesor_id" class="w-full border rounded-lg px-4 py-2" required>
                        <option value ="">Seleccionar Profesor</option>
                        @foreach($profesores as $profesor)
                            <option value="{{ $profesor->id }}">
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

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Guardar Materia
                </button>

            </div>

        </form>

    </div>

</div>

@endsection