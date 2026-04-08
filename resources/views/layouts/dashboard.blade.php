<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAE Dashboard</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS -->
    <script defer src="https://unpkg.com/alpinejs"></script>

    <style>
        .sidebar-mini .menu-text {
            opacity: 0;
        }
    </style>
</head>

<body class="bg-gray-100">

@php
    $user = auth()->user();
@endphp

{{-- ================= ADMIN LAYOUT ================= --}}
@if($user && $user->role && $user->role->name === 'admin')

<div class="flex flex-col md:flex-row min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed md:static top-0 left-0 h-full md:h-auto
                w-64 bg-blue-700 text-white p-4 md:p-6 space-y-6
                transition-all duration-300 overflow-hidden
                translate-x-0">

        <!-- HEADER -->
        <div class="flex items-center gap-3">

            <button id="toggleSidebar"
                    class="p-2 rounded-lg hover:bg-blue-600 transition text-xl">
                ☰
            </button>

            <h1 class="text-sm font-bold tracking-wide whitespace-nowrap menu-text">
                Panel De Control
            </h1>

        </div>

        <!-- NAV -->
        <nav class="space-y-3 text-sm"
            x-data="{
                openMenu: '{{ request()->is('academica/*') ? 'academica' :
                            (request()->is('asistencia/*') ? 'asistencia' :
                            (request()->is('calendario/*') ? 'calendario' :
                            (request()->is('reportes/*') ? 'reportes' : ''))) }}'
            }">

            <!-- ACADÉMICA -->
            <div>
                <button @click="openMenu = openMenu === 'academica' ? '' : 'academica'"
                        class="w-full text-left px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                    <span class="menu-text">📚 Gestión Académica</span>
                </button>

                <div x-show="openMenu === 'academica'" class="ml-0 md:ml-4 space-y-2 mt-2">
                    <a href="{{ route('academica.niveles.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">🎓 Niveles</a>
                    <a href="{{ route('academica.cursos.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">📖 Cursos</a>
                    <a href="{{ route('academica.alumnos.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">👨‍🎓 Alumnos</a>
                    <a href="{{ route('academica.materias.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">📚 Materias</a>
                    <a href="{{ route('academica.profesores.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">👨‍🏫 Profesores</a>
                    <a href="{{ route('academica.solicitudes.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">📬 Solicitudes</a>
                </div>
            </div>

            <!-- ASISTENCIAS -->
            <div>
                <button @click="openMenu = openMenu === 'asistencia' ? '' : 'asistencia'"
                        class="w-full text-left px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                    <span class="menu-text">🕒 Registro Asistencias</span>
                </button>

                <div x-show="openMenu === 'asistencia'" class="ml-0 md:ml-4 space-y-2 mt-2">
                    <a href="{{ route('asistencia.asistencia_alumno.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">📌 Asistencia Alumnos</a>
                </div>
            </div>

            <!-- CALENDARIO -->
            <div>
                <button @click="openMenu = openMenu === 'calendario' ? '' : 'calendario'"
                        class="w-full text-left px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                    <span class="menu-text">📅 Calendario Académico</span>
                </button>

                <div x-show="openMenu === 'calendario'" class="ml-0 md:ml-4 space-y-2 mt-2">
                    <a href="{{ route('calendario.feriados.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">🎉 Feriados - Sin clases</a>
                    <a href="{{ route('calendario.justificaciones.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">📝 Justificaciones</a>
                    <a href="{{ route('calendario.calificaciones.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">🅰️ Calificaciones</a>
                </div>
            </div>

            <!-- REPORTES -->
            <div>
                <button @click="openMenu = openMenu === 'reportes' ? '' : 'reportes'"
                        class="w-full text-left px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                    <span class="menu-text">📊 Reportes</span>
                </button>

                <div x-show="openMenu === 'reportes'" class="ml-0 md:ml-4 space-y-2 mt-2">
                    <a href="{{ route('reportes.generales') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">📈 Reportes Generales</a>
                    <a href="{{ route('reportes.excel') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">📈 Exportar Excel</a>
                    <a href="{{ route('reportes.alumnos.estadistica') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap menu-text">📄 Alumnos PDF</a>
                </div>
            </div>

        </nav>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}" class="pt-4 md:pt-6">
            @csrf
            <button class="w-full bg-red-500 hover:bg-red-600 py-2 rounded-lg transition whitespace-nowrap menu-text">
                Cerrar sesión
            </button>
        </form>

    </aside>

    <!-- BOTÓN MOBILE -->
    <button id="openSidebarMobile"
            class="md:hidden fixed top-4 left-4 z-50 bg-blue-700 text-white p-2 rounded-lg shadow">
        ☰
    </button>

    <!-- MAIN -->
    <main class="flex-1 w-full md:ml-0 p-4 md:p-10 overflow-auto">
        @yield('content')
    </main>

</div>

@endif

{{-- ================= ALUMNO LAYOUT ================= --}}
@if($user && $user->role && $user->role->name === 'alumno')

<div class="min-h-screen bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700">

    <!-- LOGOUT -->
    <div class="flex justify-end p-4 md:p-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 text-white px-4 md:px-5 py-2 rounded-lg shadow">
                Cerrar sesión
            </button>
        </form>
    </div>

    <div class="text-center mb-8 md:mb-12 px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-white">
            👋 Bienvenido {{ $user->name }}
        </h2>
        <p class="text-blue-100 mt-1 md:mt-2 text-sm md:text-base">
            Panel del alumno - Sistema SIGAE
        </p>
    </div>

    @if(request()->is('dashboard'))

    <div class="flex justify-center pb-10 md:pb-20 px-2">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 max-w-3xl w-full">

            <a href="{{ route('alumno.notificaciones') }}"
               class="relative bg-white shadow-lg rounded-2xl p-6 sm:p-8 text-center hover:shadow-2xl hover:scale-105 transition">

                @if($cantidadNotificaciones > 0)
                    <span class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        {{ $cantidadNotificaciones }}
                    </span>
                @endif

                <div class="text-4xl sm:text-5xl mb-2 sm:mb-4">🔔</div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800">Notificaciones</h3>

            </a>

            <a href="{{ route('alumno.notas') }}"
               class="bg-white shadow-lg rounded-2xl p-6 sm:p-8 text-center hover:shadow-2xl hover:scale-105 transition">
                <div class="text-4xl sm:text-5xl mb-2 sm:mb-4">📊</div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800">Mis Notas</h3>
            </a>

            <a href="{{ route('alumno.asistencias.historial') }}"
               class="bg-white shadow-lg rounded-2xl p-6 sm:p-8 text-center hover:shadow-2xl hover:scale-105 transition">
                <div class="text-4xl sm:text-5xl mb-2 sm:mb-4">📊</div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800">Mis Asistencias</h3>
            </a>

            <a href="{{ route('alumno.feriados') }}"
               class="bg-white shadow-lg rounded-2xl p-6 sm:p-8 text-center hover:shadow-2xl hover:scale-105 transition">
                <div class="text-4xl sm:text-5xl mb-2 sm:mb-4">📅</div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800">Feriados del Calendario</h3>
            </a>

            <a href="{{ route('alumno.resumen') }}"
               class="bg-white shadow-lg rounded-2xl p-6 sm:p-8 text-center hover:shadow-2xl hover:scale-105 transition">
                <div class="text-4xl sm:text-5xl mb-2 sm:mb-4">📈</div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800">Resumen General</h3>
            </a>

            <a href="{{ route('alumno.datos') }}"
               class="bg-white shadow-lg rounded-2xl p-6 sm:p-8 text-center hover:shadow-2xl hover:scale-105 transition">
                <div class="text-4xl sm:text-5xl mb-2 sm:mb-4">👤</div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800">Mis Datos</h3>
            </a>

            <a href="{{ route('alumno.password') }}"
               class="bg-white shadow-lg rounded-2xl p-6 sm:p-8 text-center hover:shadow-2xl hover:scale-105 transition">
                <div class="text-4xl sm:text-5xl mb-2 sm:mb-4">🔒</div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800">Cambiar Contraseña</h3>
            </a>

            <a href="{{ route('alumno.justificacion.motivo') }}"
               class="bg-white shadow-lg rounded-2xl p-6 sm:p-8 text-center hover:shadow-2xl hover:scale-105 transition">
                <div class="text-4xl sm:text-5xl mb-2 sm:mb-4">📝</div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800">Justificaciones</h3>
            </a>

        </div>

    </div>

    @else

    <div class="max-w-4xl mx-auto pb-10 md:pb-20 px-4">
        @yield('content')
    </div>

    @endif

</div>

@endif

<script>
document.addEventListener("DOMContentLoaded", function(){

    const sidebar = document.getElementById("sidebar"); // 👈 FALTABA ESTO
    const toggleBtn = document.getElementById("toggleSidebar");
    const openBtn = document.getElementById("openSidebarMobile");

    if(openBtn){
        openBtn.addEventListener("click", function(){
            sidebar.classList.remove("-translate-x-full");
        });
    }

    if(!sidebar || !toggleBtn) return;

    toggleBtn.addEventListener("click", function(){

        if(window.innerWidth < 768){
            // 📱 MOBILE → ocultar/mostrar
            sidebar.classList.toggle("-translate-x-full");
        } else {
            // 💻 DESKTOP → colapsar ancho
            const isCollapsed = sidebar.classList.contains("w-16");

            if(isCollapsed){
                sidebar.classList.remove("w-16", "sidebar-mini");
                sidebar.classList.add("w-64");
            } else {
                sidebar.classList.remove("w-64");
                sidebar.classList.add("w-16", "sidebar-mini");
            }

            localStorage.setItem("sidebarCollapsed", !isCollapsed);
        }

    });

    // 💾 Mantener estado SOLO en desktop
    if(window.innerWidth >= 768){
        const collapsed = localStorage.getItem("sidebarCollapsed") === "true";

        if(collapsed){
            sidebar.classList.remove("w-64");
            sidebar.classList.add("w-16", "sidebar-mini");
        }
    }

});
</script>

</body>
</html>