<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | SIGAE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-950 flex items-center justify-center min-h-screen px-2">

    <!-- CONTENEDOR TITULO -->
    <div class="w-full max-w-md mb-6 text-center">
        <h1 class="text-5xl sm:text-6xl font-extrabold text-white tracking-[0.35em]">
            SIGAE
        </h1>
        <p class="text-white text-xs sm:text-sm mt-2 tracking-[0.11em] uppercase">
            Sistema Integral de Gestión Académica Escolar
        </p>
    </div>

    <!-- CARD LOGIN -->
    <div class="bg-white shadow-2xl rounded-2xl p-6 sm:p-8 w-full max-w-md mx-2">

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-xl mb-6 text-center text-sm sm:text-base">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-4 sm:space-y-5">
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

        <div class="text-center mt-6 text-xs sm:text-sm text-gray-400">
            © {{ date('Y') }} SIGAE - Proyecto Académico
        </div>

    </div>

</body>
</html>