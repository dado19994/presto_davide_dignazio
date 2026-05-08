<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-12 col-md-8 col-lg-5">

            <div class="card-custom p-5">

                <h1 class="text-center mb-4">
                    Pubblica un articolo
                </h1>

                <form wire:submit.prevent="save">

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

                    <!-- Descrizione -->
                    <div class="mb-4">

                        <label for="description" class="form-label fw-bold">
                            Descrizione
                        </label>

                        <textarea id="description" rows="7" class="form-control custom-input"
                            @error('description') is-invalid

                        @enderror placeholder="Descrivi il prodotto..."
                            wire:model.blur="description"></textarea>
                        @error('description')
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
                    <div class="mb-4">

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

                    <!-- Bottone -->
                    <div class="text-center">

                        <button type="submit" class="btn btn-dark px-4 py-2 rounded-pill">
                            Crea articolo
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
