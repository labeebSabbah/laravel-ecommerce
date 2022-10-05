<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('assets/css/admin-aside.css') }}">
    @include('components.styles')
    <title>{{ $title }}</title>
</head>
<body>

    <svg id="open" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
      </svg>

    <main>

        <aside class="text-bg-dark sticky-top" id="aside">
        
            <h3>Admin Panel</h3>
    
            <svg id="close" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
              </svg>
    
            <hr>
    
            <ul class="list-group">

                <a href="/admin" class="nav-link"><li>Dashboard</li></a>
    
                <a href="/admin/products" class="nav-link"><li>Products</li></a>
    
                <a href="/admin/orders" class="nav-link"><li>Orders</li></a>
                
                <a href="/admin/categories" class="nav-link"><li>Categories</li></a>
    
                <a href="/admin/users" class="nav-link"><li>Users</li></a>
                
            </ul>
    
            <hr>
    
            <ul class="list-group">
                <a href="/user/logout" class="nav-link"><li>Sign out</li></a>
            </ul>
    
        </aside>
    
        <div class="container">

            <h3 id="page">{{ $title }}</h3>

            <hr>

            {{ $slot }}

        </div>

    </main>

    @include('components.script')

    <script>
        $('#close').click(function () {
            $('#aside').toggle();
            $('.container').toggle();
            $('#close').toggle();
            $('#open').toggle();
        });
        $('#open').click(function () {
            $('#aside').toggle();
            $('.container').toggle();
            $('#open').toggle();
            $('#close').toggle();
        });
    </script>
</body>
</html>