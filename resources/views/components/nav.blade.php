@php
use App\Models\Order;
if (Auth::check()) {
    $corder = Order::where('customer_id', Auth::user()->id)->count();
}
@endphp
<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
    <div class="container"><a class="navbar-brand d-flex align-items-center" href="/"><span>Brand</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-5">
            <div class="col-lg-10" style="display: flex;justify-content: center;gap: 20px;">
                <ul class="navbar-nav ms-auto" style="display: flex !important;justify-content: center !important;width: 100%;">
                    <li class="nav-item"><a class="nav-link" href="#">Products</a></li>
                    <li class="nav-item" class="position-relative">
                        <a class="nav-link" href="/cart">
                            Cart
                            @if (Auth::check())
                            <span class="badge text-bg-danger">
                                <?php 
                                    $cart = $_SESSION['cart'] ?? [];
                                    $num = 0;
                                    foreach ($cart as $p) {
                                        $num += $p['quantity'];
                                    }
                                ?>
                                {{ $num }}
                            </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/orders">
                            Orders
                            @if (Auth::check())
                            <span class="badge text-bg-danger">
                                {{ $corder }}
                            </span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav ms-auto">
                @if (Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Hello {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="/user/logout">Sign out</a></li>
                    </ul>
                  </li>          
                @else
                <li class="nav-item"><a class="nav-link" href="/login">Sign in</a></li>
                <li class="nav-item"><a class="nav-link" href="/register">Sign up</a></li> 
                @endif
            </ul>
        </div>
    </div>
</nav>