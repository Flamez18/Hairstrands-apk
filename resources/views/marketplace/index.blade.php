@extends('layouts.app')

@section('title', 'Toko Produk - PureStrands')

@section('header')
    <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Toko Produk</div>
    <a href="{{ route('cart') }}" class="cart-icon-btn">
        <i class="fa-solid fa-cart-shopping"></i>
        @php
            $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
            $cartCount = $cart ? $cart->items()->sum('quantity') : 0;
        @endphp
        <span class="cart-badge" style="display: {{ $cartCount > 0 ? 'flex' : 'none' }};">{{ $cartCount }}</span>
    </a>
@endsection

@section('content')
<!-- Recommendation Banner -->
<div class="promo-banner" style="background: linear-gradient(135deg, #10b981, #064e3b); margin-bottom: 20px;">
    <span class="promo-banner-badge" style="background-color: var(--primary);"><i class="fa-solid fa-wand-magic-sparkles"></i> Rekomendasi AI Khusus Untukmu</span>
    <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 4px;">Berdasarkan hasil analisis rambut terakhirmu</h4>
    <p style="font-size: 0.75rem; opacity: 0.9;">Rekomendasi disesuaikan dengan kondisi rambut Anda yang cenderung agak kering.</p>
</div>

<!-- Search Input -->
<form action="{{ route('marketplace') }}" method="GET" class="search-wrapper">
    <input type="text" name="q" value="{{ $searchQuery }}" class="search-input" placeholder="Cari produk perawatan rambut...">
    <i class="fa-solid fa-magnifying-glass search-icon"></i>
    @if(!empty($activeCategory))
        <input type="hidden" name="category" value="{{ $activeCategory }}">
    @endif
</form>

<!-- Categories Slider -->
<div class="category-filter-list">
    <div class="category-sliding-pill"></div>
    <a href="{{ route('marketplace', ['q' => $searchQuery]) }}" class="category-filter-item {{ empty($activeCategory) ? 'active' : '' }}">Semua</a>
    @foreach($categories as $category)
        <a href="{{ route('marketplace', ['category' => $category->slug, 'q' => $searchQuery]) }}" class="category-filter-item {{ $activeCategory === $category->slug ? 'active' : '' }}">
            {{ $category->name }}
        </a>
    @endforeach
</div>

<!-- Products Container (AJAX Target) -->
<div id="products-container">
    @if($products->isEmpty())
        <div style="text-align: center; padding: 40px 10px; color: var(--text-muted);">
            <i class="fa-regular fa-face-frown" style="font-size: 2.5rem; margin-bottom: 12px; color: #d1d5db;"></i>
            <div style="font-size: 0.9rem; font-weight: 600;">Produk tidak ditemukan</div>
            <div style="font-size: 0.75rem; margin-top: 4px;">Coba gunakan kata kunci pencarian yang lain.</div>
        </div>
    @else
        <!-- Product Grid -->
        <div class="product-grid">
            @foreach($products as $product)
                <a href="{{ route('marketplace.detail', $product->slug) }}" class="product-card reveal-card">
                    <!-- Badge for Recommended/Best Seller -->
                    @if($product->rating >= 4.9)
                        <span class="product-card-badge-ai">AI RECOMMENDED</span>
                    @elseif($product->stock < 10)
                        <span class="product-card-badge" style="background-color: #fef3c7; color: #d97706;">BEST SELLER</span>
                    @endif

                    <div class="product-card-image-wrapper">
                        @if($product->image && (str_starts_with($product->image, 'http') || file_exists(public_path('uploads/' . $product->image))))
                            <div class="skeleton-image-wrapper">
                                <div class="skeleton-shimmer"></div>
                            </div>
                            @if(str_starts_with($product->image, 'http'))
                                <img src="{{ $product->image }}" class="product-card-image" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('uploads/' . $product->image) }}" class="product-card-image" alt="{{ $product->name }}">
                            @endif
                        @else
                            <div class="product-placeholder-image">
                                <i class="fa-solid fa-bottle-droplet" style="font-size: 2.5rem; opacity: 0.9;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="product-card-info">
                        <div class="product-card-name">{{ $product->name }}</div>
                        <div class="product-card-price-row">
                            <span class="product-card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin: 0;" class="add-to-cart-form">
                                @csrf
                                <button type="submit" class="add-cart-mini-btn"><i class="fa-solid fa-plus"></i></button>
                            </form>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize category tabs sliding pill position
    initSlidingPill();
    
    // 2. Initialize product cards (skeleton load, reveal observer)
    initProductCardFeatures();
    
    // 3. Event listener for AJAX Category Tab loading
    const filterList = document.querySelector('.category-filter-list');
    if (filterList) {
        filterList.addEventListener('click', function(e) {
            const tab = e.target.closest('.category-filter-item');
            if (!tab) return;
            
            e.preventDefault();
            const url = tab.getAttribute('href');
            
            // Move sliding pill immediately
            moveSlidingPill(tab);
            
            // Show skeleton loading cards
            showSkeletonLoader();
            
            // Fetch content from the link asynchronously
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContainer = doc.getElementById('products-container');
                
                if (newContainer) {
                    document.getElementById('products-container').innerHTML = newContainer.innerHTML;
                    
                    // Reinitialize skeleton loading and scroll reveal for new cards
                    initProductCardFeatures();
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
    
    // 4. Resize listener to keep the sliding pill aligned correctly
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

    // 5. Add to cart button click handler (prevents card link navigation)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.add-cart-mini-btn');
        if (btn) {
            e.stopPropagation();
            e.preventDefault();
            
            const form = btn.closest('.add-to-cart-form');
            if (form) {
                form.requestSubmit();
            }
        }
    });

    // 6. Form submit delegation for AJAX add to cart with flying animation
    document.addEventListener('submit', function(e) {
        const form = e.target.closest('.add-to-cart-form');
        if (!form) return;
        
        e.preventDefault();
        
        const btn = form.querySelector('.add-cart-mini-btn');
        const card = form.closest('.product-card');
        
        if (btn) {
            btn.classList.add('clicked');
            setTimeout(() => btn.classList.remove('clicked'), 400);
        }
        
        if (card && btn) {
            animateFlyToCart(btn, card);
        }
        
        const actionUrl = form.getAttribute('action');
        const formData = new FormData(form);
        
        fetch(actionUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update badge quantity counter
                updateCartBadge(data.cartCount);
            } else {
                console.error('Failed to add item to cart:', data.message);
            }
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
        });
    });
});

// Helper: Setup initial category tab sliding pill background
function initSlidingPill() {
    const activeTab = document.querySelector('.category-filter-item.active');
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

// Helper: Setup card scroll reveal and image loading transitions
function initProductCardFeatures() {
    // A. Image Skeleton Toggle
    document.querySelectorAll('.product-card-image').forEach(img => {
        if (img.complete) {
            hideSkeleton(img);
        } else {
            img.addEventListener('load', function() {
                hideSkeleton(img);
            });
            img.addEventListener('error', function() {
                hideSkeleton(img);
            });
        }
    });
    
    // B. Scroll Reveal Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.05 });
    
    document.querySelectorAll('.reveal-card').forEach(card => {
        observer.observe(card);
    });
}

// Helper: Fade in actual image and remove the skeleton loader
function hideSkeleton(img) {
    img.classList.add('loaded');
    const wrapper = img.parentElement.querySelector('.skeleton-image-wrapper');
    if (wrapper) {
        wrapper.style.opacity = 0;
        setTimeout(() => wrapper.remove(), 400);
    }
}

// Helper: Show card skeletons while loading tab products via AJAX
function showSkeletonLoader() {
    const container = document.getElementById('products-container');
    if (!container) return;
    
    let skeletonHtml = '<div class="product-grid">';
    for (let i = 0; i < 4; i++) {
        skeletonHtml += `
            <div class="product-card reveal-card revealed" style="pointer-events: none;">
                <div class="product-card-image-wrapper">
                    <div class="skeleton-image-wrapper">
                        <div class="skeleton-shimmer"></div>
                    </div>
                </div>
                <div class="product-card-info">
                    <div class="skeleton-shimmer" style="height: 14px; width: 85%; border-radius: 4px; margin-bottom: 8px;"></div>
                    <div class="skeleton-shimmer" style="height: 12px; width: 55%; border-radius: 4px; margin-bottom: 12px;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 8px;">
                        <div class="skeleton-shimmer" style="height: 16px; width: 45%; border-radius: 4px;"></div>
                        <div class="skeleton-shimmer" style="height: 28px; width: 28px; border-radius: 50%;"></div>
                    </div>
                </div>
            </div>
        `;
    }
    skeletonHtml += '</div>';
    container.innerHTML = skeletonHtml;
}

// Helper: Product fly-to-cart animation
function animateFlyToCart(btn, card) {
    const img = card.querySelector('.product-card-image') || card.querySelector('.product-placeholder-image i');
    const cartIcon = document.querySelector('.cart-icon-btn');
    if (!img || !cartIcon) return;

    const imgRect = img.getBoundingClientRect();
    const cartRect = cartIcon.getBoundingClientRect();

    // Create a flying duplicate
    const thumb = document.createElement('img');
    if (img.tagName === 'IMG') {
        thumb.src = img.src;
    } else {
        thumb.src = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="%2310b981"><circle cx="12" cy="12" r="10"/></svg>';
    }
    thumb.className = 'flying-product-thumb';
    thumb.style.left = `${imgRect.left + (imgRect.width / 2) - 24}px`;
    thumb.style.top = `${imgRect.top + (imgRect.height / 2) - 24}px`;
    document.body.appendChild(thumb);

    // Force render recalculation
    thumb.offsetWidth;

    // Set transition end targets
    thumb.style.transform = `translate(${cartRect.left - imgRect.left + 12}px, ${cartRect.top - imgRect.top + 12}px) scale(0.1)`;
    thumb.style.opacity = '0';

    // Cleanup and trigger bump / wiggle upon impact
    thumb.addEventListener('transitionend', function() {
        thumb.remove();
        
        // Cart wiggle
        cartIcon.classList.add('wiggle');
        
        // Badge bounce bump
        const badge = cartIcon.querySelector('.cart-badge');
        if (badge) {
            badge.classList.add('bump');
        }
        
        setTimeout(() => {
            cartIcon.classList.remove('wiggle');
            if (badge) badge.classList.remove('bump');
        }, 600);
    });
}

// Helper: Update cart count badge
function updateCartBadge(count) {
    const badge = document.querySelector('.cart-badge');
    if (badge) {
        badge.innerText = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    }
}
</script>
@endsection
