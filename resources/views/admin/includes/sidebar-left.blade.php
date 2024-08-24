<?php
$route = Route::current(); // Illuminate\Routing\Route
$route_name = Route::currentRouteName(); // string
$action = Route::currentRouteAction(); // string
?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link  <?php if ($route_name == 'admin.dashboard') echo 'active'; ?>" aria-current="page" href="{{route('admin.dashboard')}}">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($route_name == 'admin.users') echo 'active'; ?>" href="{{route('admin.users')}}">
                    <span data-feather="users"></span>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.products.index') }}">
                    <span data-feather="shopping-cart"></span>
                    Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file"></span>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="bar-chart-2"></span>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/admin/clear-config') }}">
                    <span data-feather="delete"></span>
                    Clear configuration
                </a>
            </li>
        </ul>
    </div>
</nav>
