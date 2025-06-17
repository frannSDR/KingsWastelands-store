document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.destacados-carousel');
    const cards = document.querySelectorAll('.destacado-card');
    const prevBtn = document.querySelector('.nav-btn.prev');
    const nextBtn = document.querySelector('.nav-btn.next');
    const dotsContainer = document.querySelector('.nav-dots');

    let currentIndex = 0;
    const cardsPerSlide = 1;
    const totalSlides = Math.ceil(cards.length / cardsPerSlide);
    const cardWidth = cards[0].offsetWidth + 32;

    // Crear dots de navegación (uno por slide)
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('div');
        dot.classList.add('nav-dot');
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
    }

    const dots = dotsContainer.querySelectorAll('.nav-dot');

    function updateCarousel() {
        carousel.scrollTo({
            left: currentIndex * cardWidth * cardsPerSlide,
            behavior: 'smooth'
        });

        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }

    function goToSlide(index) {
        currentIndex = index;
        updateCarousel();
    }

    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1;
        updateCarousel();
    });

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
        updateCarousel();
    });

    // Auto-avance opcional
    let autoplay = setInterval(() => {
        currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
        updateCarousel();
    }, 5000);

    carousel.addEventListener('mouseenter', () => clearInterval(autoplay));
    carousel.addEventListener('mouseleave', () => {
        autoplay = setInterval(() => {
            currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
            updateCarousel();
        }, 5000);
    });
});