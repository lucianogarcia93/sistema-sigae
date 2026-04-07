<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción al curso</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100">

<div class="w-full max-w-2xl bg-white p-6 rounded-2xl shadow-xl border border-gray-200">

    <!-- HEADER -->
    <div class="text-center mb-5">
        <h1 class="text-3xl font-bold text-gray-800 mb-1">🎓 Inscripción de Alumno</h1>
        <p class="text-gray-500 text-sm">{{ $curso->nivel->nombre }} - Curso {{ $curso->division }}</p>
    </div>

    <!-- Mensajes de sesión -->
    @if(session('success') && session('token'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <p>✅ Tu solicitud de inscripción fue enviada correctamente.</p>
            
            <p class="mt-2">
                Para seguir las actualizaciones de tu inscripción, <strong>guardá este enlace</strong>:
            </p>

            <!-- Link clickeable y visible para copiar -->
            <p class="mt-1 text-sm text-gray-700 break-all">
                <a href="{{ route('academica.solicitud.estado', session('token')) }}" 
                class="underline text-blue-600 hover:text-blue-800">
                {{ route('academica.solicitud.estado', session('token')) }}
                </a>
            </p>

            <!-- Explicación adicional -->
            <p class="mt-2 text-sm text-gray-500">
                Este enlace es único y privado. Guardalo en un lugar seguro para consultar el estado de tu solicitud cuando quieras.
            </p>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center bg-red-100 border border-red-400 text-red-700 px-3 py-1.5 rounded mb-3 text-sm">
            <span class="mr-2">⚠️</span> {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 p-2 mb-3 rounded text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM -->
    <form action="{{ route('academica.cursos.inscripcion.store', $curso) }}" method="POST" class="space-y-2.5">
        @csrf

        <div>
            <label class="block font-semibold text-gray-700 mb-0.5 text-sm">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-1.5 focus:ring-2 focus:ring-blue-300 focus:outline-none transition text-sm">
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-0.5 text-sm">Apellido</label>
            <input type="text" name="apellido" value="{{ old('apellido') }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-1.5 focus:ring-2 focus:ring-blue-300 focus:outline-none transition text-sm">
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-0.5 text-sm">DNI</label>
            <input type="text" name="dni" value="{{ old('dni') }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-1.5 focus:ring-2 focus:ring-blue-300 focus:outline-none transition text-sm">
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-0.5 text-sm">
                Fecha de Nacimiento (DD/MM/AAAA)
            </label>
            <input type="text" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                placeholder="Ej: 25/12/2000"
                class="w-full border border-gray-300 rounded-lg px-4 py-1.5 focus:ring-2 focus:ring-blue-300 focus:outline-none transition text-sm">
        </div>
        
        <div>
            <label class="block font-semibold text-gray-700 mb-0.5 text-sm">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-1.5 focus:ring-2 focus:ring-blue-300 focus:outline-none transition text-sm">
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-0.5 text-sm">Año</label>
            <select name="anio" required
                class="w-full border border-gray-300 rounded-lg px-4 py-1.5 focus:ring-2 focus:ring-blue-300 focus:outline-none transition text-sm">
                <option value="">Seleccione año</option>
                @for ($i = date('Y'); $i <= date('Y')+1; $i++)
                    <option value="{{ $i }}" {{ old('anio') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold py-2 rounded-lg hover:from-blue-700 hover:to-blue-600 shadow-md transition text-sm">
            Enviar inscripción
        </button>
    </form>
</div>

</body>
</html>