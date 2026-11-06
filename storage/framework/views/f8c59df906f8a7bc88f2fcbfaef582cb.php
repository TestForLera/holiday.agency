<?php $__env->startSection('title', 'Контент сайта'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4" style="margin-top:80px;">
    <div class="d-flex justify-content-between mb-3">
        <h2>Редактирование контента</h2>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary btn-sm">← Назад</a>
    </div>

    <?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger"><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Главная страница</h5></div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.content.update')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Заголовок (герой)</label>
                        <input type="text" name="hero_title" class="form-control" value="<?php echo e(old('hero_title', $settings->hero_title)); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Подзаголовок / промо-текст</label>
                        <input type="text" name="hero_subtitle" class="form-control" value="<?php echo e(old('hero_subtitle', $settings->hero_subtitle)); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Текст на главной</label>
                        <input type="text" name="main_text" class="form-control" value="<?php echo e(old('main_text', $settings->main_text)); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Промокод</label>
                        <input type="text" name="promo_code" class="form-control" value="<?php echo e(old('promo_code', $settings->promo_code)); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Текст к промокоду</label>
                        <input type="text" name="promo_text" class="form-control" value="<?php echo e(old('promo_text', $settings->promo_text)); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Картинка героя (прозрачный PNG предпочтителен)</label>
                        <?php if($settings->hero_image): ?>
                            <div class="mb-2 p-2" style="background: repeating-conic-gradient(#ccc 0% 25%, #fff 0% 50%) 50% / 20px 20px;">
                                <img src="<?php echo e(asset('storage/'.$settings->hero_image)); ?>" alt="hero" style="max-height:120px">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="hero_image" class="form-control" accept="image/*">
                        <small class="text-muted">Загружайте PNG с прозрачным фоном</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Заголовок «Почему мы»</label>
                        <input type="text" name="why_us_title" class="form-control" value="<?php echo e(old('why_us_title', $settings->why_us_title)); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Текст «Почему мы»</label>
                        <textarea name="why_us_text" class="form-control" rows="5"><?php echo e(old('why_us_text', $settings->why_us_text)); ?></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Сохранить контент</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Слайдер (герои / программы)</h5></div>
        <div class="card-body">
            <h6>Добавить слайд</h6>
            <form action="<?php echo e(route('admin.slides.store')); ?>" method="POST" enctype="multipart/form-data" class="row g-2 mb-4">
                <?php echo csrf_field(); ?>
                <div class="col-md-3"><input type="text" name="title" class="form-control" placeholder="Заголовок" required></div>
                <div class="col-md-3"><input type="text" name="text" class="form-control" placeholder="Текст"></div>
                <div class="col-md-3"><input type="file" name="image" class="form-control" accept="image/*" required></div>
                <div class="col-md-2"><input type="number" name="sort_order" class="form-control" placeholder="Порядок" value="0"></div>
                <div class="col-md-1"><button class="btn btn-success w-100">+</button></div>
            </form>

            <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border rounded p-3 mb-3">
                    <form action="<?php echo e(route('admin.slides.update', $slide->id)); ?>" method="POST" enctype="multipart/form-data" class="row g-2 align-items-center">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-2">
                            <?php if($slide->image_path): ?>
                                <img src="<?php echo e(asset('storage/'.$slide->image_path)); ?>" alt="" style="max-height:60px" class="rounded">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-2"><input type="text" name="title" class="form-control form-control-sm" value="<?php echo e($slide->title); ?>" required></div>
                        <div class="col-md-3"><input type="text" name="text" class="form-control form-control-sm" value="<?php echo e($slide->text ?? ''); ?>"></div>
                        <div class="col-md-2"><input type="file" name="image" class="form-control form-control-sm" accept="image/*"></div>
                        <div class="col-md-1"><input type="number" name="sort_order" class="form-control form-control-sm" value="<?php echo e($slide->sort_order ?? 0); ?>"></div>
                        <div class="col-md-2 d-flex gap-1">
                            <button class="btn btn-sm btn-primary">Сохранить</button>
                        </div>
                    </form>
                    <form action="<?php echo e(route('admin.slides.destroy', $slide->id)); ?>" method="POST" class="mt-1" onsubmit="return confirm('Удалить слайд?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-outline-danger">Удалить</button>
                    </form>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layots', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH W:\domains\laravel-project-fixed\new-repo\resources\views/admin/content/edit.blade.php ENDPATH**/ ?>