@extends('layouts.dashboard')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            ✏️ Editar Alumno
        </h1>
    </div>

    <!-- ERRORES -->
    @if ($errors->any())

        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">

            <ul class="list-disc pl-5 text-sm">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <!-- FORMULARIO -->
    <div class="bg-white shadow rounded-xl p-6">

        <form action="{{ route('academica.alumnos.update', $alumno) }}" method="POST">

            @csrf
            @method('PUT')

            <!-- NOMBRE -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Nombre
                </label>

                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $alumno->nombre) }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <!-- APELLIDO -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Apellido
                </label>

                <input type="text"
                       name="apellido"
                       value="{{ old('apellido', $alumno->apellido) }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <!-- EMAIL -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Email
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email', $alumno->email) }}"
                       placeholder="Email (opcional)"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- DNI -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    DNI
                </label>

                <input type="text"
                       name="dni"
                       value="{{ old('dni', $alumno->dni) }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <!-- FECHA NACIMIENTO -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Año Escolar
                </label>

                <select name="anio"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    
                    @foreach([2026, 2027] as $year)
                        <option value="{{ $year }}"
                            {{ old('anio', $alumno->anio) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- CURSO -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Curso
                </label>

                <select name="curso_id"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                        required>

                    @foreach($cursos as $curso)

                        <option value="{{ $curso->id }}"
                            {{ $alumno->curso_id == $curso->id ? 'selected' : '' }}>

                            {{ $curso->nivel->nombre }} - {{ $curso->division }}

                        </option>

                    @endforeach

                </select>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('academica.alumnos.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    Cancelar
                </a>

                <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-800 hover:scale-105 transition transform text-white px-5 py-2 rounded-xl shadow-lg">
                    Actualizar
                </button>
            </div>

        </form>

    </div>

</div>

@endsection