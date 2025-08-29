<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gestion Parking') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            body {
                min-height: 100vh;
                margin: 0;
                font-family: 'Nunito', sans-serif;
                background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            }
            .sidebar {
                width: 250px;
                background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
                color: #fff;
                min-height: 100vh;
                position: fixed;
                left: 0;
                top: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                box-shadow: 2px 0 12px rgba(0,0,0,0.07);
                z-index: 10;
            }
            .sidebar-logo {
                width: 48px;
                height: 48px;
                margin: 32px 0 8px 0;
            }
            .sidebar-title {
                font-size: 1.3rem;
                font-weight: bold;
                margin-bottom: 2px;
            }
            .sidebar-sub {
                font-size: 0.95rem;
                color: #e0e7ff;
                margin-bottom: 32px;
            }
            .sidebar-nav {
                width: 100%;
                flex: 1;
            }
            .sidebar-nav a {
                display: block;
                padding: 12px 32px;
                color: #fff;
                text-decoration: none;
                font-size: 1.05rem;
                border-left: 4px solid transparent;
                transition: background 0.2s, border-color 0.2s;
            }
            .sidebar-nav a.active, .sidebar-nav a:hover {
                background: rgba(255,255,255,0.08);
                border-left: 4px solid #fff;
            }
            .sidebar-logout {
                margin-bottom: 32px;
            }
            .main-content {
                margin-left: 250px;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                background: transparent;
            }
            .main-card {
                background: #fff;
                border-radius: 18px;
                box-shadow: 0 4px 24px rgba(0,0,0,0.10);
                margin: 40px 0 0 0;
                padding: 36px 32px 32px 32px;
                width: 100%;
                max-width: 950px;
            }
            @media (max-width: 900px) {
                .main-card { max-width: 98vw; padding: 18px 4vw; }
                .sidebar { width: 100vw; height: 80px; min-height: 0; flex-direction: row; position: fixed; top: 0; left: 0; }
                .sidebar-logo { margin: 16px; }
                .sidebar-title, .sidebar-sub { display: none; }
                .sidebar-nav { flex-direction: row; display: flex; width: auto; }
                .sidebar-nav a { padding: 10px 18px; font-size: 1rem; border-left: none; border-bottom: 2px solid transparent; }
                .sidebar-nav a.active, .sidebar-nav a:hover { border-left: none; border-bottom: 2px solid #fff; }
                .main-content { margin-left: 0; margin-top: 80px; }
            }
            /* Table style commun */
            table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                background: #fff;
                border-radius: 12px;
                overflow: hidden;
                margin-bottom: 0;
            }
            thead tr {
                background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
                color: #fff;
            }
            th, td {
                padding: 13px 16px;
                text-align: left;
            }
            th {
                font-weight: 700;
                font-size: 1.05rem;
                border-bottom: 2px solid #e5e7eb;
            }
            tbody tr {
                border-bottom: 1px solid #f1f1f1;
                transition: background 0.15s;
            }
            tbody tr:nth-child(even) {
                background: #f8faff;
            }
            tbody tr:hover {
                background: #e6f0ff;
            }
            td {
                font-size: 1rem;
                vertical-align: middle;
            }
            .btn {
                border-radius: 6px !important;
                font-size: 0.98rem !important;
                padding: 6px 16px !important;
                margin-right: 4px;
            }
            .btn-info { background: #2575fc; color: #fff; border: none; }
            .btn-warning { background: #ffb300; color: #fff; border: none; }
            .btn-danger { background: #e53e3e; color: #fff; border: none; }
            .btn-success { background: #38a169; color: #fff; border: none; }
            .btn-primary { background: #6a11cb; color: #fff; border: none; }
            .btn-sm { font-size: 0.93rem !important; padding: 4px 10px !important; }
            form[style*='display:inline-block'] { display: inline; }
            @media (max-width: 700px) {
                table, thead, tbody, th, td, tr { font-size: 0.93rem; }
                th, td { padding: 8px 6px; }
            }
            /* Fin style table */
        </style>
        @yield('styles')
    </head>
    <body class="@yield('body_class')">
        <div class="sidebar">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="sidebar-logo">
            <div class="sidebar-title">Admin Panel</div>
            <div class="sidebar-sub">Gestion Parking</div>
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Tableau de bord</a>
                <a href="{{ route('vehicules.index') }}" class="{{ request()->routeIs('vehicules.*') ? 'active' : '' }}">Véhicules</a>
                <a href="{{ route('paiements.index') }}" class="{{ request()->routeIs('paiements.*') ? 'active' : '' }}">Paiements</a>
                <a href="{{ route('historiques.index') }}" class="{{ request()->routeIs('historiques.*') ? 'active' : '' }}">Historiques</a>
                
                @if(auth()->user() && auth()->user()->is_admin)
                <a href="{{ route('utilisateurs.index') }}" class="{{ request()->routeIs('utilisateurs.*') ? 'active' : '' }}">Utilisateurs</a>
                @endif
            </nav>
            <form method="POST" action="{{ route('logout') }}" class="sidebar-logout">
                @csrf
                <button type="submit" style="background:rgba(255,255,255,0.13);color:#fff;border:none;padding:10px 28px;border-radius:8px;cursor:pointer;font-size:1rem;">Déconnexion</button>
            </form>
        </div>
        <div class="main-content">
            <div class="main-card">
                @yield('content')
            </div>
        </div>
    </body>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
