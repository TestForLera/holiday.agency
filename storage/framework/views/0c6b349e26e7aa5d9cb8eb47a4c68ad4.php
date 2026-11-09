<?php $__env->startSection('title', trim($__env->yieldContent('admin_title', 'Админ-панель'))); ?>
<?php $__env->startSection('body_class', 'admin-page'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="admin-brand">
            <span class="admin-brand-icon"><i class="fas fa-sparkles"></i></span>
            <span><strong>Винни</strong><small>Управление сайтом</small></span>
        </a>

        <nav class="admin-navigation" aria-label="Административные разделы">
            <span class="admin-nav-caption">Основное</span>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="admin-nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-chart-pie"></i><span>Обзор</span>
            </a>
            <a href="<?php echo e(route('admin.orders')); ?>" class="admin-nav-link <?php echo e(request()->routeIs('admin.orders*') ? 'active' : ''); ?>">
                <i class="fas fa-clipboard-list"></i><span>Заявки</span>
            </a>
            <a href="<?php echo e(route('admin.users')); ?>" class="admin-nav-link <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>">
                <i class="fas fa-users"></i><span>Пользователи</span>
            </a>

            <span class="admin-nav-caption">Каталог</span>
            <a href="<?php echo e(route('admin.services.index')); ?>" class="admin-nav-link <?php echo e(request()->routeIs('admin.services*') ? 'active' : ''); ?>">
                <i class="fas fa-wand-magic-sparkles"></i><span>Программы</span>
            </a>
            <a href="<?php echo e(route('admin.packages.index')); ?>" class="admin-nav-link <?php echo e(request()->routeIs('admin.packages*') ? 'active' : ''); ?>">
                <i class="fas fa-box-open"></i><span>Пакеты</span>
            </a>
            <a href="<?php echo e(route('admin.heroes.index')); ?>" class="admin-nav-link <?php echo e(request()->routeIs('admin.heroes*') ? 'active' : ''); ?>">
                <i class="fas fa-masks-theater"></i><span>Герои</span>
            </a>

            <span class="admin-nav-caption">Сайт</span>
            <a href="<?php echo e(route('admin.content.edit')); ?>" class="admin-nav-link <?php echo e(request()->routeIs('admin.content*') || request()->routeIs('admin.slides*') ? 'active' : ''); ?>">
                <i class="fas fa-pen-to-square"></i><span>Контент</span>
            </a>
            <a href="<?php echo e(route('admin.reviews')); ?>" class="admin-nav-link <?php echo e(request()->routeIs('admin.reviews*') ? 'active' : ''); ?>">
                <i class="fas fa-star"></i><span>Отзывы</span>
            </a>
        </nav>

        <div class="admin-sidebar-footer">
            <a href="<?php echo e(url('/')); ?>" class="admin-site-link">
                <i class="fas fa-arrow-up-right-from-square"></i>
                <span>Открыть сайт</span>
            </a>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="admin-logout-button">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                    <span>Выйти</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <header class="admin-page-header">
            <div>
                <span class="admin-eyebrow">Административная панель</span>
                <h1><?php echo $__env->yieldContent('admin_heading', 'Управление'); ?></h1>
                <?php if (! empty(trim($__env->yieldContent('admin_description')))): ?>
                    <p><?php echo $__env->yieldContent('admin_description'); ?></p>
                <?php endif; ?>
            </div>
            <div class="admin-header-user">
                <span class="admin-header-avatar"><i class="fas fa-user-shield"></i></span>
                <span><strong><?php echo e(auth()->user()->name); ?></strong><small>Администратор</small></span>
            </div>
        </header>

        <?php if(session('success')): ?>
            <div class="admin-alert success"><i class="fas fa-circle-check"></i><span><?php echo e(session('success')); ?></span></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="admin-alert error">
                <i class="fas fa-circle-exclamation"></i>
                <div><strong>Проверьте заполнение формы</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
            </div>
        <?php endif; ?>

        <div class="admin-content">
            <?php echo $__env->yieldContent('admin_content'); ?>
        </div>
    </main>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layots', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/admin/layout.blade.php ENDPATH**/ ?>