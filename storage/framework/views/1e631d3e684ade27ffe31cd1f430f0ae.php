<?php $__env->startSection('admin_title', 'Герои'); ?>
<?php $__env->startSection('admin_heading', 'Герои и персонажи'); ?>
<?php $__env->startSection('admin_description', 'Добавляйте персонажей, изображения и управляйте их видимостью.'); ?>
<?php $__env->startSection('admin_content'); ?>

    <div class="admin-card mb-4">
        <div class="admin-card-header"><div><span>Новый персонаж</span><h2>Добавить героя</h2></div></div>
        <div class="admin-card-body">
            <form action="<?php echo e(route('admin.heroes.store')); ?>" method="POST" enctype="multipart/form-data" class="row g-2">
                <?php echo csrf_field(); ?>
                <div class="col-md-3"><input type="text" name="name" class="form-control" placeholder="Имя" required></div>
                <div class="col-md-3"><input type="text" name="description" class="form-control" placeholder="Описание"></div>
                <div class="col-md-3"><input type="file" name="image" class="form-control" accept="image/*"></div>
                <div class="col-md-1"><input type="number" name="sort_order" class="form-control" value="0"></div>
                <div class="col-md-2"><button class="btn btn-success w-100">Добавить</button></div>
            </form>
        </div>
    </div>

    <div class="row g-3">
        <?php $__currentLoopData = $heroes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hero): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6">
                <div class="card h-100 admin-hero-card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.heroes.update', $hero)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <div class="d-flex gap-3 mb-2">
                                <?php if($hero->image): ?>
                                    <img src="<?php echo e(asset('storage/'.$hero->image)); ?>" alt="" style="max-height:80px; background: repeating-conic-gradient(#ccc 0% 25%, #fff 0% 50%) 50% / 16px 16px;" class="rounded">
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <input type="text" name="name" class="form-control mb-2" value="<?php echo e($hero->name); ?>" required>
                                    <textarea name="description" class="form-control mb-2" rows="2"><?php echo e($hero->description); ?></textarea>
                                    <input type="file" name="image" class="form-control form-control-sm mb-2" accept="image/*">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="number" name="sort_order" class="form-control form-control-sm" style="width:80px" value="<?php echo e($hero->sort_order); ?>">
                                        <div class="form-check">
                                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="active<?php echo e($hero->id); ?>" <?php if($hero->is_active): echo 'checked'; endif; ?>>
                                            <label class="form-check-label" for="active<?php echo e($hero->id); ?>">Активен</label>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form action="<?php echo e(route('admin.heroes.destroy', $hero)); ?>" method="POST" onsubmit="return confirm('Удалить?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/admin/heroes/index.blade.php ENDPATH**/ ?>