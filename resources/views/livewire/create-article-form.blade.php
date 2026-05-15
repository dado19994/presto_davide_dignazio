@php
    $formCategories = collect($categories ?? []);
    $selectedCategory = $formCategories->firstWhere('id', $category);
    $previewImage = collect($images)->first();
@endphp

<div class="create-article-workbench">
    @if (session('success'))
        <div class="alert alert-dark text-center rounded-4 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="create-workbench-hero glass-panel">
        <div>
            <p class="page-eyebrow mb-2">AI Listing Studio</p>
            <h2>Costruisci un annuncio completo mentre l'AI ti assiste.</h2>
            <p>Titolo, prezzo, categoria, descrizione e tag vengono aggiornati nella preview in tempo reale.</p>
        </div>
        <div class="create-step-strip">
            <span class="{{ $title ? 'is-done' : '' }}"><i class="fas fa-heading"></i> Titolo</span>
            <span class="{{ $category ? 'is-done' : '' }}"><i class="fas fa-layer-group"></i> Categoria</span>
            <span class="{{ $description ? 'is-done' : '' }}"><i class="fas fa-align-left"></i> Testo</span>
            <span class="{{ count($images) ? 'is-done' : '' }}"><i class="fas fa-images"></i> Foto</span>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="row g-4 align-items-start">
            <div class="col-12 col-xl-8">
                <div class="row g-4">
                    <div class="col-12 col-lg-6">
                        <div class="card-custom create-article-panel create-form-panel p-4 h-100">
                            <div class="create-panel-heading">
                                <span>01</span>
                                <div>
                                    <h2>Dati principali</h2>
                                    <p>Titolo, modello, prezzo e categoria.</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">
                                    Titolo
                                </label>

                                <input type="text"
                                    class="form-control custom-input @error('title') is-invalid @enderror"
                                    placeholder="Es: MacBook Air M3" id="title" wire:model.live="title">

                                @error('title')
                                    <p class="fst-italic text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="brand_model" class="form-label fw-bold">
                                    Marca o modello
                                </label>

                                <input type="text"
                                    class="form-control custom-input @error('brand_model') is-invalid @enderror"
                                    placeholder="Es: Apple MacBook Air M3" id="brand_model" wire:model.live="brand_model">

                                @error('brand_model')
                                    <p class="fst-italic text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>

                            @if (!empty($aiSuggestions))
                                <div class="ai-writing-coach mb-4">
                                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-3">
                                        <div>
                                            <span class="dashboard-kicker">AI creazione annuncio</span>
                                            <strong>Consigli mentre scrivi</strong>
                                        </div>
                                        @if (!empty($aiSuggestions['category_name']))
                                            <button type="button" class="btn btn-sm custom-btn-outline"
                                                wire:click="applySuggestedCategory">
                                                Categoria: {{ $aiSuggestions['category_name'] }}
                                            </button>
                                        @endif
                                    </div>

                                    <div class="ai-writing-actions">
                                        @if (!empty($aiSuggestions['brand_model']) && empty($brand_model))
                                            <button type="button" wire:click="applySuggestedBrandModel">
                                                <i class="fas fa-wand-magic-sparkles"></i>
                                                Usa marca/modello
                                            </button>
                                        @endif
                                        <button type="button" wire:click="applySuggestedTitle">
                                            <i class="fas fa-heading"></i>
                                            Migliora titolo
                                        </button>
                                        <button type="button" wire:click="applySuggestedDescription">
                                            <i class="fas fa-align-left"></i>
                                            Genera descrizione
                                        </button>
                                        <button type="button" wire:click="applySuggestedTags">
                                            <i class="fas fa-hashtag"></i>
                                            Aggiungi tag
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label for="price" class="form-label fw-bold">
                                    Prezzo
                                </label>

                                <div class="input-group">
                                    <input type="text"
                                        class="form-control custom-input @error('price') is-invalid @enderror"
                                        id="price" wire:model.live="price" placeholder="0.00">

                                    <span class="input-group-text">
                                        €
                                    </span>
                                </div>

                                @error('price')
                                    <p class="fst-italic text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror

                                {{-- AI PRICE SUGGESTION --}}
                                <livewire:price-suggester :title="$title" :categoryId="$category" />
                            </div>

                            <div>
                                <label for="category" class="form-label fw-bold">
                                    Categoria
                                </label>

                                <select id="category" wire:model.live="category"
                                    class="form-select custom-input @error('category') is-invalid @enderror">
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

                            <div class="mb-3 mt-4">
                                <label for="tags" class="form-label fw-bold">
                                    Tag
                                </label>
                                <input type="text" id="tags" wire:model.live="tags"
                                    class="form-control custom-input @error('tags') is-invalid @enderror"
                                    placeholder="#iphone #smartphone #apple">
                                <p class="text-secondary small mt-2 mb-0">Usali come sui social: aiutano ricerca e suggerimenti.</p>
                                @error('tags')
                                    <p class="fst-italic text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 mt-4">
                                <label for="temporary_images" class="form-label fw-bold">
                                    Immagini articolo
                                </label>

                                <div class="upload-dropzone @error('temporary_images') is-invalid @enderror @error('temporary_images.*') is-invalid @enderror">
                                    <input type="file" id="temporary_images" class="upload-input"
                                        wire:model.live="temporary_images" multiple accept="image/*">

                                    <label for="temporary_images" class="upload-trigger">
                                        <span class="upload-icon">
                                            <i class="fas fa-cloud-arrow-up"></i>
                                        </span>
                                        <span class="upload-copy">
                                            <strong>Scegli immagini</strong>
                                            <small>PNG, JPG o WEBP fino a 1MB. Puoi caricarne massimo 6.</small>
                                        </span>
                                    </label>

                                    <div wire:loading wire:target="temporary_images" class="upload-loading">
                                        Caricamento immagini...
                                    </div>
                                </div>

                                @error('temporary_images.*')
                                    <p class="fst-italic text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                                @error('temporary_images')
                                    <p class="fst-italic text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror

                                @if (!empty($images))
                                    <div class="uploaded-images mt-4">
                                        <p class="fw-bold mb-3">
                                            Immagini caricate: {{ count($images) }}
                                        </p>

                                        <div class="uploaded-images-grid">
                                            @foreach ($images as $key => $image)
                                                <div class="uploaded-image-item">
                                                    <div class="img-preview"
                                                        style="background-image: url({{ $image->temporaryUrl() }})">
                                                    </div>
                                                    <button type="button" class="btn remove-image-btn"
                                                        wire:click="removeImage({{ $key }})"
                                                        aria-label="Rimuovi immagine">
                                                        <i class="fas fa-xmark"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="card-custom create-article-panel create-form-panel p-4 h-100">
                            <div class="create-panel-heading">
                                <span>02</span>
                                <div>
                                    <h2>Descrizione</h2>
                                    <p>Rendi chiaro cosa vendi e perché è interessante.</p>
                                </div>
                            </div>

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
                    <div class="create-preview-top">
                        <span class="article-ai-badge">
                            <i class="fas fa-eye"></i> Anteprima live
                        </span>
                    </div>
                    <div class="article-card-media text-center mb-4 overflow-hidden rounded-4">
                        <img src="{{ $previewImage ? $previewImage->temporaryUrl() : 'https://picsum.photos/600' }}"
                            class="img-fluid preview-image w-100" alt="Anteprima articolo">
                    </div>

                    <div class="text-center">
                        <span class="article-detail-badge text-capitalize mb-3">
                            {{ $selectedCategory?->name ?? 'Categoria' }}
                        </span>

                        <h3 class="fw-bold mb-3">
                            {{ $title ?: 'Titolo articolo' }}
                        </h3>

                        @if ($brand_model)
                            <p class="preview-brand mb-2">{{ $brand_model }}</p>
                        @endif

                        <h5 class="text-secondary mb-3">
                            € {{ $price ?: '0.00' }}
                        </h5>

                        <p class="preview-description mb-4">
                            {{ $description ?: 'La descrizione apparira qui mentre scrivi.' }}
                        </p>

                        @if ($tags)
                            <div class="preview-tags mb-4">
                                @foreach (collect(explode(' ', $tags))->filter()->take(6) as $tag)
                                    <span>{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif

                        <button type="submit" class="btn btn-dark custom-btn-card px-4 w-100">
                            Crea articolo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
