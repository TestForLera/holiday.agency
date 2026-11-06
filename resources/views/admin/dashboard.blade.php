@extends('layots')

@section('title', 'Админ панель')

@section('content')
<div class="container-fluid py-4" style="margin-top: 80px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Панель управления</h2>
        <div class="btn-group">
            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-sm">Пользователи</a>
            <a href="{{ route('admin.orders') }}" class="btn btn-outline-primary btn-sm">Заказы</a>
            <a href="{{ route('admin.reviews') }}" class="btn btn-outline-primary btn-sm">Отзывы</a>
            <a href="{{ route('admin.content.edit') }}" class="btn btn-outline-primary btn-sm">Контент</a>
            <a href="{{ route('admin.heroes.index') }}" class="btn btn-outline-primary btn-sm">Герои</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white"><div class="card-body">
                <h6>Пользователи</h6><h2>{{ $stats['totalUsers'] }}</h2>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white"><div class="card-body">
                <h6>Всего заказов</h6><h2>{{ $stats['totalOrders'] }}</h2>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark"><div class="card-body">
                <h6>Ожидают</h6><h2>{{ $stats['pendingOrders'] }}</h2>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white"><div class="card-body">
                <h6>Отзывы</h6><h2>{{ $stats['totalReviews'] }}</h2>
            </div></div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Последние заказы</h5>
                    <a href="{{ route('admin.orders') }}">Все</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>ID</th><th>Клиент</th><th>Дата</th><th>Статус</th><th></th></tr></thead>
                        <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? '—' }}</td>
                                <td>{{ $order->date?->format('d.m.Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            @foreach(\App\Models\Order::STATUSES as $key => $label)
                                                <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $order->package->title ?? '—' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Пользователи</h5></div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($users as $u)
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>{{ $u->name }} <small class="text-muted">{{ $u->email }}</small></span>
                                <small>{{ $u->phone }}</small>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-secondary mt-2">Все пользователи</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
