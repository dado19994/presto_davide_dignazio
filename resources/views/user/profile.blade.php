<x-layout>
    <x-page-header
        eyebrow="Profilo"
        title="Profilo utente"
        subtitle="Aggiorna le informazioni che aiutano gli acquirenti a fidarsi di te."
    />

    <section class="container section-shell profile-page">
        @if (session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="profile-layout">
            <aside class="profile-preview glass-panel">
                <div class="seller-avatar profile-avatar-large">
                    @if ($user->avatarUrl())
                        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}">
                    @else
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    @endif
                </div>

                <p class="page-eyebrow mb-2">Anteprima pubblica</p>
                <h2>{{ trim($user->name . ' ' . ($user->surname ?? '')) }}</h2>
                <p>{{ $user->bio ?: 'Aggiungi una bio breve per raccontare chi sei e cosa vendi.' }}</p>

                <div class="profile-preview-grid">
                    <div>
                        <span>Città/Zona</span>
                        <strong>{{ $user->city ?: 'Non impostata' }}</strong>
                    </div>
                    <div>
                        <span>Email</span>
                        <strong>{{ $user->email }}</strong>
                    </div>
                </div>

                <a href="{{ route('seller.show', $user) }}" class="btn custom-btn-outline w-100 mt-3">
                    Vedi profilo pubblico
                </a>
            </aside>

            <div class="profile-editor glass-panel">
                <div class="profile-editor-heading">
                    <div>
                        <p class="page-eyebrow mb-2">Informazioni venditore</p>
                        <h2>Rendi il profilo più affidabile</h2>
                    </div>
                    <a href="{{ route('user.dashboard') }}" class="btn custom-btn-outline">
                        Dashboard
                    </a>
                </div>

                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="bio" class="form-label fw-bold">Bio breve</label>
                        <textarea id="bio" name="bio" class="form-control custom-input @error('bio') is-invalid @enderror"
                            rows="5" maxlength="500"
                            placeholder="Racconta chi sei, che prodotti vendi e come gestisci consegna o trattativa.">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="text-danger small mt-2 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="city" class="form-label fw-bold">Città/Zona</label>
                            <input id="city" name="city" type="text"
                                class="form-control custom-input @error('city') is-invalid @enderror"
                                value="{{ old('city', $user->city) }}" placeholder="Es: Bari, Milano, Roma Nord">
                            @error('city')
                                <p class="text-danger small mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="avatar" class="form-label fw-bold">Avatar</label>
                            <div class="dashboard-upload @error('avatar') is-invalid @enderror">
                                <input type="file" id="avatar" name="avatar" class="dashboard-upload-input" accept="image/*">
                                <label for="avatar" class="dashboard-upload-trigger">
                                    <span class="dashboard-upload-icon">
                                        <i class="fas fa-camera"></i>
                                    </span>
                                    <span>
                                        <strong>Scegli avatar</strong>
                                        <small>JPG, PNG o WEBP fino a 1MB</small>
                                    </span>
                                </label>
                            </div>
                            @error('avatar')
                                <p class="text-danger small mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="profile-actions">
                        <span>Bio, zona e avatar migliorano fiducia e risposta degli acquirenti.</span>
                        <button type="submit" class="btn custom-btn-card">
                            Salva profilo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layout>
