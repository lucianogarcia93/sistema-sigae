@extends('layouts.dashboard')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📬 Solicitudes de Inscripción</h1>
            <p class="text-gray-500 text-sm">Gestión de solicitudes pendientes de aprobación</p>
        </div>
    </div>

    <!-- MENSAJES DEL SISTEMA -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

    <!-- BUSCADOR -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <form method="GET" action="{{ route('academica.solicitudes.index') }}">
            <div class="flex gap-3">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="🔎 Buscar solicitud..."
                       class="w-full border rounded-lg px-4 py-2">

                <button type="submit"
                        class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg">
                    Buscar
                </button>
            </div>
        </form>
    </div>

    <!-- TABLA -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="min-w-full text-sm">
            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Apellido</th>
                    <!--<th class="px-6 py-3 text-left">DNI</th>-->
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Curso</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">

                @forelse($solicitudes as $s)
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4">{{ $s->nombre }}</td>
                    <td class="px-6 py-4">{{ $s->apellido }}</td>
                    <!--<td class="px-6 py-4">{{ $s->dni }}</td>-->
                    <td class="px-6 py-4">{{ $s->email }}</td>
                    <td class="px-6 py-4">{{ optional($s->curso)->division ?? '-' }} - {{ optional($s->curso->nivel)->nombre ?? '-' }}</td>

                    <!-- ESTADO -->
                    <td class="px-6 py-4">
                        @if($s->estado == 'pendiente')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">Pendiente</span>
                        @elseif($s->estado == 'aprobado')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Aprobado</span>
                        @elseif($s->estado == 'rechazado')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Rechazado</span>
                        @endif
                    </td>

                    <!-- ACCIONES -->
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 items-center">

                            @if($s->estado == 'pendiente')
                            <!-- Aprobar -->
                            <form action="{{ route('academica.solicitudes.aprobar', $s->id) }}" method="POST">
                                @csrf
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-xs">
                                    Aprobar
                                </button>
                            </form>

                            <!-- Rechazar con motivo -->
                            <form action="{{ route('academica.solicitudes.rechazar', $s->id) }}" method="POST" class="flex items-center gap-1">
                                @csrf
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs">
                                    Rechazar
                                </button>

                                <input type="text" name="motivo_rechazo"
                                    placeholder="Motivo (opcional)"
                                    class="border px-2 py-1 rounded text-xs"
                                >
                            </form>
                            @endif

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-400">
                        No hay solicitudes pendientes.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>

    </div>

    <div class="mt-6 flex justify-center">
        {{ $solicitudes->links() }}
    </div>

</div>

@endsection