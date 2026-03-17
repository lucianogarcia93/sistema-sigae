@extends('layouts.dashboard')

@section('content')

<div class="max-w-2xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Nuevo Nivel
        </h1>

        <p class="text-gray-500 text-sm">
            Registrar un nuevo nivel académico
        </p>
    </div>

    <!-- CARD FORM -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

        <!-- ERRORES -->
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">

                <ul class="text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        <!-- FORMULARIO -->
        <form action="{{ route('academica.niveles.store') }}"
              method="POST"
              class="space-y-6">

            @csrf

            <!-- SELECT NIVEL -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nivel Académico
                </label>

                <select name="nombre"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-blue-400
                               focus:outline-none transition shadow-sm">

                    <option value="">
                        Seleccione nivel
                    </option>

                    @for($i = 1; $i <= 6; $i++)

                        <option value="{{ $i }}° Año"
                            {{ old('nombre') == $i.'° Año' ? 'selected' : '' }}>

                            {{ $i }}° Año

                        </option>

                    @endfor

                </select>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-4 pt-4">

                <a href="{{ route('academica.niveles.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-xl shadow transition">
                    Cancelar
                </a>

                <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-800
                               hover:scale-105 transform transition
                               text-white px-6 py-2 rounded-xl shadow-lg">
                    Guardar Nivel

                </button>

            </div>

        </form>

    </div>

</div>

@endsection