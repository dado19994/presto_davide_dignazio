<form action="{{ route('setLocale', $lang) }}" method="POST" class="locale-form">
    @csrf
    <button type="submit" class="btn locale-btn" aria-label="Cambia lingua {{ $lang }}">
        <img src="{{ asset('vendor/blade-flags/country-' .$lang. '.svg') }}" width="24" height="24" alt="{{ $lang }}">
    </button>
</form>
