@extends('layots')
@section('title', 'Заявки')
@section('content')
<div class="container py-4" style="margin-top:80px;">
    <div class="d-flex justify-content-between mb-3">
        <h2>Все заявки</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">← Назад</a>
    </div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card"><div class="card-body table-responsive">
        <table class="table table-sm align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Контакты</th>
                    <th>Дата/время</th>
                    <th>Тип / Герой</th>
                    <th>Дети</th>
                    <th>Адрес</th>
                    <th>Цена</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->fio ?? $order->user->name ?? '—' }}</td>
                    <td>
                        <small>{{ $order->email ?? $order->user->email ?? '' }}<br>
                        {{ $order->phone ?? $order->user->phone ?? '' }}</small>
                    </td>
                    <td>{{ $order->date?->format('d.m.Y') }} {{ $order->time }}</td>
                    <td>
                        {{ $order->hero_type === 'rostovaya' ? 'Ростовая' : ($order->hero_type === 'animaciya' ? 'Анимация' : '—') }}
                        <br><small>{{ $order->hero_name }} ({{ $order->duration }})</small>
                        @if($order->additional_services)
                            <br><small class="text-muted">{{ implode(', ', $order->additional_services) }}</small>
                        @endif
                    </td>
                    <td>{{ $order->children_count }} чел.<br><small>{{ $order->children_ages }}</small></td>
                    <td>{{ $order->address }}@if($order->apartment), кв. {{ $order->apartment }}@endif</td>
                    <td>{{ number_format($order->price ?? 0, 0, '', ' ') }} ₽</td>
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
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </div></div>
</div>
@endsection
