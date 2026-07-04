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
        <main class="app-content" style="position: relative;">
            <!-- Parallax Background Layer -->
            <div class="parallax-bg-container">
                <div class="parallax-element parallax-blob-1" data-parallax-speed="0.1" style="will-change: transform;"></div>
                <div class="parallax-element parallax-strand" data-parallax-speed="-0.07" style="will-change: transform;">
                    <svg viewBox="0 0 100 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
                        <path d="M10,10 Q60,100 10,190" stroke="rgba(16, 185, 129, 0.12)" stroke-width="5" fill="none" />
                    </svg>
                </div>
                <div class="parallax-element parallax-blob-2" data-parallax-speed="0.14" style="will-change: transform;"></div>
                <div class="parallax-element parallax-strand-2" data-parallax-speed="-0.12" style="will-change: transform;">
                    <svg viewBox="0 0 100 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
                        <path d="M90,10 Q40,100 90,190" stroke="rgba(59, 130, 246, 0.1)" stroke-width="4" fill="none" />
                    </svg>
                </div>
            </div>

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
    
    <!-- Parallax Scroll Effect JS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const parallaxElements = document.querySelectorAll('.parallax-element');
            const scrollContainer = document.querySelector('.app-content');
            
            if (!scrollContainer || parallaxElements.length === 0) return;

            let ticking = false;

            function updateParallax() {
                const scrollY = scrollContainer.scrollTop;
                
                parallaxElements.forEach(el => {
                    const speed = parseFloat(el.getAttribute('data-parallax-speed')) || 0.1;
                    // Move the background vertically opposite to scroll direction based on speed
                    const yPos = -(scrollY * speed);
                    el.style.transform = `translate3d(0, ${yPos}px, 0)`;
                });
                
                ticking = false;
            }

            scrollContainer.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        updateParallax();
                    });
                    ticking = true;
                }
            }, { passive: true });
            
            // Initial position update
            updateParallax();
        });
    </script>
</body>
</html>
