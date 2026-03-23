<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'GoPe')</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let map, marker, autocomplete;

        function initMap() {
            const defaultLatLng = {
                lat: parseFloat(document.getElementById('latitud').value) || -8.3634803,
                lng: parseFloat(document.getElementById('longitud').value) || -74.5814769
            };

            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLatLng,
                zoom: 14,
            });

            marker = new google.maps.Marker({
                position: defaultLatLng,
                map: map,
                draggable: true
            });

            // Autocomplete de dirección
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('direccion')
            );

            autocomplete.addListener('place_changed', function () {
                const place = autocomplete.getPlace();
                if (!place.geometry) return;

                const location = place.geometry.location;
                map.setCenter(location);
                marker.setPosition(location);

                setLatLng(location.lat(), location.lng());
            });

            // Click en el mapa
            map.addListener('click', function (event) {
                marker.setPosition(event.latLng);
                setLatLng(event.latLng.lat(), event.latLng.lng());
            });

            // Arrastrar marcador
            marker.addListener('dragend', function (event) {
                setLatLng(event.latLng.lat(), event.latLng.lng());
            });
        }

        function setLatLng(lat, lng) {
            document.getElementById('latitud').value = lat;
            document.getElementById('longitud').value = lng;
        }

        window.onload = initMap;
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"></script>
    <style>
        /*Cerrar sesion*/
        .btn-logout {
            background: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .btn-logout i {
            margin-right: 6px;
        }

        .btn-logout:hover {
            background-color: #dc3545;
            color: #fff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            overflow: hidden;
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
        }

        /* ===== LAYOUT ===== */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 240px;
            background: linear-gradient(180deg, #0f172a, #020617);
            color: white;
            padding: 20px;
            font-size: 16px;

            display: flex;
            flex-direction: column;
        }

        .sidebar-bottom {
            margin-top: auto;
            /* 👈 empuja el contenido hacia abajo */

            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar h1 {
            font-size: 22px;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e5e7eb;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 8px;
            transition:
                background-color 0.25s ease,
                transform 0.2s ease,
                box-shadow 0.2s ease,
                color 0.2s ease;
        }

        .sidebar a.active {
            background: linear-gradient(135deg,
                    #1f2937,
                    #111827);
            color: #ffffff;

            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
        }

        .sidebar a:hover {
            background: linear-gradient(135deg,
                    #1f2937,
                    #111827);
            color: #ffffff;

            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
        }

        /* ===== CONTENT ===== */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* ===== HEADER ===== */
        .header {
            position: fixed;
            top: 0;
            left: 240px;
            /* ancho del sidebar */
            right: 0;
            height: 64px;
            background: white;
            padding: 0 24px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 200;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
        }

        .logout {
            background: none;
            border: 1px solid #dc2626;
            color: #dc2626;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        /* ===== MAIN ===== */
        main {
            margin-top: 64px;
            /* altura del header */
            height: calc(95vh - 64px);
            /* pantalla menos header */
            overflow-y: auto;
            /* SOLO AQUÍ SCROLL */
            padding: 24px;
            padding-bottom: 120px;
            /* 👈 CLAVE */

        }

        .dashboard {
            padding: 30px;
            background: #f3f4f6;
            min-height: 100vh;
        }

        .main-default {
            padding: 30px;
        }

        .main-compact {
            padding: 16px 24px;
        }

        /* ===== FOOTER ===== */

        .footer {
            position: fixed;
            bottom: 0;
            left: 240px;
            /* ancho del sidebar */
            right: 0;
            height: 50px;
            background: white;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            padding: 0 24px;
            font-size: 14px;
            z-index: 100;
        }


        /* Cards superiores */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .stat-card {
            height: 160px;
            /* 🔑 todas iguales */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-radius: 14px;
            color: #fff;
        }


        .stat-card span {
            color: #6b7280;
            font-size: 14px;
        }

        .stat-card h2 {
            margin-top: 10px;
            font-size: 32px;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            transition: .3s;
        }

        /* Colores */
        .green {
            border-left: 6px solid #C1E5FF;
        }

        .blue {
            border-left: 6px solid #466C87;
        }

        .orange {
            border-left: 6px solid #f59e0b;
        }

        .purple {
            border-left: 6px solid #7c3aed;
        }

        /* Gráficos */
        .charts {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .chart-card {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        }

        .chart-card h3 {
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            margin-top: 12px;
            padding: 10px 14px;
            background: #16a34a;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .btn:hover {
            background: #15803d;
        }

        .card {
            border-radius: 10px;
        }

        .card-body {
            padding: 16px;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stat-card {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Botones outline personalizados */
        .btn-outline-success,
        .btn-outline-warning,
        .btn-outline-reloj,
        .btn-outline-danger {
            background-color: #fff;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        /* Hover verde */
        .btn-outline-success:hover {
            background-color: #198754;
            color: #fff;
        }

        /* Hover amarillo */
        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #000;
        }

        /* Hover rojo */
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

        /* Hover azul */
        .btn-outline-reloj:hover {
            background-color: #080ed7ff;
            color: #fff;
            border: 1px solid #080ed7ff;
        }

        .btn-reloj {
            border: 1px solid #080ed7ff;
        }

        .btn-nuevo {
            color: #000;
            /* texto negro */
            background-color: #fff;
            /* fondo blanco */
            border: 1px solid #198754;
            /* verde Bootstrap */
            transition: all 0.2s ease;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-avatar {
            font-size: 28px;
            color: #374151;
            /* gris elegante */
            cursor: pointer;
        }

        .user-avatar:hover {
            color: #7c3aed;
            /* morado suave */
        }

        .dashboard-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #111827;
            /* negro suave */
        }

        /* ===== RESULTADOS - HEADER CON COLOR SIDEBAR ===== */
        .chart-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            overflow: hidden;
            /* para respetar bordes redondeados */
        }

        .chart-header {
            background: linear-gradient(90deg, #0f172a, #1e293b);
            padding: 14px 20px;
        }

        .chart-header h3 {
            margin: 0;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
        }

        .chart-body {
            padding: 20px;
        }

        /* Chart compacto */
        .chart-card canvas {
            max-height: 220px;
            /* antes era más alto */
        }


        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .stat-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            border-radius: 16px;
            color: #111827;
            /* texto oscuro elegante */
            min-height: 110px;
            box-shadow: 0 6px 18px rgba(117, 115, 115, 0.06);
            background: white;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Texto */
        .stat-content span {
            font-size: 14px;
            opacity: 0.9;
        }

        .stat-content h2 {
            margin: 6px 0 0;
            font-size: 32px;
            font-weight: 700;
        }

        /* Ícono a la derecha */
        .stat-icon {
            font-size: 42px;
            opacity: 0.35;
        }

        /* Quitar punto/bullet del item de notificaciones */
        .navbar .nav-item {
            list-style: none;
        }

        /* Refuerzo para navegadores modernos */
        .navbar .nav-item::marker {
            content: '';
        }

        .image-wrapper {
            position: relative;
        }

        .btn-delete-image {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 22px;
            height: 22px;
            padding: 0;
            font-size: 14px;
            line-height: 1;
            border-radius: 50%;
            opacity: 0.85;
            /* visible pero sutil */
        }

        .btn-delete-image:hover {
            opacity: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            /* 👈 misma altura vertical */
            gap: 10px;
            /* espacio icono-texto */
            padding: 10px 14px;
            font-size: 14px;
        }

        .sidebar-icon {
            font-size: 16px;
            /* 👈 tamaño correcto para sidebar */
            width: 18px;
            /* 👈 fuerza alineación vertical */
            text-align: center;
            line-height: 1;
        }
    </style>
</head>

<body>
    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <h1>GoPe</h1>
            <!-- MENÚ -->
            <div class="sidebar-menu">

                @if(auth()->user()->role->nombre === 'admin')
                    <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        📊 Dashboard
                    </a>
                    <a href="{{ route('empresas.index') }}" class="{{ request()->routeIs('empresas.*') ? 'active' : '' }}">
                        🏢 Empresas
                    </a>

                    <a href="{{ route('clientes.index') }}" class="{{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                        👥 Clientes
                    </a>

                    <a href="{{ route('admin.usuarios.index') }}"
                        class="{{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                        👤 Usuarios
                    </a>

                    <a href="{{ route('canchas.index') }}" class="{{ request()->routeIs('canchas.*') ? 'active' : '' }}">
                        🏆 Canchas
                    </a>
                @endif

                @if(auth()->user()->role->nombre === 'empresa')
                    <a href="{{ url('/empresadashboard/dashboard') }}"
                        class="{{ request()->is('empresadashboard/dashboard') ? 'active' : '' }}">
                        📊 Dashboard
                    </a>

                    <a href="{{ route('empresas.edit', auth()->user()->empresa->id) }}"
                        class="{{ request()->routeIs('empresas.edit') ? 'active' : '' }}">
                        🏢 Mi Empresa
                    </a>
                    <a href="{{ route('reservas.dashboard.calendario') }}">
                        📅 Calendario de Reservas
                    </a>
                    <a href="{{ route('reservas.index') }}" class="{{ request()->routeIs('reservas.*') ? 'active' : '' }}">
                        🗓️ Mis Reservas
                    </a>
                    <a href="{{ route('canchas.index') }}" class="{{ request()->routeIs('canchas.*') ? 'active' : '' }}">
                        🏆 Mis canchas
                    </a>
                    <a href="{{ route('cobros.index') }}"
                        class="sidebar-link {{ request()->routeIs('cobros.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt sidebar-icon"></i>
                        <span>Cobros</span>
                    </a>

                @endif
            </div>
            <!-- LOGOUT -->
            <div class="sidebar-bottom">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout w-100">
                        <i class="bi bi-box-arrow-right"></i>
                        Cerrar sesión
                    </button>
                </form>
            </div>

        </aside>


        <!-- CONTENT -->
        <div class="content">

            <!-- HEADER -->
            <header class="header">
                <h2 class="dashboard-title">Hola, {{ auth()->user()->name }} 👋</h2>


                <div class="header-right">
                    <span class="text-muted small">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d \\d\\e F \\d\\e Y') }}
                    </span>
                    <li class="nav-item dropdown" style="list-style:none;">
                        <a class="nav-link position-relative" href="#" id="notificacionesDropdown" role="button"
                            data-bs-toggle="dropdown">

                            🔔

                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end p-2" style="width:300px;">

                            <li class="dropdown-header">Notificaciones</li>

                            @forelse(auth()->user()->unreadNotifications as $noti)
                                <li>
                                    <a href="{{ $noti->data['url'] ?? route('reservas.partials.show', $noti->data['reserva_id']) }}"
                                        class="dropdown-item small" onclick="event.preventDefault();
                                            document.getElementById('notif-form-{{ $noti->id }}').submit();">

                                        <strong>{{ $noti->data['cliente'] }}</strong><br>
                                        Cancha: {{ $noti->data['cancha'] }}<br>
                                        {{ $noti->data['fecha'] }} {{ substr($noti->data['hora_inicio'], 0, 5) }}
                                    </a>

                                    <form id="notif-form-{{ $noti->id }}"
                                        action="{{ route('notifications.read', $noti->id) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @empty
                                <li class="dropdown-item text-muted small">
                                    No hay notificaciones nuevas
                                </li>
                            @endforelse

                        </ul>
                    </li>
                    <div class="user-avatar">
                        <a href="{{ route('perfil.index') }}"
                            class="perfil-link {{ request()->routeIs('perfil.*') ? 'active' : '' }}"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mi perfil">
                            <i class="bi bi-person-circle"></i>
                        </a>
                    </div>
                </div>

            </header>

            <!-- CONTENIDO DINÁMICO -->
            <main class="@yield('main-class', 'main-default')">
                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" target="_blank"><strong>Todos los derechos reservados - GoPe 2026
                                    </strong></a> &copy;
                            </p>
                        </div>

                    </div>
                </div>
            </footer>

        </div>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            document.getElementById('datetime').textContent =
                now.toLocaleString('es-ES');
        }
        updateDateTime();
        setInterval(updateDateTime, 60000);
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    @stack('styles')
    @stack('scripts')
</body>

</html>