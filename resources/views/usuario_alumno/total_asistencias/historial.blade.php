@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-6 rounded-xl shadow space-y-5">

    <!-- TITULO -->
    <h1 class="text-2xl font-bold text-gray-800">
        Ver Asistencias
    </h1>

    <!-- FILTRO POR MES -->
    <form method="GET" class="flex items-center gap-3">

        <label class="font-semibold text-gray-700">
            Filtrar por mes:
        </label>

        <input
            type="month"
            name="mes"
            value="{{ $mes ?? '' }}"
            class="border rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
        >

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg text-sm transition"
        >
            Filtrar
        </button>

    </form>

    <!-- TABLA HISTORIAL -->
    <div class="overflow-x-auto border rounded-lg">

        <table class="w-full text-sm">

            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                </tr>
            </thead>

            <tbody>

                @forelse($asistencias as $asistencia)

                <tr class="border-b hover:bg-gray-50">

                    <!-- FECHA -->
                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                    </td>

                    <!-- ESTADO -->
                    <td class="px-4 py-3">

                        @if($asistencia->estado == 'presente')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                Presente
                            </span>

                        @elseif($asistencia->estado == 'ausente')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                Ausente
                            </span>

                        @elseif($asistencia->estado == 'justificada' || $asistencia->estado == 'justificado')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                Justificada
                            </span>
                        @endif

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="2" class="text-center text-gray-500 py-6">
                        No hay asistencias registradas
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- BOTON VOLVER ATRAS FUERA DEL TABLE -->
    <div class="mt-6 flex justify-end">
        <a href="{{ route('dashboard') }}"
        class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg text-sm">
            Volver atrás
        </a>
    </div>

</div>

@endsection