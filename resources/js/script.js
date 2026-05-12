window.addEventListener('scroll',()=>{

    const navbar=document.querySelector('.custom-navbar');

    if(window.scrollY > 40){
        navbar.classList.add('scrolled');
    }else{
        navbar.classList.remove('scrolled');
    }

});

const revealElements=document.querySelectorAll(
    '.article-card, .glass-panel, .create-article-panel, .revisor-card, .empty-card'
);

const revealObserver=new IntersectionObserver((entries)=>{

    entries.forEach(entry=>{

        if(entry.isIntersecting){
            entry.target.classList.add('reveal-active');
        }

    });

},{threshold:0.15});

revealElements.forEach(el=>{

    el.classList.add('reveal-start');

    revealObserver.observe(el);

});

window.addEventListener('load', () => {

    document.querySelector('.hero-title')
        ?.classList.add('hero-visible');

});

const navbar = document.querySelector('.custom-navbar');

navbar.addEventListener('mousemove', (e) => {
    const rect = navbar.getBoundingClientRect();
    navbar.style.setProperty('--x', `${e.clientX - rect.left}px`);
    navbar.style.setProperty('--y', `${e.clientY - rect.top}px`);
});
