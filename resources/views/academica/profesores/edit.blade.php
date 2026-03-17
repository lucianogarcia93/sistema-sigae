@extends('layouts.dashboard')

@section('content')

<div class="max-w-3xl mx-auto">

    <h1 class="text-3xl font-bold mb-6 text-gray-800">✏️ Editar Profesor</h1>

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

        <form action="{{ route('academica.profesores.update', $profesor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-2">Nombre</label>
                <input type="text" name="nombre"
                       value="{{ old('nombre', $profesor->nombre) }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Apellido</label>
                <input type="text" name="apellido"
                       value="{{ old('apellido', $profesor->apellido) }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">DNI</label>
                <input type="text" name="dni"
                       value="{{ old('dni', $profesor->dni) }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Email</label>
                <input type="email" name="email"
                       value="{{ old('email', $profesor->email) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('academica.profesores.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Cancelar
                </a>

                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                    Actualizar
                </button>
            </div>

        </form>

    </div>

</div>

@endsection