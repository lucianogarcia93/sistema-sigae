<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción al curso</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold text-gray-800 mb-2">
        Inscripción de Alumno
    </h1>

    <p class="text-gray-500 mb-6">
        {{ $curso->nivel->nombre }} - Curso {{ $curso->division }}
    </p>

    {{-- Mensajes de sesión --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            ⚠️ {{ session('error') }}
        </div>
    @endif
    {{-- Fin mensajes de sesión --}}

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('academica.cursos.inscripcion.store', $curso) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="font-semibold text-gray-700">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">
        </div>

        <div class="mb-3">
            <label class="font-semibold text-gray-700">Apellido</label>
            <input type="text" name="apellido" value="{{ old('apellido') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">
        </div>

        <div class="mb-3">
            <label class="font-semibold text-gray-700">DNI</label>
            <input type="text" name="dni" value="{{ old('dni') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">
        </div>

        <div class="mb-4">
            <label class="font-semibold text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Año</label>
            <select name="anio" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                <option value="">Seleccione año</option>
                @for ($i = date('Y'); $i <= date('Y')+1; $i++)
                    <option value="{{ $i }}" {{ old('anio') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Enviar inscripción
        </button>

    </form>

</div>

</body>
</html>