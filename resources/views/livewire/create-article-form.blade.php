<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-12">

            <form wire:submit.prevent="save">
                <div class="row g-4">
                    <div class="col-12 col-lg-6">
                        <div class="card-custom create-article-panel p-4 p-md-5 h-100">
                            <h2 class="h3 text-center fw-bold mb-4">
                                Dati principali
                            </h2>

                            <!-- Titolo -->
                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">
                                    Titolo
                                </label>

                                <input type="text" class="form-control custom-input"
                                    @error('title') is-invalid

                                @enderror
                                    placeholder="Es: MacBook Air M3" id="title" wire:model.blur="title">
                                @error('title')
                                    <p class="fst-italic text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prezzo -->
                            <div class="mb-4">

                                <label for="price" class="form-label fw-bold">
                                    Prezzo
                                </label>

                                <div class="input-group">

                                    <input type="text" class="form-control custom-input"
                                        @error('price') is-invalid

                                @enderror id="price"
                                        wire:model.blur="price" placeholder="0.00">
                                    @error('price')
                                        <p class="fst-italic text-danger">{{ $message }}</p>
                                    @enderror

                                    <span class="input-group-text">
                                        €
                                    </span>

                                </div>

                            </div>

                            <!-- Categoria -->
                            <div>

                                <label for="category" class="form-label fw-bold">
                                    Categoria
                                </label>

                                <select id="category" @error('category') is-invalid

                                @enderror
                                    wire:model="category" class="form-select custom-input">

                                    <option selected disabled>
                                        Seleziona una categoria
                                    </option>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('category')
                                    <p class="fst-italic text-danger">{{ $message }}</p>
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

                            <textarea id="description" rows="12" class="form-control custom-input"
                                @error('description') is-invalid

                            @enderror placeholder="Descrivi il prodotto..."
                                wire:model.blur="description"></textarea>
                            @error('description')
                                <p class="fst-italic text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Bottone -->
                <div class="text-center mt-4">

                    <button type="submit" class="btn btn-dark custom-btn-card px-4">
                        Crea articolo
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
