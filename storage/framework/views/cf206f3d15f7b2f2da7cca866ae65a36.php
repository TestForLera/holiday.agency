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
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>
<body>
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
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle"></i> <?php echo e(auth()->user()->name); ?>

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
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-shield"></i> Админ панель
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">Панель управления</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.orders')); ?>">Заявки</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.reviews')); ?>">Отзывы</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.content.edit')); ?>>Контент</a></li>
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
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#login">Вход</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#register">Регистрация</button>
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
                                    <input type="file" name="avatar" class="form-control">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php if($errors->any() && (old('name') || old('phone') || old('password'))): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('authModal');
    if (modal && window.bootstrap) {
        var tabBtn = document.querySelector('[data-bs-target="#register"]');
        var regPane = document.getElementById('register');
        var loginPane = document.getElementById('login');
        if (tabBtn && regPane) {
            document.querySelectorAll('#authTab .nav-link').forEach(function(el){ el.classList.remove('active'); });
            document.querySelectorAll('#authModal .tab-pane').forEach(function(el){ el.classList.remove('show','active'); });
            tabBtn.classList.add('active');
            regPane.classList.add('show','active');
            new bootstrap.Modal(modal).show();
        }
    }
});
</script>
<?php endif; ?>
</body>
</html><?php /**PATH W:\domains\pr_agent-main\resources\views/layots.blade.php ENDPATH**/ ?>