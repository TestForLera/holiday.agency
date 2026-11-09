@extends('admin.layout')
@section('admin_title', 'Заявки')
@section('admin_heading', 'Заявки клиентов')
@section('admin_description', 'Контакты, детали праздника и текущий этап обработки заказа.')
@section('admin_content')
    <section class="admin-card">
        <div class="admin-card-header"><div><span>Все обращения</span><h2>{{ $orders->total() }} заявок</h2></div></div>
        <div class="admin-table-wrap">
        <table class="admin-table admin-orders-table">
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
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td><strong>{{ $order->fio ?? $order->user->name ?? '—' }}</strong></td>
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
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="admin-status-form">
                            @csrf @method('PATCH')
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" aria-label="Статус заявки #{{ $order->id }}">
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
        </div>
        <div class="admin-pagination">{{ $orders->links() }}</div>
    </section>
@endsection
