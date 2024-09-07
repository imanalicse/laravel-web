<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
<header class="p-3 mb-3 border-bottom sticky-top">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/" class="nav-link px-2 link-dark">Home</a></li>
                <li><a href="/products" class="nav-link px-2 link-dark">Products</a></li>
            </ul>
            @if (Route::has('login'))
            @auth
            <div class="dropdown text-end">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="/profile">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out </a></li>
                </ul>
            </div>
            @else
            <div class="text-end">
                <a href="{{ route('login') }}" class="btn btn-secondary me-2">Log in</a>
                @if (Route::has('registration'))
                <a href="{{ route('registration') }}" class="btn btn-secondary">Sign-up</a>
                @endif
            </div>
            @endauth
            @endif
            <div class="text-end">
                <a href="/checkout" class="btn btn-secondary me-2">Checkout</a>
            </div>
        </div>
    </div>
</header>
