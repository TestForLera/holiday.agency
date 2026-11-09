<?php $__env->startSection('admin_title', 'Отзывы'); ?>
<?php $__env->startSection('admin_heading', 'Отзывы клиентов'); ?>
<?php $__env->startSection('admin_description', 'Проверяйте обратную связь и удаляйте неподходящие публикации.'); ?>
<?php $__env->startSection('admin_content'); ?>
    <section class="admin-card">
    <div class="admin-review-list">
        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="admin-review-item">
                <span class="admin-review-avatar"><?php echo e(mb_strtoupper(mb_substr($review->author_name ?? $review->user->name ?? 'А', 0, 1))); ?></span>
                <div class="admin-review-body">
                    <div class="admin-review-meta"><strong><?php echo e($review->author_name ?? $review->user->name ?? 'Аноним'); ?></strong><span><?php echo e(str_repeat('★', $review->rating)); ?></span></div>
                    <p><?php echo e($review->text); ?></p>
                    <small><?php echo e($review->created_at?->format('d.m.Y H:i')); ?></small>
                </div>
                <form action="<?php echo e(route('admin.reviews.destroy', $review)); ?>" method="POST" onsubmit="return confirm('Удалить отзыв?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="admin-icon-button danger" title="Удалить отзыв"><i class="fas fa-trash"></i></button>
                </form>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted">Отзывов нет</p>
        <?php endif; ?>
    </div>
    <div class="admin-pagination"><?php echo e($reviews->links()); ?></div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/admin/reviews/index.blade.php ENDPATH**/ ?>