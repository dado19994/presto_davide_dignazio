@props([
 'eyebrow' => null,
 'title',
 'subtitle' => null,
])
<section class="page-header-shell">
    <div class="container">
        <div class="page-header text-center">
            <div class="page-header-orbit" aria-hidden="true"></div>

            @if($eyebrow)
                <p class="page-eyebrow mb-3">
                    {{ $eyebrow }}
                </p>
            @endif

            <h1 class="display-2 fw-bold text-white mb-4">
                {{ $title }}
            </h1>

            @if($subtitle)
                <p class="hero-subtitle mx-auto mb-0">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>
</section>
