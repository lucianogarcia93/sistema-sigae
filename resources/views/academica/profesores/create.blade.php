@extends('layouts.dashboard')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">👨‍🏫 Crear Curso</h1>
        <p class="text-gray-500 text-sm">Registrar nuevo curso académico</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-6 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow rounded-xl p-6">

        <form action="{{ route('academica.profesores.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-2">Nombre</label>
                <input type="text" name="nombre"
                       value="{{ old('nombre') }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Apellido</label>
                <input type="text" name="apellido"
                       value="{{ old('apellido') }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">DNI</label>
                <input type="text" name="dni"
                       value="{{ old('dni') }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('academica.profesores.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Cancelar
                </a>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Guardar Profesor
                </button>
            </div>

        </form>

    </div>

</div>

@endsection