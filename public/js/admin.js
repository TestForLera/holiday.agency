document.addEventListener('DOMContentLoaded', function() {
    console.log('Админ-панель загружена');
    
    $('#usersTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ru.json'
        },
        pageLength: 25,
        responsive: true
    });
    
    $('#ordersTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ru.json'
        },
        pageLength: 25,
        responsive: true
    });
    
    const navLinks = document.querySelectorAll('.admin-nav-link');
    const sections = document.querySelectorAll('.admin-section');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href').startsWith('#')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                navLinks.forEach(l => l.classList.remove('active'));

                this.classList.add('active');
                
                sections.forEach(section => section.classList.remove('active'));
                
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add('active');
                }
                
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
    
    // Фильтрация заказов
    const orderFilters = document.querySelectorAll('.btn-filter[data-status]');
    orderFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            
            orderFilters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');
            
            const rows = document.querySelectorAll('#ordersTable tbody tr');
            rows.forEach(row => {
                if (status === 'all' || row.getAttribute('data-status') === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
    
    // Фильтрация отзывов
    const reviewFilters = document.querySelectorAll('#reviews .btn-filter');
    reviewFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            
            reviewFilters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');
            
            const reviewCards = document.querySelectorAll('#reviews .review-card');
            reviewCards.forEach(card => {
                if (status === 'all' || card.getAttribute('data-status') === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Модальное окно для программ
    const programModal = document.getElementById('programModal');
    const programForm = document.getElementById('programForm');
    
    window.showAddProgramModal = function() {
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus"></i> Добавить программу';
        document.getElementById('program_id').value = '';
        document.getElementById('program_name').value = '';
        document.getElementById('program_description').value = '';
        document.getElementById('program_price').value = '';
        document.getElementById('currentPhoto').innerHTML = '';
        document.getElementById('modalSubmit').name = 'add_program';
        document.getElementById('modalSubmit').textContent = 'Добавить программу';
        
        programModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.editProgram = function(programId) {
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit"></i> Редактировать программу';
        document.getElementById('program_id').value = programId;
        document.getElementById('modalSubmit').name = 'update_program';
        document.getElementById('modalSubmit').textContent = 'Обновить программу';
        
        fetch(`get_program.php?id=${programId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('program_name').value = data.program.name;
                    document.getElementById('program_description').value = data.program.description;
                    document.getElementById('program_price').value = data.program.price;
                    
                    if (data.program.photo_url) {
                        document.getElementById('currentPhoto').innerHTML = `
                            <p>Текущее фото:</p>
                            <img src="${data.program.photo_url}" alt="Текущее фото" style="max-width: 100px; border-radius: 8px;">
                        `;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Ошибка загрузки данных программы', 'error');
            });
        
        programModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.closeProgramModal = function() {
        programModal.style.display = 'none';
        document.body.style.overflow = 'auto';
        programForm.reset();
    };
    
    // Закрытие модальных окон
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            programModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
    
    // Обновление статуса заказа
    window.updateOrderStatus = function(select, orderId) {
        const status = select.value;
        
        fetch('update_order_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Статус заказа обновлен', 'success');
                
                const statusBadge = select.closest('tr').querySelector('.status-badge');
                statusBadge.className = `status-badge status-${status}`;
                statusBadge.textContent = getStatusLabel(status);
            } else {
                showNotification(data.message || 'Ошибка обновления статуса', 'error');
                select.value = select.getAttribute('data-previous-value');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Ошибка соединения', 'error');
            select.value = select.getAttribute('data-previous-value');
        });
    };
    
    function getStatusLabel(status) {
        const labels = {
            'pending': 'В обработке',
            'confirmed': 'Подтвержден',
            'completed': 'Выполнен',
            'cancelled': 'Отменен'
        };
        return labels[status] || status;
    }
    
    console.log('Админ-панель инициализирована');
});