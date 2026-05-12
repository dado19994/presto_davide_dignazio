{{-- @props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
])

<section class="container page-header">
    <div class="row justify-content-center text-center">
        <div class="col-12 col-lg-10">
            @if ($eyebrow)
                <p class="page-eyebrow mb-2">
                    {{ $eyebrow }}
                </p>
            @endif

            <h1 class="display-3 fw-bold text-white mb-3">
                {{ $title }}
            </h1>

            @if ($subtitle)
                <p class="text-white fs-5 opacity-75 mb-0">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>
</section> --}}


{{-- opzione 2 --}}
@props([
 'eyebrow' => null,
 'title',
 'subtitle' => null,
])
<section class="container page-header text-center">
 @if($eyebrow)
 <p class="page-eyebrow mb-3">
 {{ $eyebrow }}
 </p>
 @endif
 <h1 class="display-2 fw-bold text-white mb-4">
 {{ $title }}
 </h1>
 @if($subtitle)
 <p class="hero-subtitle mx-auto">
 {{ $subtitle }}
 </p>
 @endif
</section>
