<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
<header class="store-header sticky-top">
    {{-- Top bar --}}
    <div class="store-topbar">
        <div class="container d-flex justify-content-between align-items-center">
            <span>Free shipping on orders over $50</span>
            <div class="d-flex gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="/profile">My Account</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                    @else
                        <a href="{{ route('login') }}">Sign in</a>
                        @if (Route::has('registration'))
                            <a href="{{ route('registration') }}">Create Account</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>

    {{-- Main navbar --}}
    <nav class="store-navbar">
        <div class="container d-flex align-items-center justify-content-between">
            {{-- Brand --}}
            <a href="/" class="store-brand">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h12V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5m2 .5a.5.5 0 0 1 .5.5V13h8V9.5a.5.5 0 0 1 1 0V13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5a.5.5 0 0 1 .5-.5"/>
                </svg>
                <span>LaraShop</span>
            </a>

            {{-- Navigation --}}
            <ul class="store-nav d-none d-md-flex">
                <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="/products" class="{{ request()->is('products*') ? 'active' : '' }}">Shop</a></li>
            </ul>

            {{-- Actions --}}
            <div class="store-actions">
                {{-- Cart --}}
                <a href="/cart" class="store-cart-btn" title="Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                    @php
                        $cartProducts = session('cart.products', []);
                        $cartCount = 0;
                        foreach ($cartProducts as $p) { $cartCount += $p['quantity'] ?? 0; }
                    @endphp
                    <span class="cart-badge js-cart-count">{{ $cartCount }}</span>
                </a>

                {{-- Mobile menu toggle --}}
                <button class="store-menu-toggle d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile nav --}}
        <div class="collapse container d-md-none" id="mobileNav">
            <ul class="store-mobile-nav">
                <li><a href="/">Home</a></li>
                <li><a href="/products">Shop</a></li>
                @guest
                    <li><a href="{{ route('login') }}">Sign in</a></li>
                @endguest
            </ul>
        </div>
    </nav>
</header>
