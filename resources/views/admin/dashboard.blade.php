@extends('admin.layout')

@section('admin_title', 'Обзор')
@section('admin_heading', 'Добро пожаловать!')
@section('admin_description', 'Краткая сводка по сайту и последние действия клиентов.')

@section('admin_content')
    <div class="admin-stats-grid">
        <a href="{{ route('admin.users') }}" class="admin-stat-card stat-blue">
            <span class="admin-stat-icon"><i class="fas fa-users"></i></span>
            <span><small>Пользователи</small><strong>{{ $stats['totalUsers'] }}</strong><em>Все клиенты</em></span>
            <i class="fas fa-arrow-right admin-stat-arrow"></i>
        </a>
        <a href="{{ route('admin.orders') }}" class="admin-stat-card stat-green">
            <span class="admin-stat-icon"><i class="fas fa-clipboard-check"></i></span>
            <span><small>Всего заявок</small><strong>{{ $stats['totalOrders'] }}</strong><em>За всё время</em></span>
            <i class="fas fa-arrow-right admin-stat-arrow"></i>
        </a>
        <a href="{{ route('admin.orders') }}" class="admin-stat-card stat-orange">
            <span class="admin-stat-icon"><i class="fas fa-clock"></i></span>
            <span><small>Требуют внимания</small><strong>{{ $stats['pendingOrders'] }}</strong><em>Новые и в работе</em></span>
            <i class="fas fa-arrow-right admin-stat-arrow"></i>
        </a>
        <a href="{{ route('admin.reviews') }}" class="admin-stat-card stat-pink">
            <span class="admin-stat-icon"><i class="fas fa-star"></i></span>
            <span><small>Отзывы</small><strong>{{ $stats['totalReviews'] }}</strong><em>Опубликовано</em></span>
            <i class="fas fa-arrow-right admin-stat-arrow"></i>
        </a>
    </div>

    <div class="admin-quick-actions">
        <a href="{{ route('admin.services.index') }}"><i class="fas fa-plus"></i><span><strong>Добавить программу</strong><small>Цены и описание</small></span></a>
        <a href="{{ route('admin.heroes.index') }}"><i class="fas fa-masks-theater"></i><span><strong>Добавить героя</strong><small>Каталог персонажей</small></span></a>
        <a href="{{ route('admin.content.edit') }}"><i class="fas fa-pen-to-square"></i><span><strong>Изменить главную</strong><small>Тексты и слайдер</small></span></a>
    </div>

    <div class="admin-dashboard-grid">
        <section class="admin-card admin-orders-card">
            <div class="admin-card-header">
                <div><span>Последние события</span><h2>Новые заявки</h2></div>
                <a href="{{ route('admin.orders') }}">Смотреть все <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Заявка</th><th>Клиент</th><th>Дата</th><th>Программа</th><th>Статус</th></tr></thead>
                    <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td><strong>{{ $order->fio ?? $order->user->name ?? 'Без имени' }}</strong><small>{{ $order->phone ?? $order->user->phone ?? '' }}</small></td>
                            <td>{{ $order->date?->format('d.m.Y') }}<small>{{ $order->time }}</small></td>
                            <td>{{ $order->service->title ?? $order->hero_name ?? '—' }}</td>
                            <td><span class="admin-status status-{{ $order->status }}">{{ $order->status_label }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="admin-empty">Заявок пока нет</div></td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="admin-card admin-clients-card">
            <div class="admin-card-header">
                <div><span>Недавно зарегистрировались</span><h2>Новые клиенты</h2></div>
                <a href="{{ route('admin.users') }}">Все</a>
            </div>
            <div class="admin-client-list">
                @forelse($users->take(6) as $user)
                    <div class="admin-client-item">
                        <span class="admin-client-avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                        <span><strong>{{ $user->name }}</strong><small>{{ $user->email }}</small></span>
                        <small>{{ $user->created_at?->format('d.m') }}</small>
                    </div>
                @empty
                    <div class="admin-empty">Пользователей пока нет</div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
