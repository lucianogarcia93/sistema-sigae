@extends('layouts.dashboard')

@section('content')

<div class="max-w-xl mx-auto mt-10">

    <div class="bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            🔒 Cambiar Contraseña
        </h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('alumno.password.update') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">
                    Contraseña Actual
                </label>

                <input type="password"
                       name="current_password"
                       class="w-full border rounded-lg p-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">
                    Nueva Contraseña
                </label>

                <input type="password"
                       name="password"
                       class="w-full border rounded-lg p-2"
                       required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-1">
                    Confirmar Nueva Contraseña
                </label>

                <input type="password"
                       name="password_confirmation"
                       class="w-full border rounded-lg p-2"
                       required>
            </div>

            <!-- BOTONES A LA PAR -->
            <div class="flex gap-3">

                <a href="{{ route('dashboard') }}"
                   class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded-lg text-center transition">
                    Cancelar
                </a>

                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
                    Modificar Contraseña
                </button>

            </div>

        </form>

    </div>

</div>

@endsection