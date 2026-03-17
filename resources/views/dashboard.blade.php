@extends('layouts.dashboard')

@section('content')

<div class="max-w-5xl mx-auto">

@if(Auth::user()->role->name === 'admin')

    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl shadow-xl p-8 mb-8">

        <h2 class="text-4xl font-bold">
            👋 Bienvenido, {{ Auth::user()->name }}
        </h2>

        <p class="mt-3 text-blue-100">
            Panel principal del sistema SIGAE - Administrador
        </p>
    </div>

@endif


@if(Auth::user()->role->name === 'alumno')

    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white rounded-2xl shadow-xl p-8 mb-8">

        <h2 class="text-4xl font-bold">
            👋 Bienvenido Alumno, {{ Auth::user()->name }}
        </h2>

        <p class="mt-3 text-green-100">
            Panel de alumno del sistema SIGAE
        </p>
    </div>

@endif

</div>

@endsection