@extends('layouts.dashboard')

@section('content')

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">
    <!-- Header Perfil -->
    <div class="bg-sky-100 text-black border-b border-sky-200 p-6 text-center rounded-t-2xl">
        <h2 class="text-2xl font-bold">
            Datos Personales
        </h2>
    </div>

    <!-- Datos -->
    <div class="p-8 space-y-6">

        <!-- Nombre -->
        <div class="border-b pb-4">
            <p class="text-sm text-gray-500">Nombre y Apellido</p>
            <p class="text-lg font-semibold text-gray-800 mt-1">
                {{ $alumno->nombre ?? '' }} {{ $alumno->apellido ?? '' }}
            </p>
        </div>

        <!-- DNI -->
        <div class="border-b pb-4">
            <p class="text-sm text-gray-500">DNI</p>
            <p class="text-lg font-semibold text-gray-800 mt-1">
                {{ $alumno->dni ?? 'Sin DNI' }}
            </p>
        </div>

        <!-- Email -->
        <div class="border-b pb-4">
            <p class="text-sm text-gray-500">Email</p>
            <p class="text-lg font-semibold text-gray-800 mt-1">
                {{ $alumno->email ?? 'Sin email' }}
            </p>
        </div>

        <!-- Curso -->
        <div class="border-b pb-4">
            <p class="text-sm text-gray-500">Nivel - Curso</p>
            <p class="text-lg font-semibold text-gray-800 mt-1">
                {{ $alumno->curso->nivel->nombre ?? 'Sin nivel' }} - {{ $alumno->curso->division ?? 'Sin curso' }}
            </p>
        </div>

        <!-- Estado -->
        <div>
            <p class="text-sm text-gray-500">Estado</p>
            <p class="text-lg font-semibold mt-1 {{ $alumno->activo ? 'text-green-600' : 'text-red-600' }}">
                {{ $alumno->activo ? 'Activo' : 'Inactivo' }}
            </p>
        </div>

    </div>

    <!-- Footer Botón -->
    <div class="bg-gray-50 px-8 py-6 flex justify-end border-t">
        <a href="{{ url()->previous() }}"
           class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-xl text-sm transition">
            Volver atrás
        </a>
    </div>

</div>

@endsection
