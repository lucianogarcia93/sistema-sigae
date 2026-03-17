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

@endsection
