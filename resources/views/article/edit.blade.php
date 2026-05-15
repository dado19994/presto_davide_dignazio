<x-layout>
    <x-page-header eyebrow="Annuncio" title="Modifica articolo"
        subtitle="Aggiorna i dettagli principali: dopo il salvataggio tornerà in revisione" />

    <section class="container section-shell">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">
                <form action="{{ route('article.update', $article) }}" method="POST"
                    class="create-article-panel p-4 p-md-5">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-12 col-md-7">
                            <label for="title" class="form-label fw-bold">Titolo</label>
                            <input type="text" id="title" name="title"
                                class="form-control custom-input @error('title') is-invalid @enderror"
                                value="{{ old('title', $article->title) }}">
                            @error('title')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-12 col-md-5">
                            <label for="price" class="form-label fw-bold">Prezzo</label>
                            <input type="text" id="price" name="price"
                                class="form-control custom-input @error('price') is-invalid @enderror"
                                value="{{ old('price', $article->price) }}">
                            @error('price')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="category_id" class="form-label fw-bold">Categoria</label>
                            <select id="category_id" name="category_id"
                                class="form-select custom-input @error('category_id') is-invalid @enderror">
                                @foreach ($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-bold">Descrizione</label>
                            <textarea id="description" name="description" rows="8"
                                class="form-control custom-input @error('description') is-invalid @enderror">{{ old('description', $article->description) }}</textarea>
                            @error('description')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between gap-3 flex-wrap mt-4">
                        <a href="{{ route('user.dashboard') }}" class="btn custom-btn-outline">Annulla</a>
                        <button type="submit" class="btn custom-btn-card">Salva modifiche</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layout>
