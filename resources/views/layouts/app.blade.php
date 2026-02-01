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

            display: flex;
            flex-direction: column; 
        }

        .sidebar-bottom {
            margin-top: auto; /* 👈 empuja el contenido hacia abajo */

            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);    
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
            background: linear-gradient(
        135deg,
        #1f2937,
        #111827
        );
        color: #ffffff;

        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
            }   

            .sidebar a:hover {
                background: linear-gradient(
            135deg,
            #1f2937,
            #111827
        );
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
            padding: 24px;
            margin-top: 64px;
            /* mismo alto del header */
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
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
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
            color: #374151; /* gris elegante */
            cursor: pointer;
        }

        .user-avatar:hover {
            color: #7c3aed; /* morado suave */
        }

        .dashboard-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #111827; /* negro suave */
        }

        /* ===== RESULTADOS - HEADER CON COLOR SIDEBAR ===== */
        .chart-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            overflow: hidden; /* para respetar bordes redondeados */
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
            max-height: 220px;   /* antes era más alto */
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
            color: #111827; /* texto oscuro elegante */
            min-height: 110px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
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
        font-size: 40px;
        opacity: 0.35;
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
                    <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        📊 Dashboard
                    </a>   
                    <a href="{{ route('empresas.index') }}"
                    class="{{ request()->routeIs('empresas.*') ? 'active' : '' }}">
                        🏢 Empresas
                    </a>

                    <a href="{{ route('clientes.index') }}"
                    class="{{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                        👥 Clientes
                    </a>

                    <a href="{{ route('admin.usuarios.index') }}"
                    class="{{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                        👤 Usuarios
                    </a>
                    
                    <a href="{{ route('canchas.index') }}"
                    class="{{ request()->routeIs('canchas.*') ? 'active' : '' }}">
                        🏃 Canchas
                    </a> 
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
                    {{-- <h2 class="dashboard-title">Hola, {{ auth()->user()->name }} 👋</h2> --}}
                    <h2 class="dashboard-title">Hola, 👋</h2>


                <div class="header-right">
                    <span class="text-muted small">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d \\d\\e F \\d\\e Y') }}
                    </span> 
                    <div class="user-avatar">
                        <a href="{{ route('perfil.index') }}"
                        class="perfil-link {{ request()->routeIs('perfil.*') ? 'active' : '' }}"
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        title="Mi perfil">
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

    @stack('scripts')
</body>

</html>