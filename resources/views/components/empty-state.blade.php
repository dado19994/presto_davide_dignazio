@props([
    'title',
    'message' => null,
    'actionRoute' => null,
    'actionLabel' => null,
])

<div class="card-custom empty-card text-center p-5">
    <h3 class="fw-bold mb-3">
        {{ $title }}
    </h3>

    @if ($message)
        <p class="text-secondary mb-0">
            {{ $message }}
        </p>
    @endif

    @if ($actionRoute && $actionLabel)
        <a href="{{ $actionRoute }}" class="btn btn-dark custom-btn-card mt-4">
            {{ $actionLabel }}
        </a>
    @endif
</div>
