@extends('layots')
@section('title', 'Пользователи')
@section('content')
<div class="container py-4" style="margin-top:80px;">
    <div class="d-flex justify-content-between mb-3">
        <h2>Пользователи</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">← Назад</a>
    </div>
    <div class="card"><div class="card-body table-responsive">
        <table class="table">
            <thead><tr><th>ID</th><th>Имя</th><th>Email</th><th>Телефон</th><th>Роль</th><th>Заказов</th><th>Регистрация</th></tr></thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->orders_count }}</td>
                    <td>{{ $user->created_at?->format('d.m.Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div></div>
</div>
@endsection
