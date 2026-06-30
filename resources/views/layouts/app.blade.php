<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PureStrands')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>
<body>
    <div class="mobile-wrapper">
        <!-- Header -->
        <header class="app-header">
            @yield('header')
        </header>

        <!-- Main Content -->
        <main class="app-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Navigation Bar (Bottom Nav) -->
        @auth
            @if(auth()->user()->role !== 'admin')
                <nav class="bottom-nav">
                    <a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('marketplace') }}" class="{{ Route::is('marketplace*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span>Toko</span>
                    </a>
                    <a class="scan-btn" onclick="alert('AI Hair Scan is under development and scheduled on our roadmap! 🚀')">
                        <div class="scan-icon-wrapper">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <span>Scan</span>
                    </a>
                    <a href="{{ route('experts') }}" class="{{ Route::is('experts*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-doctor"></i>
                        <span>Dokter</span>
                    </a>
                    <a href="{{ route('profile') }}" class="{{ Route::is('profile*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </a>
                </nav>
            @endif
        @endauth
    </div>
    
    @yield('scripts')
</body>
</html>
