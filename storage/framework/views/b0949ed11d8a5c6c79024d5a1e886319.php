<?php $__env->startSection('title', 'Программы и цены'); ?>

<?php $__env->startSection('content'); ?>
    <section class="services-page">
        <div class="services-hero">
            <a href="<?php echo e(url('/#programs')); ?>" class="services-back">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                На главную
            </a>
            <span class="services-eyebrow">Выберите формат праздника</span>
            <h1>Программы и цены</h1>
            <p>Яркие поздравления для любого возраста. Выберите программу — остальные детали уточним при оформлении.</p>
        </div>

        <div class="services-grid">
            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="service-card">
                    <div class="service-card-top">
                        <span class="service-number"><?php echo e(str_pad($loop->iteration, 2, '0', STR_PAD_LEFT)); ?></span>
                        <?php if($service->discount_percent): ?>
                            <span class="service-discount">−<?php echo e($service->discount_percent); ?>%</span>
                        <?php endif; ?>
                    </div>

                    <div class="service-icon" aria-hidden="true">
                        <i class="fas <?php echo e($loop->first ? 'fa-gift' : 'fa-wand-magic-sparkles'); ?>"></i>
                    </div>

                    <h2><?php echo e($service->title); ?></h2>

                    <?php if($service->duration): ?>
                        <div class="service-duration">
                            <i class="far fa-clock" aria-hidden="true"></i>
                            <?php echo e($service->duration); ?>

                        </div>
                    <?php endif; ?>

                    <p class="service-description"><?php echo e(strip_tags($service->description)); ?></p>

                    <?php if($service->features->isNotEmpty()): ?>
                        <ul class="service-features">
                            <?php $__currentLoopData = $service->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><i class="fas fa-check" aria-hidden="true"></i><?php echo e($feature->feature_text); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>

                    <?php if($service->heroes->isNotEmpty()): ?>
                        <div class="service-heroes">
                            <strong>Герои на выбор</strong>
                            <div class="service-hero-tags">
                                <?php $__currentLoopData = $service->heroes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hero): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><?php echo e($hero->name); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="service-card-footer">
                        <div class="service-price">
                            <?php if($service->discounted_price): ?>
                                <span class="service-old-price"><?php echo e(number_format($service->price, 0, '', ' ')); ?> ₽</span>
                                <strong><?php echo e(number_format($service->discounted_price, 0, '', ' ')); ?> ₽</strong>
                            <?php else: ?>
                                <small>Стоимость</small>
                                <strong><?php echo e(number_format($service->price, 0, '', ' ')); ?> ₽</strong>
                            <?php endif; ?>
                        </div>

                        <a href="<?php echo e(route('services.order', $service)); ?>" class="service-order-button">
                            Заказать
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="services-empty">Активных программ пока нет.</div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layots', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mihailbogatov/study/4course/CourseWorkLera/holiday.agency/resources/views/services/index.blade.php ENDPATH**/ ?>