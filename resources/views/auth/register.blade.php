
<x-layout>

    <div class="container py-5">

        <!-- Titolo -->
        <div class="row justify-content-center">

            <div class="col-12 text-center mb-4">

                <h1 class="display-3 fw-bold">
                    Registrati
                </h1>

            </div>

        </div>

        <!-- Form -->
        <div class="row justify-content-center align-items-center">

            <div class="col-12 col-md-8 col-lg-5">

                <form
                    action="{{ route('register') }}"
                    method="POST"
                    class="card-custom p-5"
                >

                    @csrf

                    <!-- Nome -->
                    <div class="mb-4">

                        <label for="name" class="form-label fw-bold">
                            Nome
                        </label>

                        <input
                            type="text"
                            class="form-control custom-input"
                            id="name"
                            name="name"
                            placeholder="Inserisci il tuo nome"
                        >

                    </div>

                    <!-- Email -->
                    <div class="mb-4">

                        <label for="loginEmail" class="form-label fw-bold">
                            Email
                        </label>

                        <input
                            type="email"
                            class="form-control custom-input"
                            id="loginEmail"
                            name="email"
                            placeholder="esempio@email.com"
                        >

                    </div>

                    <!-- Password -->
                    <div class="mb-4">

                        <label for="password" class="form-label fw-bold">
                            Password
                        </label>

                        <input
                            type="password"
                            class="form-control custom-input"
                            id="password"
                            name="password"
                            placeholder="Inserisci la password"
                        >

                    </div>

                    <!-- Conferma password -->
                    <div class="mb-4">

                        <label for="password_confirmation" class="form-label fw-bold">
                            Conferma password
                        </label>

                        <input
                            type="password"
                            class="form-control custom-input"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ripeti la password"
                        >

                    </div>

                    <!-- Bottone -->
                    <div class="text-center">

                        <button
                            type="submit"
                            class="btn btn-dark custom-btn"
                        >
                            Registrati
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-layout>
