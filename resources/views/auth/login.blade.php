<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | SIGAE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-950 flex items-center justify-center min-h-screen px-4">

    <!-- CONTENEDOR GENERAL -->
    <div class="w-full sm:max-w-lg mx-auto px-4 sm:px-6">

        <!-- TITULO -->
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="text-6xl sm:text-6xl font-extrabold text-white leading-tight tracking-tight sm:tracking-[0.35em]">
                SIGAE
            </h1>
            <!-- Siempre debajo de SIGAE -->
            <p class="text-white text-sm sm:text-base mt-2 sm:mt-3 leading-snug sm:leading-normal text-center tracking-tight sm:tracking-[0.11em] uppercase">
                Sistema Integral de Gestión Académica Escolar
            </p>
        </div>

        <!-- CARD LOGIN -->
        <div class="bg-white shadow-2xl rounded-2xl p-5 sm:p-8 min-h-[60vh] sm:min-h-[50vh] flex flex-col justify-center">

            <!-- Errores -->
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-3 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-500 text-white p-3 sm:p-4 rounded-xl mb-4 text-center text-sm sm:text-base">
                    {{ session('success') }}
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="/login" class="space-y-4 sm:space-y-5 flex flex-col justify-center h-full">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input 
                        type="email" 
                        name="email" 
                        required
                        class="w-full sm:w-full px-3 py-3 sm:px-4 sm:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-900 focus:outline-none transition"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input 
                        type="password" 
                        name="password" 
                        required
                        class="w-full sm:w-full px-3 py-3 sm:px-4 sm:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-900 focus:outline-none transition"
                    >
                </div>

                <button 
                    type="submit"
                    class="w-full bg-blue-900 hover:bg-blue-800 text-white py-3 sm:py-3 rounded-xl transition duration-200 font-semibold shadow-md text-base sm:text-base"
                >
                    Ingresar
                </button>
            </form>

            <!-- Footer -->
            <div class="text-center mt-6 sm:mt-8 text-xs sm:text-sm text-gray-400">
                © {{ date('Y') }} SIGAE - Proyecto Académico
            </div>

        </div>

    </div>

</body>
</html>