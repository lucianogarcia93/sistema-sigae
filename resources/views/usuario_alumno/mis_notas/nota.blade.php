@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        Mis Calificaciones
    </h1>

    <table class="w-full text-sm">

        <thead class="bg-blue-600 text-white uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Materia</th>
                <th class="px-6 py-3 text-left">Tipo</th>
                <th class="px-6 py-3 text-left">Nota</th>
                <th class="px-6 py-3 text-left">Fecha</th>
            </tr>
        </thead>

        <tbody>

            @forelse($notas as $nota)

            <tr class="border-b hover:bg-gray-50">
                
                <!-- MATERIA -->
                <td class="px-6 py-3">
                    {{ $nota->materiaCurso->materia->nombre }}
                </td>

                <!-- TIPO -->
                <td class="px-6 py-3">
                    {{ ucfirst($nota->tipo) }}
                </td>

                <!-- NOTA -->
                <td class="px-6 py-3 font-semibold
                    {{ $nota->nota < 6 ? 'text-red-600' : 'text-green-600' }}">
                    {{ $nota->nota }}
                </td>

                <!-- FECHA -->
                <td class="px-6 py-3">
                    {{ \Carbon\Carbon::parse($nota->fecha)->format('d/m/Y') }}
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="4" class="text-center py-6 text-gray-500">
                    No tenés calificaciones cargadas
                </td>
            </tr>

            @endforelse

        </tbody>
        
    </table>

    <!-- BOTON VOLVER -->
    <div class="mt-6 flex justify-end">
        <a href="{{ route('dashboard') }}"
        class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg text-sm">
            Volver al panel
        </a>
    </div>

</div>

@endsection