<?php $__env->startSection('title', 'Админ панель'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="margin-top: 80px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Панель управления</h2>
        <div class="btn-group">
            <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-outline-primary btn-sm">Пользователи</a>
            <a href="<?php echo e(route('admin.orders')); ?>" class="btn btn-outline-primary btn-sm">Заказы</a>
            <a href="<?php echo e(route('admin.reviews')); ?>" class="btn btn-outline-primary btn-sm">Отзывы</a>
            <a href="<?php echo e(route('admin.content.edit')); ?>" class="btn btn-outline-primary btn-sm">Контент</a>
            <a href="<?php echo e(route('admin.heroes.index')); ?>" class="btn btn-outline-primary btn-sm">Герои</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white"><div class="card-body">
                <h6>Пользователи</h6><h2><?php echo e($stats['totalUsers']); ?></h2>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white"><div class="card-body">
                <h6>Всего заказов</h6><h2><?php echo e($stats['totalOrders']); ?></h2>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark"><div class="card-body">
                <h6>Ожидают</h6><h2><?php echo e($stats['pendingOrders']); ?></h2>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white"><div class="card-body">
                <h6>Отзывы</h6><h2><?php echo e($stats['totalReviews']); ?></h2>
            </div></div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Последние заказы</h5>
                    <a href="<?php echo e(route('admin.orders')); ?>">Все</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>ID</th><th>Клиент</th><th>Дата</th><th>Статус</th><th></th></tr></thead>
                        <tbody>
                        <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($order->id); ?></td>
                                <td><?php echo e($order->user->name ?? '—'); ?></td>
                                <td><?php echo e($order->date?->format('d.m.Y')); ?></td>
                                <td>
                                    <form action="<?php echo e(route('admin.orders.update', $order)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <?php $__currentLoopData = \App\Models\Order::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" <?php if($order->status === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </form>
                                </td>
                                <td><?php echo e($order->package->title ?? '—'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Пользователи</h5></div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span><?php echo e($u->name); ?> <small class="text-muted"><?php echo e($u->email); ?></small></span>
                                <small><?php echo e($u->phone); ?></small>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-sm btn-outline-secondary mt-2">Все пользователи</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layots', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH W:\domains\laravel-project-fixed\new-repo\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>