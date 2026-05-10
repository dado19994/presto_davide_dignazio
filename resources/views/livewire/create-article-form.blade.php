@php
    $formCategories = collect($categories ?? []);
    $selectedCategory = $formCategories->firstWhere('id', $category);
@endphp

<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-dark text-center rounded-4 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="row g-4 align-items-start">
            <div class="col-12 col-xl-8">
                <div class="row g-4">
                    <div class="col-12 col-lg-6">
                        <div class="card-custom create-article-panel p-4 p-md-5 h-100">
                            <h2 class="h3 text-center fw-bold mb-4">
                                Dati principali
                            </h2>

                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">
                                    Titolo
                                </label>

                                <input type="text" class="form-control custom-input @error('title') is-invalid @enderror"
                                    placeholder="Es: MacBook Air M3" id="title" wire:model.live="title">

                                @error('title')
                                    <p class="fst-italic text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="price" class="form-label fw-bold">
                                    Prezzo
                                </label>

                                <div class="input-group">
                                    <input type="text" class="form-control custom-input @error('price') is-invalid @enderror"
                                        id="price" wire:model.live="price" placeholder="0.00">

                                    <span class="input-group-text">
                                        €
                                    </span>
                                </div>

                                @error('price')
                                    <p class="fst-italic text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category" class="form-label fw-bold">
                                    Categoria
                                </label>

                                <select id="category" wire:model.live="category" class="form-select custom-input @error('category') is-invalid @enderror">
                                    <option value="">
                                        Seleziona una categoria
                                    </option>

                                    @foreach ($formCategories as $categoryOption)
                                        <option value="{{ $categoryOption->id }}">
                                            {{ $categoryOption->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category')
                                    <p class="fst-italic text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="card-custom create-article-panel p-4 p-md-5 h-100">
                            <h2 class="h3 text-center fw-bold mb-4">
                                Descrizione
                            </h2>

                            <label for="description" class="form-label fw-bold">
                                Descrizione
                            </label>

                            <textarea id="description" rows="12" class="form-control custom-input @error('description') is-invalid @enderror"
                                placeholder="Descrivi il prodotto..." wire:model.live="description"></textarea>

                            @error('description')
                                <p class="fst-italic text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="card-custom article-card create-preview-card mx-auto shadow p-4">
                    <div class="text-center mb-4">
                        <img
                            src="https://picsum.photos/600"
                            class="img-fluid preview-image w-100"
                            alt="Anteprima articolo"
                        >
                    </div>

                    <div class="text-center">
                        <span class="article-detail-badge text-capitalize mb-3">
                            {{ $selectedCategory?->name ?? 'Categoria' }}
                        </span>

                        <h3 class="fw-bold mb-3">
                            {{ $title ?: 'Titolo articolo' }}
                        </h3>

                        <h5 class="text-secondary mb-3">
                            € {{ $price ?: '0.00' }}
                        </h5>

                        <p class="preview-description mb-4">
                            {{ $description ?: 'La descrizione apparira qui mentre scrivi.' }}
                        </p>

                        <button type="submit" class="btn btn-dark custom-btn-card px-4 w-100">
                            Crea articolo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
