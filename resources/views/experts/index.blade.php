@extends('layouts.app')

@section('title', 'Dokter Ahli - PureStrands')

@section('header')
    <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Konsultasi Dokter</div>
    <div></div>
@endsection

@section('content')
{{-- Top Banner --}}
<div class="promo-banner" style="margin-bottom: 20px;">
    <span class="promo-banner-badge"><i class="fa-solid fa-user-doctor"></i> Spesialis Rambut & Kulit</span>
    <h3 class="promo-banner-title">Konsultasi Langsung ke Ahlinya</h3>
    <p class="promo-banner-subtitle">Hair stylist & dermatologi profesional siap membantu kesehatan rambut Anda.</p>
</div>

{{-- Specialty Filter --}}
<div class="category-filter-list">
    <div class="category-sliding-pill"></div>
    <a href="{{ route('experts') }}" class="category-filter-item {{ empty($activeSpecialty) ? 'active' : '' }}">Semua</a>
    <a href="{{ route('experts', ['specialty' => 'Dermatologi']) }}" class="category-filter-item {{ $activeSpecialty === 'Dermatologi' ? 'active' : '' }}">Dermatologi</a>
    <a href="{{ route('experts', ['specialty' => 'Hair Stylist']) }}" class="category-filter-item {{ $activeSpecialty === 'Hair Stylist' ? 'active' : '' }}">Hair Stylist</a>
</div>

<div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 16px; font-weight: 600;">
    {{ $experts->count() }} Dokter Tersedia
</div>

{{-- Experts List --}}
<div class="expert-list" id="experts-container">
    @foreach($experts as $index => $expert)
    <div class="expert-card reveal-card">
        <div class="expert-photo-wrapper">
            @if($expert->photo && file_exists(public_path('uploads/' . $expert->photo)))
                <img src="{{ asset('uploads/' . $expert->photo) }}" class="expert-photo" alt="{{ $expert->name }}">
            @else
                <div style="width: 76px; height: 76px; border-radius: 14px; background: linear-gradient(135deg, var(--primary-light), #c6eed9); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 700; color: var(--primary);">
                    {{ substr($expert->name, 4, 1) }}
                </div>
            @endif
            @if($index % 2 === 0)
                <span class="status-badge-online">Online</span>
            @endif
        </div>

        <div class="expert-info">
            <div class="expert-name">{{ $expert->name }}</div>
            <div class="expert-specialty">{{ $expert->profile }}</div>
            <div class="expert-meta">
                <span><i class="fa-solid fa-star"></i> {{ $expert->rating }}</span>
                <span><i class="fa-regular fa-clock"></i> {{ $expert->experience }}</span>
            </div>
            <div style="display: flex; align-items: center; justify-content: flex-end;">
                <a href="{{ route('experts.detail', $expert->id) }}" class="btn btn-primary" style="width: auto; padding: 8px 16px; font-size: 0.8rem; display: inline-block;">
                    Booking
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize category tabs sliding pill position
    initSlidingPill();
    
    // Resize listener to keep the sliding pill aligned correctly
    window.addEventListener('resize', function() {
        const activeTab = document.querySelector('.category-filter-item.active');
        if (activeTab) {
            const pill = document.querySelector('.category-sliding-pill');
            if (pill) {
                pill.style.transition = 'none'; // Temporarily disable transition for snap
                pill.style.width = `${activeTab.offsetWidth}px`;
                pill.style.height = `${activeTab.offsetHeight}px`;
                pill.style.transform = `translateX(${activeTab.offsetLeft}px)`;
                pill.offsetHeight; // Force reflow
                pill.style.transition = ''; // Restore transition
            }
        }
    });
    
    // Handle click for category filter items so pill moves immediately
    const filterList = document.querySelector('.category-filter-list');
    if (filterList) {
        filterList.addEventListener('click', function(e) {
            const tab = e.target.closest('.category-filter-item');
            if (!tab) return;
            
            e.preventDefault();
            const url = tab.getAttribute('href');
            
            // Start the animation immediately
            moveSlidingPill(tab);
            
            // Show skeleton or just fade out current container
            const container = document.getElementById('experts-container');
            if (container) {
                container.style.opacity = '0.5';
            }
            
            // Fetch content asynchronously
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContainer = doc.getElementById('experts-container');
                
                if (newContainer && container) {
                    container.innerHTML = newContainer.innerHTML;
                    container.style.opacity = '1';
                    
                    // Reinitialize scroll reveal for new cards
                    document.querySelectorAll('.reveal-card').forEach(card => {
                        observer.observe(card);
                    });
                }
                
                // Update URL dynamically
                history.pushState(null, '', url);
            })
            .catch(error => {
                console.error('Error loading category:', error);
                window.location.href = url; // Fallback to standard page load
            });
        });
    }

    // 2. Staggered Scroll Reveal Observer
    const observer = new IntersectionObserver((entries) => {
        let delayIndex = 0;
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Apply stagger delay dynamically
                entry.target.style.transitionDelay = `${delayIndex * 80}ms`;
                
                // Add revealed class to trigger animation
                requestAnimationFrame(() => {
                    entry.target.classList.add('revealed');
                });
                
                delayIndex++;
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -20px 0px' });

    document.querySelectorAll('.reveal-card').forEach(card => {
        observer.observe(card);
    });
});

// Helper: Setup initial category tab sliding pill background
function initSlidingPill() {
    const activeTab = document.querySelector('.category-filter-item.active') || document.querySelector('.category-filter-item');
    const pill = document.querySelector('.category-sliding-pill');
    if (activeTab && pill) {
        pill.style.width = `${activeTab.offsetWidth}px`;
        pill.style.height = `${activeTab.offsetHeight}px`;
        pill.style.transform = `translateX(${activeTab.offsetLeft}px)`;
        activeTab.classList.add('js-active');
    }
}

// Helper: Move sliding pill background to new active tab
function moveSlidingPill(activeTab) {
    const pill = document.querySelector('.category-sliding-pill');
    if (!pill || !activeTab) return;
    
    pill.style.width = `${activeTab.offsetWidth}px`;
    pill.style.height = `${activeTab.offsetHeight}px`;
    pill.style.transform = `translateX(${activeTab.offsetLeft}px)`;
    
    document.querySelectorAll('.category-filter-item').forEach(tab => {
        tab.classList.remove('active', 'js-active');
    });
    activeTab.classList.add('active', 'js-active');
}
</script>
@endsection
