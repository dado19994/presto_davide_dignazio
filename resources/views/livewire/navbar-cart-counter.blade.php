<div>
<a href="{{ route('cart.summary') }}" class="nav-link position-relative d-inline-block">
    <i class="fas fa-shopping-cart"></i>
    @if($count > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" style="font-size: 0.6rem; padding: 0.35em 0.65em;">
            {{ $count }}
        </span>
    @endif
</a>
</div>
