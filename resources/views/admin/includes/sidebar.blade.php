<div class="main-sidebar">
    <div class="logo">
        <img src="{{asset('src/admin/img/new-logo.png')}}" alt="" style="max-width: 178px">
    </div>
    <div class="sidebar-menu">
        <ul>            
            <li class="<?php if($controller == 'DashboardController'){ echo 'active'; }  ?>"><a href="/admin">Dashboard</a></li>
            <li class="<?php if($controller == 'UsersController'){ echo 'active'; }  ?>"><a href="/admin/users">Users</a></li>
            <li class="<?php if($controller == 'ProductController'){ echo 'active'; }  ?>"><a href="{{ route('products.index') }}">Products</a></li>
            <li class=""><a href="{{url('/admin/clear-config')}}" class="badge pending">Clear configuration</a></li>
        </ul>
    </div>

    <div class="footer-backend">
        <p class="develop-buy"> Web Development by <a href="https://www.webalive.com.au" target="_blank">WebAlive</a></p>
    </div>

</div>