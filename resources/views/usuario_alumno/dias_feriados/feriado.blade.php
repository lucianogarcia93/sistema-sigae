@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        Feriados Institucionales
    </h1>

    <table class="w-full text-sm">

        <thead class="bg-blue-600 text-white uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Fecha</th>
                <th class="px-6 py-3 text-left">Descripción</th>
            </tr>
        </thead>

        <tbody>

            @forelse($feriados as $feriado)

            <tr class="border-b hover:bg-gray-50">
                
                <td class="px-6 py-3">
                    {{ \Carbon\Carbon::parse($feriado->fecha)->format('d/m/Y') }}
                </td>

                <td class="px-6 py-3">
                    {{ $feriado->nombre }}
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="2" class="text-center py-6 text-gray-500">
                    No hay feriados registrados
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

    <!-- BOTON VOLVER -->
    <div class="mt-6 flex justify-end">
        <a href="{{ url()->previous() }}"
        class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg text-sm">
            Volver atrás
        </a>
    </div>

</div>

@endsection