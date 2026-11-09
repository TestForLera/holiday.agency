<?php $__env->startSection('admin_title', 'Пакеты'); ?>
<?php $__env->startSection('admin_heading', 'Пакеты услуг'); ?>
<?php $__env->startSection('admin_description', 'Объединяйте программы в выгодные предложения и управляйте скидками.'); ?>

<?php $__env->startSection('admin_content'); ?>
    <details class="admin-create-panel" <?php if($errors->any()): ?> open <?php endif; ?>>
        <summary><span><i class="fas fa-plus"></i> Добавить пакет</span><small>Собрать новое комплексное предложение</small></summary>
        <form action="<?php echo e(route('admin.packages.store')); ?>" method="POST" class="admin-form-grid">
            <?php echo csrf_field(); ?>
            <div class="admin-field span-2"><label>Название</label><input type="text" name="title" value="<?php echo e(old('title')); ?>" required></div>
            <div class="admin-field span-2"><label>Описание</label><textarea name="description" rows="3" required><?php echo e(old('description')); ?></textarea></div>
            <div class="admin-field"><label>Обычная цена, ₽</label><input type="number" name="original_price" min="0" step="0.01" value="<?php echo e(old('original_price')); ?>" required></div>
            <div class="admin-field"><label>Цена пакета, ₽</label><input type="number" name="discounted_price" min="0" step="0.01" value="<?php echo e(old('discounted_price')); ?>" required></div>
            <div class="admin-field"><label>Скидка, %</label><input type="number" name="discount_percent" min="0" max="100" value="<?php echo e(old('discount_percent', 0)); ?>" required></div>
            <div class="admin-field"><label>Порядок</label><input type="number" name="order" value="<?php echo e(old('order', 0)); ?>"></div>
            <div class="admin-field span-2"><label>Программы в пакете</label><div class="admin-checkbox-grid"><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><label><input type="checkbox" name="services_json[]" value="<?php echo e($service->id); ?>" <?php if(in_array($service->id, old('services_json', []))): echo 'checked'; endif; ?>><span><?php echo e($service->title); ?></span></label><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div></div>
            <div class="admin-switch-field"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" id="new-package-active" checked><label for="new-package-active"><span></span>Показывать на сайте</label></div>
            <div class="span-2"><button class="admin-primary-button"><i class="fas fa-plus"></i> Создать пакет</button></div>
        </form>
    </details>

    <div class="admin-entity-grid">
        <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="admin-entity-card">
                <div class="admin-entity-head">
                    <span class="admin-entity-icon package"><i class="fas fa-box-open"></i></span>
                    <div><span>Пакет #<?php echo e($package->id); ?></span><h2><?php echo e($package->title); ?></h2></div>
                    <span class="admin-visibility <?php echo e($package->is_active ? 'active' : 'inactive'); ?>"><?php echo e($package->is_active ? 'На сайте' : 'Скрыт'); ?></span>
                </div>
                <p class="admin-entity-description"><?php echo e(strip_tags($package->description)); ?></p>
                <div class="admin-entity-summary">
                    <span><small>Цена</small><strong><?php echo e(number_format($package->discounted_price, 0, '', ' ')); ?> ₽</strong></span>
                    <span><small>Старая цена</small><strong><?php echo e(number_format($package->original_price, 0, '', ' ')); ?> ₽</strong></span>
                    <span><small>Скидка</small><strong><?php echo e($package->discount_percent); ?>%</strong></span>
                    <span><small>Программ</small><strong><?php echo e(count($package->services_json ?? [])); ?></strong></span>
                </div>

                <details class="admin-edit-panel">
                    <summary><i class="fas fa-pen"></i> Редактировать</summary>
                    <form action="<?php echo e(route('admin.packages.update', $package)); ?>" method="POST" class="admin-form-grid compact">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <div class="admin-field span-2"><label>Название</label><input type="text" name="title" value="<?php echo e($package->title); ?>" required></div>
                        <div class="admin-field span-2"><label>Описание</label><textarea name="description" rows="3" required><?php echo e($package->description); ?></textarea></div>
                        <div class="admin-field"><label>Обычная цена, ₽</label><input type="number" name="original_price" min="0" step="0.01" value="<?php echo e($package->original_price); ?>" required></div>
                        <div class="admin-field"><label>Цена пакета, ₽</label><input type="number" name="discounted_price" min="0" step="0.01" value="<?php echo e($package->discounted_price); ?>" required></div>
                        <div class="admin-field"><label>Скидка, %</label><input type="number" name="discount_percent" min="0" max="100" value="<?php echo e($package->discount_percent); ?>" required></div>
                        <div class="admin-field"><label>Порядок</label><input type="number" name="order" value="<?php echo e($package->order); ?>"></div>
                        <div class="admin-field span-2"><label>Программы в пакете</label><div class="admin-checkbox-grid"><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><label><input type="checkbox" name="services_json[]" value="<?php echo e($service->id); ?>" <?php if(in_array($service->id, $package->services_json ?? [])): echo 'checked'; endif; ?>><span><?php echo e($service->title); ?></span></label><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div></div>
                        <div class="admin-switch-field"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" id="package-active-<?php echo e($package->id); ?>" <?php if($package->is_active): echo 'checked'; endif; ?>><label for="package-active-<?php echo e($package->id); ?>"><span></span>Показывать на сайте</label></div>
                        <div class="span-2"><button class="admin-primary-button"><i class="fas fa-floppy-disk"></i> Сохранить</button></div>
                    </form>
                    <form action="<?php echo e(route('admin.packages.destroy', $package)); ?>" method="POST" class="admin-delete-form" onsubmit="return confirm('Удалить этот пакет?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button><i class="fas fa-trash"></i> Удалить пакет</button></form>
                </details>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="admin-empty-card"><i class="fas fa-box-open"></i><h2>Пакетов пока нет</h2><p>Создайте первое комплексное предложение.</p></div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/admin/packages/index.blade.php ENDPATH**/ ?>