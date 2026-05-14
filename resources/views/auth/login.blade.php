<x-layout>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h1 class="display-4 pt-5">
                    Accedi
                </h1>
            </div>
        </div>
        <div class="row justify-content-center align-items-center height-custom">
            <div class="col-12 col-md-8 col-lg-5">
                <form action="{{ route('login') }}" method="POST" class="card-custom p-5">
                    @csrf
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
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn custom-btn-card">Accedi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</x-layout>
