@props(['action'])

<form method="GET" action="{{ $action }}" class="article-filter-panel glass-panel">
    @if (request()->filled('query'))
        <input type="hidden" name="query" value="{{ request('query') }}">
    @endif

    <div>
        <label for="sort" class="form-label">Ordina</label>
        <select id="sort" name="sort" class="form-select custom-input">
            <option value="recent" @selected(request('sort', 'recent') === 'recent')>Più recenti</option>
            <option value="oldest" @selected(request('sort') === 'oldest')>Meno recenti</option>
            <option value="price_asc" @selected(request('sort') === 'price_asc')>Prezzo crescente</option>
            <option value="price_desc" @selected(request('sort') === 'price_desc')>Prezzo decrescente</option>
        </select>
    </div>

    <div>
        <label for="min_price" class="form-label">Prezzo min</label>
        <input id="min_price" name="min_price" type="number" min="0" step="1"
            value="{{ request('min_price') }}" class="form-control custom-input" placeholder="0">
    </div>

    <div>
        <label for="max_price" class="form-label">Prezzo max</label>
        <input id="max_price" name="max_price" type="number" min="0" step="1"
            value="{{ request('max_price') }}" class="form-control custom-input" placeholder="500">
    </div>

    <div>
        <label for="tag" class="form-label">Tag</label>
        <input id="tag" name="tag" type="text" value="{{ request('tag') }}"
            class="form-control custom-input" placeholder="#iphone">
    </div>

    <label class="article-filter-check">
        <input type="checkbox" name="highlighted" value="1" @checked(request()->boolean('highlighted'))>
        <span>Solo in evidenza</span>
    </label>

    <div class="article-filter-actions">
        <button type="submit" class="btn custom-btn-card">Filtra</button>
        <a href="{{ $action }}" class="btn custom-btn-outline">Reset</a>
    </div>
</form>
