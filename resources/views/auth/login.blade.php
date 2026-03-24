<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | SIGAE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-950 flex flex-col items-center justify-center min-h-screen">

    <!-- CONTENEDOR TITULO -->
    <div class="w-full max-w-md mb-8 text-center">

        <h1 class="w-full text-6xl font-extrabold text-white tracking-[0.35em]">
            SIGAE
        </h1>

        <p class="w-full text-white text-sm mt-4 tracking-[0.11em] uppercase">
            Sistema Integral de Gestión Académica Escolar
        </p>

    </div>

    <!-- CARD LOGIN -->
    <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md">

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-xl mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Ingresar Correo Electronico</label>
                <input 
                    type="email" 
                    name="email" 
                    required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-900 focus:outline-none transition"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Ingresar Contraseña</label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-900 focus:outline-none transition"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-blue-900 hover:bg-blue-800 text-white py-2 rounded-xl transition duration-200 font-semibold shadow-md"
            >
                Ingresar
            </button>
        </form>

        <div class="text-center mt-6 text-xs text-gray-400">
            © {{ date('Y') }} SIGAE - Proyecto Académico
        </div>

    </div>

</body>
</html>