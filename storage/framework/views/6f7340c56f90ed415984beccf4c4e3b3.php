<?php $__env->startSection('title', 'Регистрация'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-3">
        <h3 class="text-center display-3">
            Регистрация
        </h3>
        <hr>

        <?php if($errors->any()): ?>
            <div class="border border-danger text-danger alert alert-danger p-3 my-3 mx-auto w-50">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($error); ?><br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <form action="<?php echo e(route('storeRegister')); ?>" method="post" class="w-50 m-auto">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="surname" class="form-label fs-5">Укажите фамилия *</label>
                <input type="text" class="form-control shadow-sm px-3 rounded" id="surname" name="surname" required
                    title="Формат: кирилица и пробелы">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label fs-5">Укажите имя *</label>
                <input type="text" class="form-control shadow-sm px-3 rounded" id="name" name="name" required
                    title="Формат: кирилица и пробелы">
            </div>
            <div class="mb-3">
                <label for="patronymic" class="form-label fs-5">Укажите Отчество *</label>
                <input type="text" class="form-control shadow-sm px-3 rounded" id="patronymic" name="patronymic" required
                    title="Формат: кирилица и пробелы">
            </div>
            <div class="mb-3">
                <label for="login" class="form-label fs-5">Укажите логин *</label>
                <input type="text" class="form-control shadow-sm px-3 rounded" id="login" name="login" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label fs-5">Укажите телефон *</label>
                <input type="tel" class="form-control shadow-sm px-3 rounded" id="phone" name="phone" required
                    maxlength="30" title="Формат: +7 (ХХХ) -ХХХ-ХХ-ХХ" placeholder="+7 (___) ___-__-__">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fs-5">Укажите email *</label>
                <input type="email" class="form-control shadow-sm px-3 rounded" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fs-5">Укажите пароль *</label>
                <input type="password" class="form-control shadow-sm px-3 rounded" id="password" name="password" required
                    title="Формат: минимум 6 символ">
            </div>
            <div class="mb-3">
                <label>Повторите пароль</label>
                <input type="password" name="password_confirmation" class="form-control" required minlength="6">
            </div>

            <input type="submit" class="btn btn-primary w-100 shadow-sm p-3 rounded fw-bold" value="Зарегистрироваться">
        </form>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layots', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/registration.blade.php ENDPATH**/ ?>