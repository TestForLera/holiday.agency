<?php $__env->startSection('admin_title', 'Обзор'); ?>
<?php $__env->startSection('admin_heading', 'Добро пожаловать!'); ?>
<?php $__env->startSection('admin_description', 'Краткая сводка по сайту и последние действия клиентов.'); ?>

<?php $__env->startSection('admin_content'); ?>
    <div class="admin-stats-grid">
        <a href="<?php echo e(route('admin.users')); ?>" class="admin-stat-card stat-blue">
            <span class="admin-stat-icon"><i class="fas fa-users"></i></span>
            <span><small>Пользователи</small><strong><?php echo e($stats['totalUsers']); ?></strong><em>Все клиенты</em></span>
            <i class="fas fa-arrow-right admin-stat-arrow"></i>
        </a>
        <a href="<?php echo e(route('admin.orders')); ?>" class="admin-stat-card stat-green">
            <span class="admin-stat-icon"><i class="fas fa-clipboard-check"></i></span>
            <span><small>Всего заявок</small><strong><?php echo e($stats['totalOrders']); ?></strong><em>За всё время</em></span>
            <i class="fas fa-arrow-right admin-stat-arrow"></i>
        </a>
        <a href="<?php echo e(route('admin.orders')); ?>" class="admin-stat-card stat-orange">
            <span class="admin-stat-icon"><i class="fas fa-clock"></i></span>
            <span><small>Требуют внимания</small><strong><?php echo e($stats['pendingOrders']); ?></strong><em>Новые и в работе</em></span>
            <i class="fas fa-arrow-right admin-stat-arrow"></i>
        </a>
        <a href="<?php echo e(route('admin.reviews')); ?>" class="admin-stat-card stat-pink">
            <span class="admin-stat-icon"><i class="fas fa-star"></i></span>
            <span><small>Отзывы</small><strong><?php echo e($stats['totalReviews']); ?></strong><em>Опубликовано</em></span>
            <i class="fas fa-arrow-right admin-stat-arrow"></i>
        </a>
    </div>

    <div class="admin-quick-actions">
        <a href="<?php echo e(route('admin.services.index')); ?>"><i class="fas fa-plus"></i><span><strong>Добавить программу</strong><small>Цены и описание</small></span></a>
        <a href="<?php echo e(route('admin.heroes.index')); ?>"><i class="fas fa-masks-theater"></i><span><strong>Добавить героя</strong><small>Каталог персонажей</small></span></a>
        <a href="<?php echo e(route('admin.content.edit')); ?>"><i class="fas fa-pen-to-square"></i><span><strong>Изменить главную</strong><small>Тексты и слайдер</small></span></a>
    </div>

    <div class="admin-dashboard-grid">
        <section class="admin-card admin-orders-card">
            <div class="admin-card-header">
                <div><span>Последние события</span><h2>Новые заявки</h2></div>
                <a href="<?php echo e(route('admin.orders')); ?>">Смотреть все <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Заявка</th><th>Клиент</th><th>Дата</th><th>Программа</th><th>Статус</th></tr></thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong>#<?php echo e($order->id); ?></strong></td>
                            <td><strong><?php echo e($order->fio ?? $order->user->name ?? 'Без имени'); ?></strong><small><?php echo e($order->phone ?? $order->user->phone ?? ''); ?></small></td>
                            <td><?php echo e($order->date?->format('d.m.Y')); ?><small><?php echo e($order->time); ?></small></td>
                            <td><?php echo e($order->service->title ?? $order->hero_name ?? '—'); ?></td>
                            <td><span class="admin-status status-<?php echo e($order->status); ?>"><?php echo e($order->status_label); ?></span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5"><div class="admin-empty">Заявок пока нет</div></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="admin-card admin-clients-card">
            <div class="admin-card-header">
                <div><span>Недавно зарегистрировались</span><h2>Новые клиенты</h2></div>
                <a href="<?php echo e(route('admin.users')); ?>">Все</a>
            </div>
            <div class="admin-client-list">
                <?php $__empty_1 = true; $__currentLoopData = $users->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="admin-client-item">
                        <span class="admin-client-avatar"><?php echo e(mb_strtoupper(mb_substr($user->name, 0, 1))); ?></span>
                        <span><strong><?php echo e($user->name); ?></strong><small><?php echo e($user->email); ?></small></span>
                        <small><?php echo e($user->created_at?->format('d.m')); ?></small>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="admin-empty">Пользователей пока нет</div>
                <?php endif; ?>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>