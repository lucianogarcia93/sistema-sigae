@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-8 rounded-2xl shadow-lg">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-black-800">
            📝 Justificación
        </h2>

        <!-- BOTON VER JUSTIFICACIONES -->
        <a href="{{ route('alumno.justificacion.index') }}"
           class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-xl shadow transition text-sm">
            Estados
        </a>
    </div>

    <form method="POST" action="{{ route('alumno.justificacion.store') }}">
        @csrf

        <!-- SELECCIONAR AUSENCIA -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">
                Seleccionar ausencia
            </label>

            <select
                name="asistencia_alumno_id"
                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                required
            >

                <option value="">Seleccione una ausencia</option>

                @foreach($ausentes as $ausente)

                    <option value="{{ $ausente->id }}">
                        {{ \Carbon\Carbon::parse($ausente->fecha)->format('d/m/Y') }} - Ausente
                    </option>

                @endforeach

            </select>
        </div>

        <!-- MOTIVO -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">
                Motivo de la justificación
            </label>

            <textarea
                name="motivo"
                rows="5"
                class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                placeholder="Escribe el motivo..."
                required
            ></textarea>
        </div>

        <!-- BOTONES A LA PAR -->
        <div class="flex gap-3">

            <a href="{{ route('dashboard') }}"
            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded-lg text-center transition">
                Cancelar
            </a>

            <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
                Enviar
            </button>

        </div>

    </form>

</div>

@endsection