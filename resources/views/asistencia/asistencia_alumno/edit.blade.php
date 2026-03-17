@extends('layouts.dashboard')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            ✏️ Editar Asistencia - {{ $curso->division }}
        </h1>
        <p class="text-gray-500 text-sm">
            Fecha: {{ $fecha }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="min-w-full text-sm">

            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left w-20">#</th>
                    <th class="px-6 py-3 text-left">Apellido</th>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-center w-40">Asistencia</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @foreach($asistencias as $asistencia)

                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4 align-middle w-20">
                        #{{ $asistencia->alumno->id }}
                    </td>

                    <td class="px-6 py-4 align-middle">
                        {{ $asistencia->alumno->apellido }}
                    </td>

                    <td class="px-6 py-4 align-middle">
                        {{ $asistencia->alumno->nombre }}
                    </td>

                    <td class="px-6 py-4 text-center align-middle w-40">
                        <span class="inline-block font-semibold">
                            {{ ucfirst($asistencia->estado) }}
                        </span>
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="mt-6 flex justify-end gap-2">
        <a href="{{ route('asistencia.asistencia_alumno.index') }}" 
            class="bg-gray-500 text-white px-5 py-2 rounded-lg transition">
            Volver Atras
        </a>
    </div>

</div>

@endsection