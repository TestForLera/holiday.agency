<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Поздравление ростовой куклой'); ?></title>
    <link rel="icon" href="<?php echo e(asset('img/logo.png')); ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>?v=<?php echo e(filemtime(public_path('css/style.css'))); ?>">
</head>
<body class="<?php echo $__env->yieldContent('body_class'); ?>">
    <!-- Шапка -->
    <header class="main-header fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- Логотип -->
                <a class="navbar-brand" href="/">
                    <img src="<?php echo e(asset('img/logo.png')); ?>" alt="Логотип" height="50">
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/#heroes">Наши герои</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#programs">Программы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#why-us">Почему мы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#reviews">Отзывы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#prices">Цены</a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav">
                        <?php if(auth()->guard()->guest()): ?>
                            <!-- Для гостей -->
                            <li class="nav-item">
                                <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#authModal">
                                    <i class="fas fa-user"></i> Личный кабинет
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#callbackModal">
                                    <i class="fas fa-phone"></i> Заказать звонок
                                </button>
                            </li>
                        <?php else: ?>
                            <?php if(auth()->user()->role === 'user'): ?>
                                <!-- Для обычных пользователей -->
                                <li class="nav-item dropdown account-dropdown">
                                    <a class="nav-link dropdown-toggle account-menu-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="account-avatar">
                                            <?php if(auth()->user()->avatar): ?>
                                                <img src="<?php echo e(Storage::url(auth()->user()->avatar)); ?>" alt="">
                                            <?php else: ?>
                                                <i class="fas fa-user" aria-hidden="true"></i>
                                            <?php endif; ?>
                                        </span>
                                        <span class="account-label"><?php echo e(auth()->user()->name); ?></span>
                                        <i class="fas fa-chevron-down account-chevron" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="<?php echo e(route('cabinet')); ?>">Личный кабинет</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="dropdown-item">Выйти</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            <?php elseif(auth()->user()->role === 'admin'): ?>
                                <!-- Для администратора -->
                                <li class="nav-item dropdown account-dropdown">
                                    <a class="nav-link dropdown-toggle account-menu-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="account-avatar"><i class="fas fa-user-shield" aria-hidden="true"></i></span>
                                        <span class="account-label">Админ панель</span>
                                        <i class="fas fa-chevron-down account-chevron" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">Панель управления</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.orders')); ?>">Заявки</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.reviews')); ?>">Отзывы</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.content.edit')); ?>">Контент</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="dropdown-item">Выйти</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Модальное окно авторизации/регистрации -->
    <?php if(auth()->guard()->guest()): ?>
    <div class="modal fade" id="authModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вход / Регистрация</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="authTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#login" type="button">
                                <i class="fas fa-right-to-bracket" aria-hidden="true"></i>
                                <span>Вход</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#register" type="button">
                                <i class="fas fa-user-plus" aria-hidden="true"></i>
                                <span>Регистрация</span>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3">
                        <!-- Форма входа -->
                        <div class="tab-pane fade show active" id="login">
                            <form action="<?php echo e(route('login')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Пароль</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Войти</button>
                            </form>
                        </div>
                        <!-- Форма регистрации -->
                        <div class="tab-pane fade" id="register">
                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <form action="<?php echo e(route('register')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label>Имя</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Телефон</label>
                                    <input type="tel" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Пароль</label>
                                    <input type="password" name="password" class="form-control" required minlength="6">
                                </div>
                                <div class="mb-3">
                                    <label>Повторите пароль</label>
                                    <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                                </div>
                                <div class="mb-3">
                                    <label>Аватар (необязательно)</label>
                                    <input type="file" name="avatar" class="form-control" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно заказа звонка -->
    <div class="modal fade" id="callbackModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Заказать звонок</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label>Ваше имя</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Телефон</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Основной контент -->
    <main style="margin-top: 76px;">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="<?php echo e(asset('img/logo.png')); ?>" alt="Логотип">
            </div>
            <div class="footer-contacts">
                <h3>Контакты</h3>
                <p>г. Челябинск</p>
                <p>Тел: 8 (908) 070 33-42</p>
                <p>Email: info@kukla.ru</p>
            </div>
            <div class="footer-social">
                <h3>Мы в соцсетях</h3>
                <p>VK | Telegram | WhatsApp</p>
            </div>
        </div>
        <div style="text-align:center; margin-top:20px; font-size:0.9rem;">
            © 2026 Поздравление ростовой куклы. Все права защищены.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('js/index.js')); ?>?v=<?php echo e(filemtime(public_path('js/index.js'))); ?>"></script>
<?php if(session('open_auth') || $errors->has('email') || $errors->has('password') || $errors->has('name') || $errors->has('phone')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('authModal');
    if (modal && window.bootstrap) {
        var requestedTab = <?php echo json_encode(session('open_auth', old('name') || old('phone') ? 'register' : 'login'), 512) ?>;
        var tabBtn = document.querySelector('[data-bs-target="#' + requestedTab + '"]');

        if (tabBtn) {
            bootstrap.Tab.getOrCreateInstance(tabBtn).show();
        }

        bootstrap.Modal.getOrCreateInstance(modal).show();
    }
});
</script>
<?php endif; ?>
</body>
</html>
<?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/layots.blade.php ENDPATH**/ ?>