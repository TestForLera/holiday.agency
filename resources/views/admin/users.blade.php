@extends('admin.layout')
@section('admin_title', 'Пользователи')
@section('admin_heading', 'Пользователи')
@section('admin_description', 'Контактные данные клиентов и история активности.')
@section('admin_content')
    <section class="admin-card">
        <div class="admin-card-header"><div><span>База клиентов</span><h2>{{ $users->total() }} пользователей</h2></div></div>
        <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>ID</th><th>Имя</th><th>Email</th><th>Телефон</th><th>Роль</th><th>Заказов</th><th>Регистрация</th></tr></thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td><strong>#{{ $user->id }}</strong></td>
                    <td><div class="admin-user-cell"><span class="admin-client-avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span><strong>{{ $user->name }}</strong></div></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td><span class="admin-role role-{{ $user->role }}">{{ $user->role === 'admin' ? 'Администратор' : 'Клиент' }}</span></td>
                    <td>{{ $user->orders_count }}</td>
                    <td>{{ $user->created_at?->format('d.m.Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        <div class="admin-pagination">{{ $users->links() }}</div>
    </section>
@endsection
