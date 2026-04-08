<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Solicitud</title>

    <!-- 🔥 sin zoom -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 px-4">

<div class="w-full sm:max-w-lg mx-auto px-2 sm:px-4">

    <!-- HEADER -->
    <div class="text-center mb-6 sm:mb-8">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">
            📄 Estado de Solicitud
        </h1>

        <p class="text-gray-600 text-sm sm:text-base mt-2">
            {{ $solicitud->nombre }} {{ $solicitud->apellido }}
        </p>
    </div>

    <!-- CARD -->
    <div class="bg-white shadow-2xl rounded-2xl p-5 sm:p-8 min-h-[60vh] sm:min-h-[50vh] flex flex-col justify-center border border-gray-200">

        @if($solicitud->estado == 'pendiente')
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-4 rounded text-sm sm:text-base">
                <h2 class="font-bold text-lg sm:text-xl">⏳ En revisión</h2>
                <p class="mt-2">Tu solicitud aún no fue aprobada por el administrador.</p>
            </div>

        @elseif($solicitud->estado == 'aprobado')
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-4 rounded text-sm sm:text-base">
                <h2 class="font-bold text-lg sm:text-xl">✅ Solicitud aprobada</h2>
                <p class="mt-2">Ya podés acceder al sistema con tus credenciales.</p>
            </div>

            <!-- DATOS -->
            <div class="mt-4 bg-gray-50 p-4 rounded-lg border text-sm sm:text-base">
                <p><strong>Usuario:</strong> {{ $solicitud->email }}</p>
                <p><strong>Contraseña:</strong> {{ $solicitud->password_temporal }}</p>
            </div>

            <p class="mt-3 text-sm text-gray-600">
                ⚠️ Se recomienda cambiar la contraseña al iniciar sesión.
            </p>

            <a href="/login"
               class="block text-center mt-5 bg-blue-900 hover:bg-blue-800 text-white px-4 py-3 rounded-xl shadow font-semibold">
                Ir al login
            </a>

        @elseif($solicitud->estado == 'rechazado')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-4 rounded text-sm sm:text-base">
                <h2 class="font-bold text-lg sm:text-xl">❌ Solicitud rechazada</h2>

                @if($solicitud->motivo_rechazo)
                    <p class="mt-2">
                        <strong>Motivo:</strong> {{ $solicitud->motivo_rechazo }}
                    </p>
                @else
                    <p class="mt-2">Tu solicitud fue rechazada.</p>
                @endif
            </div>
        @endif

    </div>

</div>

</body>
</html>