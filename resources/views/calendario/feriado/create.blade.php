@extends('layouts.dashboard')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">

    <h2 class="text-xl font-bold mb-5">Nuevo Día</h2>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>Ups! Hay errores:</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('calendario.feriados.store') }}" method="POST">
        @csrf

        <!-- FECHA -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Fecha</label>
            <input type="date" name="fecha"
                   class="w-full border rounded-lg p-2"
                   required>
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Descripción</label>
            <input type="text" name="descripcion"
                   class="w-full border rounded-lg p-2"
                   required>
        </div>

        <!-- TIPO -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Tipo</label>
            <select name="tipo" class="w-full border rounded-lg p-2">
                <option value="feriado">Feriado</option>
                <option value="sin_clases">Día sin clases</option>
            </select>
        </div>

        <!-- BOTONES -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('calendario.feriados.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                Cancelar
            </a>

            <button type="submit"
                    class="bg-gradient-to-r from-blue-600 to-blue-800 hover:scale-105 transition transform text-white px-5 py-2 rounded-xl shadow-lg">
                Guardar
            </button>
        </div>

    </form>
</div>

@endsection