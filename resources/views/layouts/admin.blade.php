<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PureStrands Admin Panel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            display: block;
            background-color: #f3f4f6;
        }
        .admin-layout {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .admin-header {
            background-color: var(--primary);
            color: white;
            padding: 16px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
        }
        .admin-header h1 {
            font-size: 1.3rem;
            font-weight: 700;
        }
        .admin-header a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            margin-left: 20px;
        }
        .admin-container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 30px 20px;
            flex: 1;
            display: flex;
            gap: 30px;
        }
        .admin-sidebar {
            width: 260px;
            background-color: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow);
            height: fit-content;
        }
        .admin-menu-list {
            list-style: none;
        }
        .admin-menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 12px;
            color: var(--text-main);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
            transition: all 0.2s;
        }
        .admin-menu-item.active a, .admin-menu-item a:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }
        .admin-main-content {
            flex: 1;
            background-color: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow);
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .admin-table th, .admin-table td {
            padding: 14px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            font-size: 0.85rem;
        }
        .admin-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: var(--text-muted);
        }
        .admin-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 700;
        }
        .admin-dashboard-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background-color: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
        }
        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }
        .btn-danger {
            background-color: #ef4444;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-danger:hover {
            background-color: #dc2626;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="admin-layout">
        <!-- Top bar -->
        <header class="admin-header">
            <h1><i class="fa-solid fa-scissors"></i> PureStrands Admin Panel</h1>
            <div>
                <span>Halo, <strong>{{ auth()->user()->name }}</strong></span>
                <a href="{{ route('home') }}"><i class="fa-solid fa-globe"></i> Hubungi Customer</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </header>

        <!-- Container -->
        <div class="admin-container">
            <!-- Sidebar -->
            <aside class="admin-sidebar">
                <nav class="admin-menu-list">
                    <li class="admin-menu-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-chart-line"></i> Dashboard
                        </a>
                    </li>
                    <li class="admin-menu-item {{ Route::is('admin.categories*') ? 'active' : '' }}">
                        <a href="{{ route('admin.categories.index') }}">
                            <i class="fa-solid fa-list"></i> Kategori
                        </a>
                    </li>
                    <li class="admin-menu-item {{ Route::is('admin.products*') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.index') }}">
                            <i class="fa-solid fa-box"></i> Produk
                        </a>
                    </li>
                    <li class="admin-menu-item {{ Route::is('admin.experts*') ? 'active' : '' }}">
                        <a href="{{ route('admin.experts.index') }}">
                            <i class="fa-solid fa-user-doctor"></i> Dokter Ahli
                        </a>
                    </li>
                    <li class="admin-menu-item {{ Route::is('admin.schedules*') ? 'active' : '' }}">
                        <a href="{{ route('admin.schedules.index') }}">
                            <i class="fa-solid fa-calendar-days"></i> Jadwal Dokter
                        </a>
                    </li>
                    <li class="admin-menu-item {{ Route::is('admin.bookings*') ? 'active' : '' }}">
                        <a href="{{ route('admin.bookings.index') }}">
                            <i class="fa-solid fa-book-bookmark"></i> Booking Konsultasi
                        </a>
                    </li>
                </nav>
            </aside>

            <!-- Main Panel Content -->
            <main class="admin-main-content">
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>
