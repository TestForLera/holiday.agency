<?php $__env->startSection('title', 'Заказы'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4" style="margin-top:80px;">
    <div class="d-flex justify-content-between mb-3">
        <h2>Заказы</h2>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary btn-sm">← Назад</a>
    </div>
    <?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
    <div class="card"><div class="card-body table-responsive">
        <table class="table align-middle">
            <thead><tr><th>ID</th><th>Клиент</th><th>Телефон</th><th>Дата</th><th>Программа</th><th>Адрес</th><th>Статус</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($order->id); ?></td>
                    <td><?php echo e($order->user->name ?? '—'); ?></td>
                    <td><?php echo e($order->user->phone ?? '—'); ?></td>
                    <td><?php echo e($order->date?->format('d.m.Y')); ?> <?php echo e($order->time); ?></td>
                    <td><?php echo e($order->package->title ?? '—'); ?></td>
                    <td><?php echo e($order->address); ?></td>
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
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($orders->links()); ?>

    </div></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layots', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH W:\domains\pr_agent-main\resources\views/admin/orders.blade.php ENDPATH**/ ?>