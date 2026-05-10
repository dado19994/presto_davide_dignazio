<footer class="footer">
    <div class="footer-container py-5">
        <div class="container">
            <div class="row gy-5 align-items-center">

                <!-- Brand -->
                <div class="col-12 col-md-4 text-center text-md-start">
                    <h5 class="text-white fw-bold mb-3">
                        Story1
                    </h5>

                    <p class="footer-copy mb-0 px-3 px-md-0">
                        Una community semplice per pubblicare, scoprire e raccontare articoli.
                    </p>
                </div>

                <!-- Social -->
                <div class="col-12 col-md-4">
                    <section class="social-section d-flex flex-wrap justify-content-center gap-3">

                        <a href="#" class="social-btn facebook" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a href="#" class="social-btn twitter" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>

                        <a href="#" class="social-btn instagram" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a href="#" class="social-btn linkedin" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>

                        <a href="#" class="social-btn github" aria-label="GitHub">
                            <i class="fab fa-github"></i>
                        </a>

                    </section>
                </div>

                <!-- Revisor CTA -->
                <div class="col-12 col-md-4 text-center text-md-end">
                    <h6 class="text-white fw-bold mb-3">
                        Vuoi diventare revisore?
                    </h6>

                    <a href="{{ route('become.revisor') }}"
                       class="btn btn-outline-light px-4 py-2 rounded-pill">
                        Candidati ora
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="bottom-bar py-3">
        <div class="container text-center">
            <p class="mb-0 text-white small">
                © {{ date('Y') }} Story1 - Tutti i diritti riservati
            </p>
        </div>
    </div>
</footer>















{{-- OPZIONE 2 --}}

{{-- <footer class="footer">
  <div class="footer-container">
    <div class="container">
      <h5 class="text-white fw-bold mb-3">
        Story1
      </h5>

      <section class="social-section">
        <a href="#" class="social-btn facebook" aria-label="Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>

        <a href="#" class="social-btn twitter" aria-label="Twitter">
          <i class="fab fa-twitter"></i>
        </a>

        <a href="#" class="social-btn instagram" aria-label="Instagram">
          <i class="fab fa-instagram"></i>
        </a>

        <a href="#" class="social-btn linkedin" aria-label="LinkedIn">
          <i class="fab fa-linkedin-in"></i>
        </a>

        <a href="#" class="social-btn github" aria-label="GitHub">
          <i class="fab fa-github"></i>
        </a>
      </section>

      <p class="footer-copy mb-0">
        Una community semplice per pubblicare, scoprire e raccontare articoli.
      </p>
    </div>
  </div>
  <div class="col-md-5 offset-md-1 mb-3 text-center text-white">
    <h5>Vuoi diventare revisore?</h5>
    <a href="{{ route('become.revisor') }}" class="btn btn-outline-light mt-2">Clicca qui</a>
  </div>

  <div class="bottom-bar">
    <p class="mb-0">
      © {{ date('Y') }} Story1
    </p>
  </div>
</footer> --}}

