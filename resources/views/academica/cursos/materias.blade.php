@extends('layouts.dashboard')

@section('content')

<div class="max-w-4xl mx-auto">

<!-- HEADER -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">📚 Materias del Curso</h1>
        <p class="text-gray-500 text-sm">
            Asignar materias al curso <strong>{{ $curso->division }}</strong>
        </p>
    </div>
</div>

<!-- MENSAJES -->
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<!-- FORMULARIO -->
<div class="bg-white shadow rounded-xl p-6">

    <form action="{{ route('academica.cursos.materias.update', $curso) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            @foreach($materias as $materia)

                <label class="flex items-center gap-3 border rounded-lg p-3 hover:bg-gray-50 cursor-pointer">

                    <input 
                        type="checkbox"
                        name="materias[]"
                        value="{{ $materia->id }}"
                        class="w-5 h-5 text-blue-600"
                        {{ in_array($materia->id, $materiasAsignadas) ? 'checked' : '' }}
                    >

                    <div>
                        <p class="font-semibold text-gray-700">
                            {{ $materia->nombre }}
                        </p>

                        <p class="text-xs text-gray-400">
                            Código: {{ $materia->codigo }}
                        </p>
                    </div>

                </label>

            @endforeach

        </div>

        <!-- BOTONES -->
        <div class="flex justify-end mt-6 gap-3">

            <a href="{{ route('academica.cursos.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Volver
            </a>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Guardar Materias
            </button>

        </div>

    </form>

</div>

</div>

@endsection
