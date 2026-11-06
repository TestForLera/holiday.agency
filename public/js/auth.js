document.addEventListener('DOMContentLoaded', function() {
    const authModal = document.getElementById('authModal');
    const modalClose = document.querySelector('.auth-modal-close');
    const tabBtns = document.querySelectorAll('.auth-tab-btn');
    const tabContents = document.querySelectorAll('.auth-tab-content');

    // Переключение между вкладками
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');

            // Убираем активный класс у всех кнопок и вкладок
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));

            // Добавляем активный класс текущей кнопке и вкладке
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Закрытие модального окна
    modalClose.addEventListener('click', () => {
        authModal.style.display = 'none';
    });

    // Обработка формы регистрации
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await fetch('{{ route("register") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                window.location.reload(); // Перезагружаем страницу после успешной регистрации
            } else {
                // Показываем ошибки валидации
                alert('Ошибка регистрации: ' +
                    (result.errors ? Object.values(result.errors).join(', ') : result.message));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Произошла ошибка при регистрации');
        }
    });

    // Обработка формы входа
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await fetch('{{ route("login") }}', {
                method: 'POST',
                body: formData,
                headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                window.location.reload();
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Произошла ошибка при входе');
        }
    });

    // Обработка входа администратора
    document.getElementById('adminForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const adminCode = document.getElementById('adminCode').value;

        try {
            const response = await fetch('{{ route("admin.login") }}', {
                method: 'POST',
                headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ adminCode: adminCode })
    });

    const result = await response.json();

    if (result.success) {
        alert(result.message);
        window.location.href = '/admin-dashboard'; // Перенаправление на админ‑панель
    } else {
        alert(result.message);
    }
} catch (error) {
    console.error('Error:', error);
    alert('Произошла ошибка при входе администратора');
}
});
});

// Функция для открытия модального окна (вызывается откуда‑то ещё)
window.openAuthModal = function() {
    authModal.style.display = 'block';
};

