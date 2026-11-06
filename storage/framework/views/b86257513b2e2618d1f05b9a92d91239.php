<?php $__env->startSection('title', 'Поздравление ростовых кукл в Челябинске'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Главная секция -->
    <section class="hero-section" id='hero'>
        <div class="container h-100">
            <div class="hero-content">
                <img src="<?php echo e(asset('img/logo.png')); ?>" alt="Логотип" class="hero-logo">

                <h1 class="hero-title"><?php echo e($hero_title); ?></h1>
                <div class="hero-highlight">
                    <img src="<?php echo e(asset('img/podarok.png')); ?>" alt="Подарок">
                    <span><?php echo e($hero_subtitle); ?></span>
                </div>
                <div class="hero-phone">8 (908) 070 33-42</div>
                <?php if(!empty($promo_code)): ?>
                    <div class="mt-3">
                        <span class="badge bg-danger fs-6">Промокод: <?php echo e($promo_code); ?></span>
                        <?php if(!empty($promo_text)): ?>
                            <span class="ms-2"><?php echo e($promo_text); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="dolls-container">
                <?php if(!empty($hero_image)): ?>
                    <img src="<?php echo e(asset('storage/'.$hero_image)); ?>" class="doll" alt="Герой" style="background: transparent;">
                <?php endif; ?>
                <img src="<?php echo e(asset('img/зая.png')); ?>" class="doll zai" alt="Зая">
                <img src="<?php echo e(asset('img/капи.png')); ?>" class="doll kapi" alt="Капибара">
                <img src="<?php echo e(asset('img/мишка.png')); ?>" class="doll bearn" alt="Мишка">
                <img src="<?php echo e(asset('img/чеба.png')); ?>" class="doll cheba" alt="Чебурашка">
            </div>
        </div>
    </section>

    <!-- Секция с героями -->
    <section class="slider-section">
        <h2 class="section-title" id='heroes'>НАШИ ГЕРОИ</h2>

        <div class="slider-container">
            <button class="nav-btn prev">‹</button>
            <div class="slider" id="slider">
                <?php $__empty_1 = true; $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="slide">
                        <div class="slide-content">
                            <img src="<?php echo e(asset($slide->image_path)); ?>" alt="<?php echo e($slide->title); ?>">
                            <h3><?php echo e($slide->title); ?></h3>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="slide">
                        <div class="slide-content">
                            <div class="no-slides">Герои скоро появятся</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <button class="nav-btn next">›</button>
        </div>
    </section>

    <!-- Секция с программами -->
    <section class="programs-section">
        <h1 class="section-title" id='programm'>НАШИ ПРОГРАММЫ</h1>
        <div class="programs-container">
            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="<?php echo e(asset('img/1.jpg')); ?>" alt="<?php echo e($service->title); ?>" class="program-image">
                    </div>
                    <div class="program-content">
                        <h3 class="program-title"><?php echo e($service->title); ?></h3>
                        <p class="program-description"><?php echo e(\Illuminate\Support\Str::limit($service->description, 120)); ?></p>
                        <p class="program-price">
                            <?php if($service->discounted_price): ?>
                                <s><?php echo e(number_format($service->price, 0, '', ' ')); ?> ₽</s>
                                <?php echo e(number_format($service->discounted_price, 0, '', ' ')); ?> ₽
                            <?php else: ?>
                                от <?php echo e(number_format($service->price, 0, '', ' ')); ?> ₽
                            <?php endif; ?>
                        </p>
                        <a href="<?php echo e(route('services.index')); ?>" class="btn-more">Подробнее</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="no-programs">Программы не найдены.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Секция "Почему мы" -->
    <section class="reasons-section" id="reasons">
        <h2 class="section-title">ПОЧЕМУ МЫ?</h2>
        <div class="reasons-grid">
            <div class="reason-item">К каждому празднику подбираем индивидуальный подход</div>
            <div class="reason-item">Большой опыт работы</div>
            <div class="reason-item">Дарим незабываемые эмоции</div>
            <div class="reason-item">Организуем срочные заказы в день мероприятия</div>
            <div class="reason-item">Уникальные ростовые куклы</div>
            <div class="reason-item">Классные и яркие фото</div>
        </div>
    </section>

    <!-- Секция с локациями -->
    <section class="locations-section">
        <div class="locations-container">
            <h2 class="section-title locations-title">ГДЕ МЫ МОЖЕМ ПРОВЕСТИ ПРАЗДНИК</h2>
            <div class="locations-content">
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-home"></i></div>
                    <h3>В доме, на даче или в квартире</h3>
                </div>
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-tree"></i></div>
                    <h3>На улице, в парке</h3>
                </div>
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-school"></i></div>
                    <h3>В школе, садике</h3>
                </div>
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-utensils"></i></div>
                    <h3>В ресторане, кафе</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Секция с отзывами -->
    <section class="reviews-section" id='reviews'>
        <h2 class="section-title">ОТЗЫВЫ НАШИХ КЛИЕНТОВ</h2>
        <div class="reviews-container">
            <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="review-card">
                    <div class="review-header">
                        <?php if($review->avatar_url): ?>
                            <img src="<?php echo e(asset($review->avatar_url)); ?>" alt="<?php echo e($review->author_name); ?>"
                                class="review-avatar">
                        <?php endif; ?>
                        <div>
                            <strong><?php echo e($review->author_name); ?></strong>
                            <div class="review-category"><?php echo e($review->category); ?></div>
                        </div>
                    </div>

                    <div class="review-rating">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?php echo e($i <= $review->rating ? 'filled' : ''); ?>">★</span>
                        <?php endfor; ?>
                    </div>

                    <p class="review-text"><?php echo nl2br(e($review->content)); ?></p>

                    <?php if($review->photo_url): ?>
                        <img src="<?php echo e(asset($review->photo_url)); ?>" alt="Фото к отзыву" class="review-photo">
                    <?php endif; ?>

                    <small class="review-date"><?php echo e($review->created_at); ?></small>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="no-reviews">Отзывов пока нет. Будьте первым!</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Модальное окно с промокодом -->
    <div id="promoModal" class="promo-modal" style="display: none;">
        <div class="promo-modal-content">
            <span class="promo-modal-close">&times;</span>
            <div class="promo-content">
                <h2>Ваш промокод!</h2>
                <p class="promo-code">KUKLA2025</p>
                <p class="promo-desc">Скидка 15% на любую программу при заказе до конца месяца!</p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layots', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH W:\domains\laravel-project-fixed\new-repo\resources\views/index.blade.php ENDPATH**/ ?>