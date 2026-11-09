<?php $__env->startSection('title', 'Личный кабинет'); ?>

<?php $__env->startSection('content'); ?>
    <h2>Личный кабинет</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="profile-card">
        <h3><?php echo e(Auth::user()->name); ?></h3>
        <p>Email: <?php echo e(Auth::user()->email); ?></p>
        <p>Телефон: <?php echo e(Auth::user()->phone); ?></p>

        <?php if(Auth::user()->avatar): ?>
            <img src="<?php echo e(asset(Storage::url(Auth::user()->avatar))); ?>" alt="Аватар" class="avatar-img">
        <?php else: ?>
            <img src="<?php echo e(asset('img/default-avatar.jpg')); ?>" alt="Аватар">
        <?php endif; ?>
    </div>

    <!-- Ссылка на админку только для админов -->
    <?php if(Auth::user()->role === 'admin'): ?>
        <a href="<?php echo e(route('admin.services.index')); ?>" class="btn btn-admin">Панель администратора</a>
    <?php endif; ?>

    <form action="<?php echo e(route('update.profile')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <label>ФИО</label>
        <input type="text" name="name" value="<?php echo e(Auth::user()->name); ?>" required>

        <label>Телефон</label>
        <input type="tel" name="phone" value="<?php echo e(Auth::user()->phone); ?>">

        <label>Аватар</label>
        <input type="file" name="avatar" accept="image/*">

        <button type="submit" class="btn">Сохранить профиль</button>
    </form>

    <hr>

    <h3>Ваши заказы</h3>
    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="order-item">
            <strong>Заказ #<?php echo e($order->id); ?></strong>
            <p>Программа: <?php echo e($order->program?->name); ?></p>
            <p>Дата: <?php echo e($order->order_date); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p>У вас пока нет заказов.</p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/cabinet/index.blade.php ENDPATH**/ ?>