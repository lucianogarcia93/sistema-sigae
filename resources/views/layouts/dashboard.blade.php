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

<div x-data="{ open: false, collapsed: false }" class="flex flex-col md:flex-row min-h-screen">

    <!-- OVERLAY (móvil) -->
    <div x-show="open" x-transition @click="open = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden">
    </div>

    <!-- SIDEBAR -->
    <aside
        class="fixed md:static inset-y-0 left-0 bg-blue-700 text-white p-4 space-y-6 flex-shrink-0
               transform transition-all duration-300 z-50"
        :class="[
            open ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
            collapsed ? 'md:w-10' : 'md:w-64',
            'w-64'
        ]">

        <!-- HEADER (SIEMPRE visible) -->
        <div 
            class="flex items-center justify-center gap-3 mt-2"
            :class="!collapsed ? 'md:-ml-8' : ''">

            <button 
                @click="window.innerWidth < 768 ? open = true : collapsed = !collapsed"
                class="text-xl p-1 rounded hover:bg-blue-600 transition">
                ☰
            </button>

            <h1 x-show="!collapsed" class="text-lg font-bold whitespace-nowrap">
                Panel De Control
            </h1>

        </div>

        <!-- TODO EL CONTENIDO (se oculta cuando collapsed) -->
        <div x-show="!collapsed" x-transition>

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
                        class="w-full px-3 py-2 rounded-lg hover:bg-blue-600 text-left">
                        📚 Gestión Académica
                    </button>

                    <div x-show="openMenu === 'academica'" x-transition class="ml-2 space-y-2 mt-2">
                        <a href="{{ route('academica.niveles.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">🎓 Niveles</a>
                        <a href="{{ route('academica.cursos.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">📖 Cursos</a>
                        <a href="{{ route('academica.alumnos.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">👨‍🎓 Alumnos</a>
                        <a href="{{ route('academica.materias.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">📚 Materias</a>
                        <a href="{{ route('academica.profesores.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">👨‍🏫 Profesores</a>
                        <a href="{{ route('academica.solicitudes.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">📬 Solicitudes</a>
                    </div>
                </div>

                <!-- ASISTENCIAS -->
                <div>
                    <button @click="openMenu = openMenu === 'asistencia' ? '' : 'asistencia'"
                        class="w-full px-3 py-2 rounded-lg hover:bg-blue-600 text-left">
                        🕒 Registro Asistencias
                    </button>

                    <div x-show="openMenu === 'asistencia'" x-transition class="ml-2 space-y-2 mt-2">
                        <a href="{{ route('asistencia.asistencia_alumno.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">📌 Asistencia Alumnos</a>
                    </div>
                </div>

                <!-- CALENDARIO -->
                <div>
                    <button @click="openMenu = openMenu === 'calendario' ? '' : 'calendario'"
                        class="w-full px-3 py-2 rounded-lg hover:bg-blue-600 text-left">
                        📅 Calendario Académico
                    </button>

                    <div x-show="openMenu === 'calendario'" x-transition class="ml-2 space-y-2 mt-2">
                        <a href="{{ route('calendario.feriados.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">🎉 Feriados</a>
                        <a href="{{ route('calendario.justificaciones.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">📝 Justificaciones</a>
                        <a href="{{ route('calendario.calificaciones.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">🅰️ Calificaciones</a>
                    </div>
                </div>

                <!-- REPORTES -->
                <div>
                    <button @click="openMenu = openMenu === 'reportes' ? '' : 'reportes'"
                        class="w-full px-3 py-2 rounded-lg hover:bg-blue-600 text-left">
                        📊 Reportes
                    </button>

                    <div x-show="openMenu === 'reportes'" x-transition class="ml-2 space-y-2 mt-2">
                        <a href="{{ route('reportes.generales') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">📈 Reportes Generales</a>
                        <a href="{{ route('reportes.excel') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">📊 Excel</a>
                        <a href="{{ route('reportes.alumnos.estadistica') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">📄 PDF</a>
                    </div>
                </div>

            </nav>

            <!-- LOGOUT -->
            <form method="POST" action="{{ route('logout') }}" class="pt-6">
                @csrf
                <button class="w-full bg-red-500 hover:bg-red-600 py-2 rounded-lg transition">
                    Cerrar sesión
                </button>
            </form>

        </div>

    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER MOBILE -->
        <div class="md:hidden flex items-center bg-white shadow px-4 py-3">
            <button @click="open = true" class="text-2xl mr-3">
                ☰
            </button>

            <h1 class="text-lg font-bold text-gray-800">
                Panel Administrador
            </h1>
        </div>

        <!-- CONTENIDO -->
        <main class="flex-1 p-4 md:p-10 overflow-auto">
            @yield('content')
        </main>

    </div>

</div>

@endif

<script>

document.addEventListener("DOMContentLoaded", function(){

    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("toggleSidebar");

    if(!sidebar || !toggleBtn) return;

    toggleBtn.addEventListener("click", function(){

        sidebar.classList.toggle("w-16");
        sidebar.classList.toggle("w-64");
        sidebar.classList.toggle("sidebar-mini");

        localStorage.setItem(
            "sidebarCollapsed",
            sidebar.classList.contains("w-16")
        );

    });

});

</script>

</body>
</html>