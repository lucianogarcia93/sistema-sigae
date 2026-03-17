@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

    <table class="w-full text-sm">

        <thead class="bg-blue-600 text-white uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Fecha</th>
                <th class="px-6 py-3 text-left">Motivo</th>
                <th class="px-6 py-3 text-center">Estado</th>
            </tr>
        </thead>

        <tbody class="divide-y border-b">

            @forelse($justificaciones as $justificacion)

                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($justificacion->created_at)->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $justificacion->motivo }}
                    </td>

                    <td class="px-6 py-4 text-center font-semibold">

                        @if($justificacion->estado == 'aprobado')
                            <span class="text-green-600">Aprobada</span>

                        @elseif($justificacion->estado == 'rechazado')
                            <span class="text-red-600">Rechazada</span>

                        @else
                            <span class="text-yellow-500">Pendiente</span>
                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="3" class="text-center p-6 text-gray-500">
                        No tienes justificaciones registradas
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

    <!-- BOTON VOLVER ATRAS FUERA DEL TABLE -->
    <div class="mt-6 flex justify-end">
        <a href="{{ url()->previous() }}"
        class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg text-sm">
            Volver atrás
        </a>
    </div>

</div>

@endsection