let lastScroll = 0;

window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.custom-navbar');
    const currentScroll = window.scrollY;

    if (!navbar) return;

    if (currentScroll > 40) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }

    lastScroll = currentScroll;
});

const revealElements=document.querySelectorAll(
    '.article-card, .glass-panel, .create-article-panel, .revisor-card, .empty-card, .coach-card, .coach-summary-card, .policy-card'
);

if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {

            if (entry.isIntersecting) {

                setTimeout(() => {
                    entry.target.classList.add('reveal-active');
                }, index * 60);

                revealObserver.unobserve(entry.target);
            }

        });
    }, { threshold: 0.15 });

    revealElements.forEach(el=>{

        el.classList.add('reveal-start');

        revealObserver.observe(el);

    });
} else {
    revealElements.forEach(el=>el.classList.add('reveal-active'));
}

window.addEventListener('load', () => {
    const hero = document.querySelector('.hero-title');

    if (!hero) return;

    setTimeout(() => {
        hero.classList.add('hero-visible');
    }, 200);
});

document.querySelectorAll('.navbar-search-collapsed').forEach((form) => {
    const input = form.querySelector('input[type="search"]');
    const button = form.querySelector('button[type="submit"]');

    if (!input || !button) return;

    if (input.value.trim().length > 0) {
        form.classList.add('is-expanded');
    }

    button.addEventListener('click', (event) => {
        const isExpanded = form.classList.contains('is-expanded') || input.value.trim().length > 0;

        if (!isExpanded) {
            event.preventDefault();
            form.classList.add('is-expanded');
            input.focus();
        }
    });

    input.addEventListener('blur', () => {
        if (input.value.trim().length === 0) {
            form.classList.remove('is-expanded');
        }
    });
});
