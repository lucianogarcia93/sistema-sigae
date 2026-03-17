@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Resumen General
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Asistencias del mes -->
        <div class="bg-blue-50 border border-blue-200 p-6 rounded-xl text-center">
            <p class="text-sm text-gray-600">
                Asistencias del mes
            </p>
            <p class="text-3xl font-bold text-blue-600 mt-2">
                {{ $asistenciasMes }}
            </p>
        </div>

        <!-- Porcentaje de asistencia -->
        <div class="bg-green-50 border border-green-200 p-6 rounded-xl text-center">
            <p class="text-sm text-gray-600">
                Porcentaje de asistencia
            </p>
            <p class="text-3xl font-bold text-green-600 mt-2">
                {{ $porcentaje }}%
            </p>
        </div>

        <!-- Última clase registrada -->
        <div class="bg-green-50 border border-green-200 p-6 rounded-xl text-center">
            <p class="text-sm text-gray-600">
                Última clase registrada
            </p>
            <p class="text-xl font-semibold mt-2 text-gray-800 leading-snug">
                @if($ultima)
                    {{ \Carbon\Carbon::parse($ultima->fecha)->format('d/m/Y') }}
                    <span class="text-sm text-gray-500">
                        ({{ ucfirst($ultima->estado) }})
                    </span>
                @else
                    Sin registros
                @endif
            </p>
        </div>

    </div>

    <!-- BOTON VOLVER -->
    <div class="mt-8 flex justify-end">
        <a href="{{ url()->previous() }}"
           class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg text-sm">
            Volver atrás
        </a>
    </div>

</div>

@endsection