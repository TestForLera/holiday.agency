<?php $__env->startSection('title', 'Отзывы'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4" style="margin-top:80px;">
    <div class="d-flex justify-content-between mb-3">
        <h2>Отзывы</h2>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary btn-sm">← Назад</a>
    </div>
    <?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
    <div class="card"><div class="card-body">
        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="border-bottom py-3 d-flex justify-content-between">
                <div>
                    <strong>★ <?php echo e($review->rating); ?></strong>
                    — <?php echo e($review->author_name ?? $review->user->name ?? 'Аноним'); ?>

                    <div><?php echo e($review->text); ?></div>
                    <small class="text-muted"><?php echo e($review->created_at?->format('d.m.Y H:i')); ?></small>
                </div>
                <form action="<?php echo e(route('admin.reviews.destroy', $review)); ?>" method="POST" onsubmit="return confirm('Удалить отзыв?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-sm btn-outline-danger">Удалить</button>
                </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted">Отзывов нет</p>
        <?php endif; ?>
        <?php echo e($reviews->links()); ?>

    </div></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layots', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH W:\domains\pr_agent-main\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>