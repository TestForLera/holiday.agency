<?php $__env->startSection('title', 'Личный кабинет'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5" style="margin-top: 80px;">
    <h2 class="mb-4">Личный кабинет</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="list-group">
                <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="list">Профиль</a>
                <a href="#order-form" class="list-group-item list-group-item-action" data-bs-toggle="list">Заказать поздравление</a>
                <a href="#orders" class="list-group-item list-group-item-action" data-bs-toggle="list">Мои заявки</a>
                <a href="#favorites" class="list-group-item list-group-item-action" data-bs-toggle="list">Избранное</a>
                <a href="#reviews" class="list-group-item list-group-item-action" data-bs-toggle="list">Мои отзывы</a>
            </div>
        </div>

        <div class="col-md-9">
            <!-- Профиль -->
            <div id="profile" class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Личные данные</h5></div>
                <div class="card-body">
                    <form action="<?php echo e(route('update.profile')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ФИО</label>
                                <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Телефон</label>
                                <input type="tel" name="phone" class="form-control" value="<?php echo e(old('phone', $user->phone)); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Аватар</label>
                                <input type="file" name="avatar" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                    <hr>
                    <form action="<?php echo e(route('change.password')); ?>" method="POST" class="row g-2">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-4">
                            <input type="password" name="current_password" class="form-control" placeholder="Текущий пароль" required>
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="new_password" class="form-control" placeholder="Новый пароль" required>
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Повтор пароля" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-secondary btn-sm">Сменить пароль</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Форма заказа -->
            <div id="order-form" class="card mb-4">
                <div class="card-header bg-primary text-white"><h5 class="mb-0">Заказать поздравление</h5></div>
                <div class="card-body">
                    <form action="<?php echo e(route('create.order')); ?>" method="POST" id="orderForm">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">ФИО</label>
                                <input type="text" name="fio" class="form-control" value="<?php echo e(old('fio', $user->name)); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Почта</label>
                                <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Телефон</label>
                                <input type="tel" name="phone" class="form-control" value="<?php echo e(old('phone', $user->phone)); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Количество детей</label>
                                <input type="number" name="children_count" class="form-control" min="1" max="50" value="<?php echo e(old('children_count', 1)); ?>" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Возраст детей (через запятую)</label>
                                <input type="text" name="children_ages" class="form-control" placeholder="например: 5, 7, 10" value="<?php echo e(old('children_ages')); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Тип поздравления</label>
                            <select name="hero_type" id="hero_type" class="form-select" required>
                                <option value="">— выберите —</option>
                                <option value="rostovaya" <?php echo e(old('hero_type')=='rostovaya'?'selected':''); ?>>Ростовая кукла (экспресс-поздравление 15 мин)</option>
                                <option value="animaciya" <?php echo e(old('hero_type')=='animaciya'?'selected':''); ?>>Анимационная программа</option>
                            </select>
                        </div>

                        <div class="row" id="duration-block" style="display:none;">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Длительность</label>
                                <select name="duration" id="duration" class="form-select" required>
                                    <option value="15 минут">15 минут</option>
                                    <option value="30 минут">30 минут</option>
                                    <option value="45 минут">45 минут</option>
                                    <option value="1 час">1 час</option>
                                    <option value="2 часа">2 часа</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3" id="hero-block" style="display:none;">
                            <label class="form-label">Герой</label>
                            <select name="hero_name" id="hero_name" class="form-select" required>
                                <option value="">— сначала выберите тип —</option>
                            </select>
                        </div>

                        <div class="mb-3" id="additional-block" style="display:none;">
                            <label class="form-label">Дополнительные услуги</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="additional[]" value="akvagrim" id="add_akva">
                                <label class="form-check-label" for="add_akva">Аквагрим (+700 ₽, если меньше 10 детей)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="additional[]" value="neon" id="add_neon">
                                <label class="form-check-label" for="add_neon">Неоновое шоу (+1000 ₽)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="additional[]" value="serebro" id="add_serebro">
                                <label class="form-check-label" for="add_serebro">Серебряное шоу (+1000 ₽)</label>
                            </div>
                            <div class="form-check" id="express-check" style="display:none;">
                                <input class="form-check-input" type="checkbox" name="additional[]" value="express" id="add_express">
                                <label class="form-check-label" for="add_express">Экспресс-поздравление ростовой куклы (+1800 ₽)</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Адрес</label>
                                <input type="text" name="address" class="form-control" value="<?php echo e(old('address')); ?>" required placeholder="ул. Примерная, д. 1">
                            </div>
                            <div class="col-md-4 mb-3" id="apartment-block" style="display:none;">
                                <label class="form-label">Квартира</label>
                                <input type="text" name="apartment" class="form-control" value="<?php echo e(old('apartment')); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Дата</label>
                                <input type="date" name="date" class="form-control" value="<?php echo e(old('date')); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Время</label>
                                <input type="time" name="time" class="form-control" value="<?php echo e(old('time')); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Комментарий</label>
                            <textarea name="comment" class="form-control" rows="2"><?php echo e(old('comment')); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg">Отправить заявку</button>
                    </form>
                </div>
            </div>

            <!-- Мои заявки -->
            <div id="orders" class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Мои заявки</h5></div>
                <div class="card-body">
                    <?php if($orders->isEmpty()): ?>
                        <p class="text-muted mb-0">Заявок пока нет. Оформите первую выше!</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Дата / время</th>
                                        <th>Тип / Герой</th>
                                        <th>Длительность</th>
                                        <th>Цена</th>
                                        <th>Статус</th>
                                        <th>Отзыв</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>#<?php echo e($order->id); ?></td>
                                            <td><?php echo e($order->date?->format('d.m.Y')); ?> <?php echo e($order->time); ?></td>
                                            <td>
                                                <?php echo e($order->hero_type === 'rostovaya' ? 'Ростовая' : 'Анимация'); ?><br>
                                                <small><?php echo e($order->hero_name); ?></small>
                                            </td>
                                            <td><?php echo e($order->duration); ?></td>
                                            <td><?php echo e(number_format($order->price, 0, '', ' ')); ?> ₽</td>
                                            <td>
                                                <span class="badge bg-<?php echo e(in_array($order->status, ['completed','zhdet_otzyva']) ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'primary')); ?>">
                                                    <?php echo e($order->status_label); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <?php if(in_array($order->status, ['zhdet_otzyva', 'completed'])): ?>
                                                    <?php if($order->review): ?>
                                                        <span class="text-success">★ <?php echo e($order->review->rating); ?></span>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal<?php echo e($order->id); ?>">Оставить отзыв</button>
                                                        <div class="modal fade" id="reviewModal<?php echo e($order->id); ?>" tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form action="<?php echo e(route('submit.review')); ?>" method="POST">
                                                                        <?php echo csrf_field(); ?>
                                                                        <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Отзыв по заявке #<?php echo e($order->id); ?></h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Оценка</label>
                                                                                <select name="rating" class="form-select" required>
                                                                                    <?php for($i=5;$i>=1;$i--): ?>
                                                                                        <option value="<?php echo e($i); ?>"><?php echo e($i); ?> ★</option>
                                                                                    <?php endfor; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Комментарий</label>
                                                                                <textarea name="comment" class="form-control" rows="3" required></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-primary">Отправить</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    —
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Избранное -->
            <div id="favorites" class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Избранное</h5></div>
                <div class="card-body">
                    <?php if($favorites->isEmpty()): ?>
                        <p class="text-muted">Пока пусто.</p>
                    <?php else: ?>
                        <ul class="list-group">
                            <?php $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>
                                        <?php if($fav->package): ?> Пакет: <?php echo e($fav->package->title); ?>

                                        <?php elseif($fav->hero): ?> Герой: <?php echo e($fav->hero->name); ?>

                                        <?php elseif($fav->service): ?> Услуга: <?php echo e($fav->service->title); ?>

                                        <?php endif; ?>
                                    </span>
                                    <form action="<?php echo e(route('favorite.remove', $fav)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-outline-danger">Удалить</button>
                                    </form>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Отзывы -->
            <div id="reviews" class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Мои отзывы</h5></div>
                <div class="card-body">
                    <?php if($reviews->isEmpty()): ?>
                        <p class="text-muted">Вы ещё не оставляли отзывов.</p>
                    <?php else: ?>
                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-bottom pb-2 mb-2">
                                <strong>★ <?php echo e($r->rating); ?></strong> — <?php echo e($r->content); ?>

                                <br><small class="text-muted"><?php echo e($r->created_at); ?></small>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const heroType = document.getElementById('hero_type');
    const durationBlock = document.getElementById('duration-block');
    const heroBlock = document.getElementById('hero-block');
    const heroSelect = document.getElementById('hero_name');
    const additionalBlock = document.getElementById('additional-block');
    const apartmentBlock = document.getElementById('apartment-block');
    const expressCheck = document.getElementById('express-check');
    const durationSelect = document.getElementById('duration');

    const rostovye = <?php echo json_encode($rostovyeHeroes, 15, 512) ?>;
    const anim = <?php echo json_encode($animHeroes, 15, 512) ?>;

    function updateForm() {
        const type = heroType.value;
        heroSelect.innerHTML = '<option value="">— выберите героя —</option>';
        if (type === 'rostovaya') {
            durationBlock.style.display = 'none';
            durationSelect.value = '15 минут';
            durationSelect.required = false;
            heroBlock.style.display = 'block';
            additionalBlock.style.display = 'none';
            apartmentBlock.style.display = 'none';
            expressCheck.style.display = 'none';
            rostovye.forEach(h => {
                const opt = document.createElement('option');
                opt.value = h; opt.textContent = h;
                heroSelect.appendChild(opt);
            });
        } else if (type === 'animaciya') {
            durationBlock.style.display = 'block';
            durationSelect.required = true;
            heroBlock.style.display = 'block';
            additionalBlock.style.display = 'block';
            apartmentBlock.style.display = 'block';
            expressCheck.style.display = 'block';
            anim.forEach(h => {
                const opt = document.createElement('option');
                opt.value = h; opt.textContent = h;
                heroSelect.appendChild(opt);
            });
        } else {
            durationBlock.style.display = 'none';
            heroBlock.style.display = 'none';
            additionalBlock.style.display = 'none';
            apartmentBlock.style.display = 'none';
        }
    }
    heroType.addEventListener('change', updateForm);
    updateForm();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layots', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH W:\domains\laravel-project-fixed\new-repo\resources\views/user/cabinet.blade.php ENDPATH**/ ?>