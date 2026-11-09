<?php $__env->startSection('admin_title', 'Программы'); ?>
<?php $__env->startSection('admin_heading', 'Программы и цены'); ?>
<?php $__env->startSection('admin_description', 'Управляйте описаниями, длительностью, стоимостью и видимостью программ на сайте.'); ?>

<?php $__env->startSection('admin_content'); ?>
    <details class="admin-create-panel" <?php if($errors->any()): ?> open <?php endif; ?>>
        <summary><span><i class="fas fa-plus"></i> Добавить программу</span><small>Создать новую карточку на странице цен</small></summary>
        <form action="<?php echo e(route('admin.services.store')); ?>" method="POST" class="admin-form-grid">
            <?php echo csrf_field(); ?>
            <div class="admin-field span-2"><label>Название</label><input type="text" name="title" value="<?php echo e(old('title')); ?>" required></div>
            <div class="admin-field span-2"><label>Описание</label><textarea name="description" rows="3" required><?php echo e(old('description')); ?></textarea></div>
            <div class="admin-field"><label>Длительность</label><input type="text" name="duration" value="<?php echo e(old('duration')); ?>" placeholder="Например, 30 минут"></div>
            <div class="admin-field"><label>Порядок</label><input type="number" name="order" value="<?php echo e(old('order', 0)); ?>"></div>
            <div class="admin-field"><label>Обычная цена, ₽</label><input type="number" name="price" min="0" step="0.01" value="<?php echo e(old('price')); ?>" required></div>
            <div class="admin-field"><label>Цена со скидкой, ₽</label><input type="number" name="discounted_price" min="0" step="0.01" value="<?php echo e(old('discounted_price')); ?>"></div>
            <div class="admin-field"><label>Скидка, %</label><input type="number" name="discount_percent" min="0" max="100" value="<?php echo e(old('discount_percent')); ?>"></div>
            <div class="admin-switch-field"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" id="new-service-active" checked><label for="new-service-active"><span></span>Показывать на сайте</label></div>
            <div class="admin-field span-2"><label>Особенности программы</label><input type="text" name="features[]" placeholder="Первая особенность"><input type="text" name="features[]" placeholder="Вторая особенность"><input type="text" name="features[]" placeholder="Третья особенность"></div>
            <div class="span-2"><button class="admin-primary-button"><i class="fas fa-plus"></i> Создать программу</button></div>
        </form>
    </details>

    <div class="admin-entity-grid">
        <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="admin-entity-card" id="service-<?php echo e($service->id); ?>">
                <div class="admin-entity-head">
                    <span class="admin-entity-icon"><i class="fas fa-wand-magic-sparkles"></i></span>
                    <div><span>Программа #<?php echo e($service->id); ?></span><h2><?php echo e($service->title); ?></h2></div>
                    <span class="admin-visibility <?php echo e($service->is_active ? 'active' : 'inactive'); ?>"><?php echo e($service->is_active ? 'На сайте' : 'Скрыта'); ?></span>
                </div>
                <div class="admin-entity-summary">
                    <span><small>Длительность</small><strong><?php echo e($service->duration ?: 'Не указана'); ?></strong></span>
                    <span><small>Цена</small><strong><?php echo e(number_format($service->discounted_price ?? $service->price, 0, '', ' ')); ?> ₽</strong></span>
                    <span><small>Особенности</small><strong><?php echo e($service->features_count); ?></strong></span>
                    <span><small>Герои</small><strong><?php echo e($service->heroes_count); ?></strong></span>
                </div>

                <details class="admin-edit-panel">
                    <summary><i class="fas fa-pen"></i> Редактировать</summary>
                    <form action="<?php echo e(route('admin.services.update', $service)); ?>" method="POST" class="admin-form-grid compact">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <div class="admin-field span-2"><label>Название</label><input type="text" name="title" value="<?php echo e($service->title); ?>" required></div>
                        <div class="admin-field span-2"><label>Описание</label><textarea name="description" rows="3" required><?php echo e($service->description); ?></textarea></div>
                        <div class="admin-field"><label>Длительность</label><input type="text" name="duration" value="<?php echo e($service->duration); ?>"></div>
                        <div class="admin-field"><label>Порядок</label><input type="number" name="order" value="<?php echo e($service->order); ?>"></div>
                        <div class="admin-field"><label>Обычная цена, ₽</label><input type="number" name="price" min="0" step="0.01" value="<?php echo e($service->price); ?>" required></div>
                        <div class="admin-field"><label>Цена со скидкой, ₽</label><input type="number" name="discounted_price" min="0" step="0.01" value="<?php echo e($service->discounted_price); ?>"></div>
                        <div class="admin-field"><label>Скидка, %</label><input type="number" name="discount_percent" min="0" max="100" value="<?php echo e($service->discount_percent); ?>"></div>
                        <div class="admin-switch-field"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" id="service-active-<?php echo e($service->id); ?>" <?php if($service->is_active): echo 'checked'; endif; ?>><label for="service-active-<?php echo e($service->id); ?>"><span></span>Показывать на сайте</label></div>
                        <div class="span-2 admin-form-actions"><button class="admin-primary-button"><i class="fas fa-floppy-disk"></i> Сохранить</button></div>
                    </form>
                    <form action="<?php echo e(route('admin.services.destroy', $service)); ?>" method="POST" class="admin-delete-form" onsubmit="return confirm('Удалить эту программу?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button><i class="fas fa-trash"></i> Удалить программу</button>
                    </form>
                </details>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="admin-empty-card"><i class="fas fa-wand-magic-sparkles"></i><h2>Программ пока нет</h2><p>Добавьте первую программу с помощью формы выше.</p></div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/admin/services/index.blade.php ENDPATH**/ ?>