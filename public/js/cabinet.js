document.addEventListener('DOMContentLoaded', function() {
    // Навигация между разделами
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.content-section');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                
                // Убираем активный класс у всех ссылок
                navLinks.forEach(l => l.classList.remove('active'));
                // Добавляем активный класс текущей ссылке
                this.classList.add('active');
                
                // Скрываем все секции
                sections.forEach(section => section.classList.remove('active'));
                
                // Показываем выбранную секцию
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add('active');
                }
            }
        });
    });
    
    // Загрузка аватара
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarForm = document.getElementById('avatarForm');
    
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    
                    // Автоматическая отправка формы
                    const formData = new FormData();
                    formData.append('avatar', file);
                    formData.append('update_avatar', '1');
                    
                    fetch('update_avatar.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Аватар успешно обновлен!', 'success');
                        } else {
                            showNotification(data.message || 'Ошибка при загрузке аватара', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Ошибка соединения', 'error');
                    });
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Редактирование профиля
    function toggleEditMode(section) {
        const form = document.getElementById(section + 'Form');
        if (!form) return;
        
        const inputs = form.querySelectorAll('input:not([type="hidden"]):not([disabled="disabled"])');
        const editBtn = form.closest('.content-section').querySelector('.btn-edit');
        const formActions = form.querySelector('.form-actions');
        
        if (inputs[0].disabled) {
            // Включаем редактирование
            inputs.forEach(input => input.disabled = false);
            if (editBtn) editBtn.textContent = 'Отмена';
            if (formActions) formActions.style.display = 'flex';
        } else {
            // Отключаем редактирование
            inputs.forEach(input => input.disabled = true);
            if (editBtn) editBtn.textContent = 'Редактировать';
            if (formActions) formActions.style.display = 'none';
        }
    }
    
    // Модальные окна
    const passwordModal = document.getElementById('passwordModal');
    const reviewModal = document.getElementById('reviewModal');
    
    function showPasswordModal() {
        if (passwordModal) {
            passwordModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closePasswordModal() {
        if (passwordModal) {
            passwordModal.classList.remove('active');
            document.body.style.overflow = 'auto';
            document.getElementById('passwordForm').reset();
        }
    }
    
    function showReviewModal() {
        if (reviewModal) {
            reviewModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeReviewModal() {
        if (reviewModal) {
            reviewModal.classList.remove('active');
            document.body.style.overflow = 'auto';
            document.getElementById('reviewForm').reset();
        }
    }
    
    // Закрытие модальных окон по клику на фон и Escape
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePasswordModal();
            closeReviewModal();
        }
    });
    
    // Функции для пароля
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    
    // Отправка формы пароля
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Обработка...';
            
            fetch('cabinet.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // Обновляем страницу
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Ошибка соединения', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
    
    // Отправка формы отзыва
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('program_id', document.getElementById('review_program').value);
            formData.append('rating', document.querySelector('input[name="rating"]:checked')?.value);
            formData.append('content', document.getElementById('review_text').value);
            
            const photoFile = document.getElementById('review_photo').files[0];
            if (photoFile) {
                formData.append('photo', photoFile);
            }
            
            formData.append('submit_review', '1');
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Отправка...';
            
            fetch('submit_review.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Отзыв успешно добавлен!', 'success');
                    closeReviewModal();
                    this.reset();
                } else {
                    showNotification(data.message || 'Ошибка при добавлении отзыва', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Ошибка соединения', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
    
    // Функции для заказов
    function viewOrderDetails(orderId) {
        // Здесь можно реализовать просмотр деталей заказа
        window.location.href = `order_details.php?id=${orderId}`;
    }
    
    function cancelOrder(orderId) {
        if (confirm('Вы уверены, что хотите отменить этот заказ?')) {
            fetch('cancel_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ order_id: orderId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Заказ успешно отменен!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(data.message || 'Ошибка при отмене заказа', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Ошибка соединения', 'error');
            });
        }
    }
    
    // Уведомления
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Анимация появления
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Удаление через 5 секунд
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);
        
        // Закрытие по клику
        notification.addEventListener('click', function() {
            this.classList.remove('show');
            setTimeout(() => {
                if (this.parentNode) {
                    this.parentNode.removeChild(this);
                }
            }, 300);
        });
    }
    
    // Добавляем стили для уведомлений
    const notificationStyles = document.createElement('style');
    notificationStyles.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            padding: 15px 20px;
            min-width: 300px;
            max-width: 400px;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 10001;
            cursor: pointer;
            border-left: 4px solid #4a6bff;
        }
        
        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .notification-success {
            border-left-color: #28a745;
        }
        
        .notification-error {
            border-left-color: #dc3545;
        }
        
        .notification-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .notification i {
            font-size: 1.2rem;
        }
        
        .notification-success i {
            color: #28a745;
        }
        
        .notification-error i {
            color: #dc3545;
        }
    `;
    document.head.appendChild(notificationStyles);
    
    // Темная тема
    function setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        
        // Обновляем активные кнопки темы
        document.querySelectorAll('.theme-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector(`.theme-btn.${theme}`)?.classList.add('active');
    }
    
    // Восстанавливаем тему из localStorage
    const savedTheme = localStorage.getItem('theme') || 'light';
    setTheme(savedTheme);
    
    // Уведомления
    function toggleNotifications() {
        showNotification('Настройка уведомлений будет доступна в следующем обновлении!', 'info');
    }
    
    // Инициализация
    console.log('Личный кабинет инициализирован');
});