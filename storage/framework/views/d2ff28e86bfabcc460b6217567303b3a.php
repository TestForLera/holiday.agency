<?php $__env->startSection('admin_title', 'Заявки'); ?>
<?php $__env->startSection('admin_heading', 'Заявки клиентов'); ?>
<?php $__env->startSection('admin_description', 'Контакты, детали праздника и текущий этап обработки заказа.'); ?>
<?php $__env->startSection('admin_content'); ?>
    <section class="admin-card">
        <div class="admin-card-header"><div><span>Все обращения</span><h2><?php echo e($orders->total()); ?> заявок</h2></div></div>
        <div class="admin-table-wrap">
        <table class="admin-table admin-orders-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Контакты</th>
                    <th>Дата/время</th>
                    <th>Тип / Герой</th>
                    <th>Дети</th>
                    <th>Адрес</th>
                    <th>Цена</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><strong>#<?php echo e($order->id); ?></strong></td>
                    <td><strong><?php echo e($order->fio ?? $order->user->name ?? '—'); ?></strong></td>
                    <td>
                        <small><?php echo e($order->email ?? $order->user->email ?? ''); ?><br>
                        <?php echo e($order->phone ?? $order->user->phone ?? ''); ?></small>
                    </td>
                    <td><?php echo e($order->date?->format('d.m.Y')); ?> <?php echo e($order->time); ?></td>
                    <td>
                        <?php echo e($order->hero_type === 'rostovaya' ? 'Ростовая' : ($order->hero_type === 'animaciya' ? 'Анимация' : '—')); ?>

                        <br><small><?php echo e($order->hero_name); ?> (<?php echo e($order->duration); ?>)</small>
                        <?php if($order->additional_services): ?>
                            <br><small class="text-muted"><?php echo e(implode(', ', $order->additional_services)); ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($order->children_count); ?> чел.<br><small><?php echo e($order->children_ages); ?></small></td>
                    <td><?php echo e($order->address); ?><?php if($order->apartment): ?>, кв. <?php echo e($order->apartment); ?><?php endif; ?></td>
                    <td><?php echo e(number_format($order->price ?? 0, 0, '', ' ')); ?> ₽</td>
                    <td>
                        <form action="<?php echo e(route('admin.orders.update', $order)); ?>" method="POST" class="admin-status-form">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" aria-label="Статус заявки #<?php echo e($order->id); ?>">
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
        </div>
        <div class="admin-pagination"><?php echo e($orders->links()); ?></div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/admin/orders.blade.php ENDPATH**/ ?>