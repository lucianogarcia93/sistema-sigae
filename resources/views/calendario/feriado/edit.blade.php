@extends('layouts.dashboard')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">

    <h2 class="text-xl font-bold mb-5">Editar Día</h2>

    <form action="{{ route('calendario.feriados.update',$feriado->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- FECHA -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Fecha</label>
            <input type="date" name="fecha"
                   value="{{ $feriado->fecha }}"
                   class="w-full border rounded-lg p-2"
                   required>
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Descripción</label>
            <input type="text" name="descripcion"
                   value="{{ $feriado->descripcion }}"
                   class="w-full border rounded-lg p-2"
                   required>
        </div>

        <!-- TIPO -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Tipo</label>
            <select name="tipo" class="w-full border rounded-lg p-2">
                <option value="feriado" {{ $feriado->tipo == 'feriado' ? 'selected' : '' }}>
                    Feriado
                </option>
                <option value="sin_clases" {{ $feriado->tipo == 'sin_clases' ? 'selected' : '' }}>
                    Día sin clases
                </option>
            </select>
        </div>

        <!-- ACTIVO -->
        <div class="mb-4 flex items-center gap-2">
            <input type="checkbox" name="activo" value="1"
                   {{ $feriado->activo ? 'checked' : '' }}>
            <label>Activo</label>
        </div>

        <!-- BOTONES -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('calendario.feriados.index') }}"
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

@endsection