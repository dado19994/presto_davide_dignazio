@props(['category'])

@php
    $name = is_string($category) ? $category : ($category->name ?? '');
    $normalized = str($name)->lower()->ascii()->toString();

    $scene = match (true) {
        str_contains($normalized, 'elettronica') => 'electronics',
        str_contains($normalized, 'abbigliamento') => 'fashion',
        str_contains($normalized, 'salute') || str_contains($normalized, 'saute') || str_contains($normalized, 'bellezza') => 'beauty',
        str_contains($normalized, 'casa') || str_contains($normalized, 'giardino') => 'garden',
        str_contains($normalized, 'animali') => 'pets',
        str_contains($normalized, 'libri') || str_contains($normalized, 'riviste') => 'books',
        str_contains($normalized, 'accessori') => 'accessories',
        str_contains($normalized, 'sport') => 'sport',
        str_contains($normalized, 'motori') => 'motors',
        str_contains($normalized, 'giocattoli') => 'toys',
        default => 'default',
    };
@endphp

<div class="category-scene category-scene-{{ $scene }}" aria-hidden="true">
    @if ($scene === 'electronics')
        <div class="scene-circuit-grid"></div>
        <div class="scene-chip"><i class="fas fa-microchip"></i></div>
        <span class="scene-spark spark-one"></span>
        <span class="scene-spark spark-two"></span>
        <span class="scene-spark spark-three"></span>
        <div class="scene-robot scene-robot-main">
            <span class="robot-eye"></span><span class="robot-eye"></span>
        </div>
    @elseif ($scene === 'fashion')
        <div class="scene-robot scene-robot-left">
            <span class="robot-eye"></span><span class="robot-eye"></span>
        </div>
        <div class="scene-shirt">
            <span class="shirt-sleeve left"></span>
            <span class="shirt-body"></span>
            <span class="shirt-sleeve right"></span>
        </div>
        <div class="scene-robot scene-robot-right">
            <span class="robot-eye"></span><span class="robot-eye"></span>
        </div>
    @elseif ($scene === 'beauty')
        <div class="scene-mirror"></div>
        <div class="scene-robot scene-robot-beauty">
            <span class="robot-eye"></span><span class="robot-eye"></span>
        </div>
        <div class="scene-brush"></div>
        <span class="scene-blush blush-one"></span>
        <span class="scene-blush blush-two"></span>
    @elseif ($scene === 'garden')
        <div class="scene-lawn"></div>
        <div class="scene-mower">
            <span></span><span></span>
        </div>
        <div class="scene-robot scene-robot-garden">
            <span class="robot-eye"></span><span class="robot-eye"></span>
        </div>
        <span class="scene-leaf leaf-one"></span>
        <span class="scene-leaf leaf-two"></span>
    @elseif ($scene === 'pets')
        <div class="scene-robot-dog">
            <span class="dog-head"></span>
            <span class="dog-body"></span>
            <span class="dog-tail"></span>
            <span class="dog-leg one"></span>
            <span class="dog-leg two"></span>
        </div>
        <span class="scene-bone"></span>
    @elseif ($scene === 'books')
        <div class="scene-book">
            <span></span><span></span>
        </div>
        <div class="scene-robot scene-robot-reader">
            <span class="robot-eye"></span><span class="robot-eye"></span>
        </div>
        <span class="scene-page page-one"></span>
        <span class="scene-page page-two"></span>
    @elseif ($scene === 'accessories')
        <div class="scene-robot scene-robot-accessory">
            <span class="robot-eye"></span><span class="robot-eye"></span>
            <span class="robot-glasses"></span>
            <span class="robot-necklace"></span>
        </div>
        <span class="scene-gem gem-one"></span>
        <span class="scene-gem gem-two"></span>
    @elseif ($scene === 'sport')
        <div class="scene-robot scene-robot-sport">
            <span class="robot-eye"></span><span class="robot-eye"></span>
        </div>
        <span class="scene-ball"></span>
        <span class="scene-speed speed-one"></span>
        <span class="scene-speed speed-two"></span>
    @elseif ($scene === 'motors')
        <div class="scene-wheel"></div>
        <div class="scene-wrench"></div>
        <div class="scene-robot scene-robot-motors">
            <span class="robot-eye"></span><span class="robot-eye"></span>
        </div>
    @elseif ($scene === 'toys')
        <div class="scene-cube cube-one"></div>
        <div class="scene-cube cube-two"></div>
        <div class="scene-robot scene-robot-toys">
            <span class="robot-eye"></span><span class="robot-eye"></span>
        </div>
    @else
        <div class="scene-circuit-grid"></div>
        <div class="scene-robot scene-robot-main">
            <span class="robot-eye"></span><span class="robot-eye"></span>
        </div>
        <span class="scene-spark spark-one"></span>
        <span class="scene-spark spark-two"></span>
    @endif
</div>
