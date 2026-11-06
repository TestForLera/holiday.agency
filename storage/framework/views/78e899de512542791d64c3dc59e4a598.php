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
                <a href="#profile" class="list-group-item list-group-item-action active">Профиль</a>
                <a href="#orders" class="list-group-item list-group-item-action">Мои заказы</a>
                <a href="#favorites" class="list-group-item list-group-item-action">Избранное</a>
                <a href="#reviews" class="list-group-item list-group-item-action">Отзывы</a>
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
                                <?php if($user->avatar): ?>
                                    <div class="mb-2"><img src="<?php echo e(asset('storage/'.$user->avatar)); ?>" alt="" style="max-height:80px" class="rounded"></div>
                                <?php endif; ?>
                                <input type="file" name="avatar" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить данные</button>
                    </form>

                    <hr class="my-4">
                    <h6>Сменить пароль</h6>
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
                            <button type="submit" class="btn btn-warning btn-sm">Сменить пароль</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Заказы -->
            <div id="orders" class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Заказы анимационных программ</h5></div>
                <div class="card-body">
                    <?php if($orders->isEmpty()): ?>
                        <p class="text-muted mb-0">Заказов пока нет.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Дата</th>
                                        <th>Программа</th>
                                        <th>Статус</th>
                                        <th>Адрес</th>
                                        <th>Отзыв</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($order->id); ?></td>
                                            <td><?php echo e($order->date?->format('d.m.Y')); ?> <?php echo e($order->time); ?></td>
                                            <td><?php echo e($order->package->title ?? $order->package->name ?? '—'); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'secondary')); ?>">
                                                    <?php echo e($order->status_label); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e($order->address); ?></td>
                                            <td>
                                                <?php if($order->status === 'completed'): ?>
                                                    <?php if($order->review): ?>
                                                        <span class="text-success">★ <?php echo e($order->review->rating); ?></span>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal<?php echo e($order->id); ?>">
                                                            Оставить отзыв
                                                        </button>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    —
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <?php if($order->status === 'completed' && !$order->review): ?>
                                        <div class="modal fade" id="reviewModal<?php echo e($order->id); ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="<?php echo e(route('submit.review')); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Отзыв по заказу #<?php echo e($order->id); ?></h5>
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
                        <p class="text-muted mb-0">В избранном пока пусто.</p>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div class="border rounded p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <?php if($fav->package): ?>
                                                <strong><?php echo e($fav->package->title ?? $fav->package->name); ?></strong>
                                                <div class="small text-muted">Пакет / программа</div>
                                            <?php elseif($fav->hero): ?>
                                                <strong><?php echo e($fav->hero->name); ?></strong>
                                                <div class="small text-muted">Герой</div>
                                            <?php elseif($fav->service): ?>
                                                <strong><?php echo e($fav->service->title ?? $fav->service->name); ?></strong>
                                                <div class="small text-muted">Услуга</div>
                                            <?php endif; ?>
                                        </div>
                                        <form action="<?php echo e(route('favorite.remove', $fav)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-sm btn-outline-danger">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Мои отзывы -->
            <div id="reviews" class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Мои отзывы</h5></div>
                <div class="card-body">
                    <?php if($reviews->isEmpty()): ?>
                        <p class="text-muted mb-0">Вы ещё не оставляли отзывов.</p>
                    <?php else: ?>
                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-bottom py-2">
                                <div class="fw-bold">★ <?php echo e($review->rating); ?></div>
                                <div><?php echo e($review->text); ?></div>
                                <div class="small text-muted"><?php echo e($review->created_at?->format('d.m.Y')); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layots', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH W:\domains\pr_agent-main\resources\views/user/cabinet.blade.php ENDPATH**/ ?>