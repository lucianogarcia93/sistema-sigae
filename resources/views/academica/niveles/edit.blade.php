@extends('layouts.dashboard')

@section('content')

<div class="max-w-3xl mx-auto px-6 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            🎓 Editar Nivel
        </h1>

        <p class="text-gray-500 text-sm">
            Modificar datos del nivel académico
        </p>
    </div>

    <div class="bg-white shadow rounded-2xl p-6">

        <form action="{{ route('academica.niveles.update', $nivel) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- SELECT NIVEL -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nivel Académico
                </label>

                <select name="nombre"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-blue-400
                               focus:outline-none transition shadow-sm">

                    <option value="">Seleccione nivel</option>

                    @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}° Año"
                            {{ old('nombre', $nivel->nombre) == $i.'° Año' ? 'selected' : '' }}>
                            {{ $i }}° Año
                        </option>
                    @endfor

                </select>

                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ACTIVO -->
            <div class="mb-6">
                <label class="flex items-center gap-2 cursor-pointer">

                    <input type="checkbox"
                           name="activo"
                           value="1"
                           {{ old('activo', $nivel->activo) ? 'checked' : '' }}
                           class="rounded border-gray-300">

                    <span class="text-gray-700">Nivel Activo</span>

                </label>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('academica.niveles.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
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