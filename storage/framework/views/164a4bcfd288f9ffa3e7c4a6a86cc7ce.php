<?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="package-card">
        <h3><?php echo e($package->title); ?></h3>
        <p><?php echo $package->description; ?></p>
        
        <div class="price">
            <span class="old-price"><?php echo e($package->original_price); ?> руб.</span>
            <span class="new-price"><?php echo e($package->discounted_price); ?> руб.</span>
            <span class="discount">Экономия <?php echo e($package->discount_percent); ?>%</span>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/packages/index.blade.php ENDPATH**/ ?>