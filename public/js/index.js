
document.addEventListener('DOMContentLoaded', function() {
    const authModal = document.getElementById('authModal');
    const callbackModal = document.getElementById('callbackModal');
    const personalAccountBtn = document.getElementById('personalAccountBtn');
    const openModalBtn = document.getElementById('openModalBtn');
    const authCloseBtn = document.querySelector('.auth-modal-close');
    const closeCallbackModal = document.getElementById('closeCallbackModal');

    if (authModal) authModal.style.display = 'none';
    if (callbackModal) callbackModal.style.display = 'none';

    // --- Управление модальными окнами ---
    function openModal(modal) {
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modal) {
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    function closeAllModals() {
        closeModal(authModal);
        closeModal(callbackModal);
    }

    if (personalAccountBtn) {
        personalAccountBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openModal(authModal);
        });
    }

    if (openModalBtn) {
        openModalBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openModal(callbackModal);
        });
    }

    if (authCloseBtn) {
        authCloseBtn.addEventListener('click', () => closeModal(authModal));
    }

    if (closeCallbackModal) {
        closeCallbackModal.addEventListener('click', () => closeModal(callbackModal));
    }

    window.addEventListener('click', function(event) {
        if (event.target === authModal) closeModal(authModal);
        if (event.target === callbackModal) closeModal(callbackModal);
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAllModals();
    });

    // --- Вкладки авторизации ---
    const authTabBtns = document.querySelectorAll('.auth-tab-btn');
    const authTabContents = document.querySelectorAll('.auth-tab-content');

    authTabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            authTabContents.forEach(c => c.classList.remove('active'));
            authTabBtns.forEach(b => b.classList.remove('active'));

            const content = document.getElementById(tabName);
            if (content) content.classList.add('active');

            this.classList.add('active');
        });
    });

    // --- Форма обратного звонка (оставить) ---
    const callbackForm = document.getElementById('callbackForm');
    if (callbackForm) {
        callbackForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const phoneInput = this.querySelector('.callback-phone-input');
            const submitBtn = this.querySelector('.callback-submit-btn');
            const messageEl = document.getElementById('callbackMessage');

            let value = phoneInput.value.replace(/\D/g, '');
            if (!value || value.length < 11) {
                if (messageEl) {
                    messageEl.textContent = 'Пожалуйста, введите корректный номер телефона';
                    messageEl.style.display = 'block';
                }
                return;
            }

            if (submitBtn) submitBtn.disabled = true;

            // Имитация отправки (удали этот setTimeout, когда подключишь реальный бэкенд)
            setTimeout(() => {
                if (submitBtn) submitBtn.disabled = false;
                phoneInput.value = '';
                if (messageEl) {
                    messageEl.textContent = 'Спасибо! Мы перезвоним вам в ближайшее время.';
                    messageEl.style.color = '#28a745';
                    messageEl.style.display = 'block';
                }
                setTimeout(() => closeModal(callbackModal), 2000);
            }, 1000);
        });
    }

    const phoneInput = document.querySelector('.callback-phone-input');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (!value.startsWith('7') && value.length <= 10) value = '7' + value;
                let formatted = '+7';
                if (value.length > 1) formatted += ' (' + value.substring(1, 4);
                if (value.length >= 5) formatted += ') ' + value.substring(4, 7);
                if (value.length >= 8) formatted += '-' + value.substring(7, 9);
                if (value.length >= 10) formatted += '-' + value.substring(9, 11);
                e.target.value = formatted;
            }
        });
    }

    // --- Слайдер (оставить как есть) ---
    const slider = document.getElementById('slider');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    const slides = document.querySelectorAll('.slide');

    if (slider && slides.length > 0) {
        let currentIndex = 0;
        const totalSlides = slides.length;

        function getVisibleSlides() {
            const w = window.innerWidth;
            return w >= 1024 ? 4 : w >= 768 ? 3 : w >= 576 ? 2 : 1;
        }

        function updateSlider() {
            const visible = getVisibleSlides();
            const slideWidth = 100 / visible;
            slider.style.transform = `translateX(-${currentIndex * slideWidth}%)`;

            if (prevBtn) prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
            if (nextBtn) nextBtn.style.opacity = (currentIndex + visible) >= totalSlides ? '0.5' : '1';
        }

        if (nextBtn && prevBtn) {
            nextBtn.addEventListener('click', () => {
                const visible = getVisibleSlides();
                if (currentIndex + visible < totalSlides) {
                    currentIndex++;
                    updateSlider();
                }
            });
            prevBtn.addEventListener('click', () => {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateSlider();
                }
            });
        }

        window.addEventListener('resize', updateSlider);
        updateSlider();

        let slideInterval = setInterval(() => {
            const visible = getVisibleSlides();
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlider();
        }, 5000);

        slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
        slider.addEventListener('mouseleave', () => {
            slideInterval = setInterval(() => {
                const visible = getVisibleSlides();
                currentIndex = (currentIndex + 1) % totalSlides;
                updateSlider();
            }, 5000);
        });
    }

    // --- Промокод модалка (оставить) ---
    const promoTrigger = document.querySelector('.hero-highlight');
    const promoModalEl = document.getElementById('promoModal');
    const promoClose = document.querySelector('.promo-modal-close');

    if (promoTrigger && promoModalEl) {
        promoTrigger.addEventListener('click', (e) => {
            e.preventDefault();
            promoModalEl.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    }
    if (promoClose) {
        promoClose.addEventListener('click', () => {
            promoModalEl.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }
    window.addEventListener('click', (e) => {
        if (e.target === promoModalEl) {
            promoModalEl.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
});
