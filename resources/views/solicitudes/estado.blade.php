<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Solicitud</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100">

<div class="w-full max-w-xl bg-white p-6 rounded-2xl shadow-xl border border-gray-200">

    <!-- HEADER -->
    <div class="text-center mb-5">
        <h1 class="text-2xl font-bold text-gray-800">📄 Estado de Solicitud</h1>
        <p class="text-gray-500 text-sm mt-1">
            {{ $solicitud->nombre }} {{ $solicitud->apellido }}
        </p>
    </div>

    <!-- ESTADO -->
    @if($solicitud->estado == 'pendiente')
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            <h2 class="font-bold text-lg">⏳ En revisión</h2>
            <p class="text-sm mt-1">Tu solicitud aún no fue aprobada por el administrador.</p>
        </div>

    @elseif($solicitud->estado == 'aprobado')
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <h2 class="font-bold text-lg">✅ Solicitud aprobada</h2>
            <p class="text-sm mt-1">Ya podés acceder al sistema con tus credenciales.</p>
        </div>

        <!-- DATOS -->
        <div class="mt-4 bg-gray-50 p-4 rounded-lg border">
            <p><strong>Usuario:</strong> {{ $solicitud->email }}</p>
            <p><strong>Contraseña:</strong> {{ $solicitud->password_temporal }}</p>
        </div>

        <p class="mt-3 text-sm text-gray-600">
            ⚠️ Se recomienda cambiar la contraseña al iniciar sesión.
        </p>

        <a href="/login"
           class="block text-center mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
            Ir al login
        </a>

    @elseif($solicitud->estado == 'rechazado')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <h2 class="font-bold text-lg">❌ Solicitud rechazada</h2>

            @if($solicitud->motivo_rechazo)
                <p class="text-sm mt-1">
                    <strong>Motivo:</strong> {{ $solicitud->motivo_rechazo }}
                </p>
            @else
                <p class="text-sm mt-1">Tu solicitud fue rechazada.</p>
            @endif
        </div>
    @endif

</div>

</body>
</html>