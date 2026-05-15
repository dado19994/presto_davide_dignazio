<footer class="site-footer">
    <div class="container">
        <div class="footer-main">
            <div class="footer-brand">
                <a href="{{ route('homepage') }}" class="footer-logo-link" aria-label="Vai alla homepage">
                    <img src="{{ asset('media/logo1.png') }}" alt="VendoHub AI" class="footer-logo">
                </a>

                <p>
                    Il marketplace intelligente per vendere, comprare e trattare con più sicurezza.
                </p>

                <div class="footer-trust-list" aria-label="Funzioni di fiducia">
                    <span><i class="fas fa-shield-halved"></i> AI Guard</span>
                    <span><i class="fas fa-star"></i> Recensioni</span>
                    <span><i class="fas fa-bolt"></i> Prezzi smart</span>
                </div>
            </div>

            <nav class="footer-links" aria-label="Navigazione marketplace">
                <h2>Marketplace</h2>
                <a href="{{ route('article.index') }}">Esplora articoli</a>
                <a href="{{ route('create.article') }}">Pubblica articolo</a>
                <a href="{{ route('cart.index') }}">Carrello</a>
                <a href="{{ route('favorites.index') }}">Preferiti</a>
            </nav>

            <nav class="footer-links" aria-label="Area venditore">
                <h2>Venditori</h2>
                <a href="{{ route('user.dashboard') }}">Dashboard</a>
                <a href="{{ route('ai.coach') }}">AI Listing Coach</a>
                <a href="{{ route('become.revisor') }}">Diventa revisore</a>
                <a href="{{ route('article.featured') }}">Annunci in evidenza</a>
            </nav>

            <div class="footer-ai-card">
                <div class="footer-ai-icon">
                    <i class="fas fa-microchip"></i>
                </div>
                <div>
                    <span class="footer-ai-kicker">VendoHub AI</span>
                    <h2>Consigli concreti per vendere meglio</h2>
                    <p>
                        Analisi annunci, suggerimenti prezzo, alert sui rischi e risposte rapide in chat.
                    </p>
                    <a href="{{ route('ai.coach') }}" class="footer-ai-link">
                        Apri la console AI
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} VendoHub AI. Tutti i diritti riservati.</p>

            <div class="footer-legal-links">
                <a href="{{ route('privacy') }}">Privacy</a>
                <a href="{{ route('terms') }}">Termini</a>
                <a href="{{ route('security') }}">Sicurezza</a>
            </div>

            <div class="footer-socials" aria-label="Social">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </div>
</footer>
