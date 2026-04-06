@extends('layouts.dashboard')

@section('content')

<div class="max-w-xl mx-auto text-center">

    <h1 class="text-2xl font-bold mb-4">
        Codigo QR de inscripción
    </h1>

    <p class="mb-4">
        Curso: {{ $curso->nivel->nombre }} {{ $curso->division }}
    </p>

    <div class="flex justify-center">
        {!! QrCode::size(250)->generate(route('academica.cursos.inscripcion.form', $curso->id)) !!}
    </div>

    <p class="mt-4 text-gray-500 text-sm">
        Escanea este código para inscribirte al curso.
    </p>

</div>

<div class="flex justify-end mt-10">
    <a href="{{ route('academica.cursos.index') }}" 
       class="bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700">
        Volver atrás
    </a>
</div>

@endsection
