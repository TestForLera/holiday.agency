<?php $__env->startSection('admin_title', 'Пользователи'); ?>
<?php $__env->startSection('admin_heading', 'Пользователи'); ?>
<?php $__env->startSection('admin_description', 'Контактные данные клиентов и история активности.'); ?>
<?php $__env->startSection('admin_content'); ?>
    <section class="admin-card">
        <div class="admin-card-header"><div><span>База клиентов</span><h2><?php echo e($users->total()); ?> пользователей</h2></div></div>
        <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>ID</th><th>Имя</th><th>Email</th><th>Телефон</th><th>Роль</th><th>Заказов</th><th>Регистрация</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><strong>#<?php echo e($user->id); ?></strong></td>
                    <td><div class="admin-user-cell"><span class="admin-client-avatar"><?php echo e(mb_strtoupper(mb_substr($user->name, 0, 1))); ?></span><strong><?php echo e($user->name); ?></strong></div></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->phone); ?></td>
                    <td><span class="admin-role role-<?php echo e($user->role); ?>"><?php echo e($user->role === 'admin' ? 'Администратор' : 'Клиент'); ?></span></td>
                    <td><?php echo e($user->orders_count); ?></td>
                    <td><?php echo e($user->created_at?->format('d.m.Y')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        </div>
        <div class="admin-pagination"><?php echo e($users->links()); ?></div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/admin/users.blade.php ENDPATH**/ ?>