<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | SIGAE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-950 flex items-center justify-center min-h-screen px-4">

    <!-- CONTENEDOR GENERAL -->
    <div class="w-full max-w-xs sm:max-w-md mx-auto">

        <!-- TITULO -->
        <div class="text-center mb-4 sm:mb-6">
            <h1 class="text-5xl sm:text-6xl font-extrabold text-white tracking-tight sm:tracking-[0.35em] text-center">
                SIGAE
            </h1>
            <p class="text-white text-sm sm:text-base mt-1 sm:mt-2 text-center tracking-tight sm:tracking-[0.11em] uppercase">
                Sistema Integral de Gestión Académica Escolar
            </p>
        </div>

        <!-- CARD LOGIN -->
        <div class="bg-white shadow-2xl rounded-2xl p-5 sm:p-8">

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
            <form method="POST" action="/login" class="space-y-3 sm:space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input 
                        type="email" 
                        name="email" 
                        required
                        class="w-full mt-1 px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-900 focus:outline-none transition"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input 
                        type="password" 
                        name="password" 
                        required
                        class="w-full mt-1 px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-900 focus:outline-none transition"
                    >
                </div>

                <button 
                    type="submit"
                    class="w-full bg-blue-900 hover:bg-blue-800 text-white py-2 rounded-xl transition duration-200 font-semibold shadow-md text-sm sm:text-base"
                >
                    Ingresar
                </button>
            </form>

            <!-- Footer -->
            <div class="text-center mt-4 sm:mt-6 text-xs sm:text-sm text-gray-400">
                © {{ date('Y') }} SIGAE - Proyecto Académico
            </div>

        </div>
    </div>

</body>
</html>