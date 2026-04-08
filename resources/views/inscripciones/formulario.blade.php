<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción al curso</title>

    <!-- 🔥 CLAVE: sin zoom -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 px-4">

<div class="w-full sm:max-w-xl md:max-w-2xl mx-auto px-2 sm:px-4">

    <!-- HEADER -->
    <div class="text-center mt-6 sm:mt-8 mb-6 sm:mb-8">
        <h1 class="text-4xl sm:text-4xl font-bold text-gray-800 mb-2">
            Formulario de Inscripción
        </h1>

        <p class="text-gray-600 text-sm sm:text-base">
            {{ $curso->nivel->nombre }} - Curso {{ $curso->division }} - {{ $curso->turno }}
        </p>
    </div>

    <!-- CARD -->
    <div class="bg-white shadow-2xl rounded-2xl p-5 sm:p-8 min-h-[65vh] sm:min-h-[50vh] flex flex-col justify-center border border-gray-200">

        <!-- SUCCESS -->
        @if(session('success') && session('token'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                <p>✅ Tu solicitud de inscripción fue enviada correctamente.</p>

                <p class="mt-2">
                    Guardá este enlace:
                </p>

                <p class="mt-1 break-all text-blue-600">
                    <a href="{{ route('solicitud.estado', session('token')) }}" class="underline">
                        {{ route('solicitud.estado', session('token')) }}
                    </a>
                </p>

                <p class="mt-2 text-xs text-gray-500">
                    Este enlace es único. Guardalo para consultar el estado.
                </p>
            </div>
        @endif

        <!-- ERROR -->
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-3 text-sm">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <!-- VALIDACIONES -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 p-3 mb-3 rounded text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('academica.cursos.inscripcion.store', $curso) }}" method="POST"
              class="space-y-4 sm:space-y-5 flex flex-col justify-center h-full">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required
                    class="w-full px-3 py-3 sm:px-4 sm:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                <input type="text" name="apellido" value="{{ old('apellido') }}" required
                    class="w-full px-3 py-3 sm:px-4 sm:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
                <input type="text" name="dni" value="{{ old('dni') }}" required
                    class="w-full px-3 py-3 sm:px-4 sm:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Fecha de Nacimiento
                </label>
                <input type="text" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                    placeholder="Ej: 25/12/2000"
                    class="w-full px-3 py-3 sm:px-4 sm:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-3 sm:px-4 sm:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                <select name="anio" required
                    class="w-full px-3 py-3 sm:px-4 sm:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Seleccione año</option>
                    @for ($i = date('Y'); $i <= date('Y')+1; $i++)
                        <option value="{{ $i }}" {{ old('anio') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <button type="submit"
                class="w-full bg-blue-900 hover:bg-blue-800 text-white py-3 rounded-xl font-semibold shadow-md transition text-base">
                Enviar inscripción
            </button>

        </form>

    </div>

</div>

</body>
</html>