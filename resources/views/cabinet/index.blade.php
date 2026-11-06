@extends('layouts')

@section('title', 'Личный кабинет')

@section('content')
    <h2>Личный кабинет</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="profile-card">
        <h3>{{ Auth::user()->name }}</h3>
        <p>Email: {{ Auth::user()->email }}</p>
        <p>Телефон: {{ Auth::user()->phone }}</p>

        @if(Auth::user()->avatar)
            <img src="{{ asset(Storage::url(Auth::user()->avatar)) }}" alt="Аватар" class="avatar-img">
        @else
            <img src="{{ asset('img/default-avatar.jpg') }}" alt="Аватар">
        @endif
    </div>

    <!-- Ссылка на админку только для админов -->
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.services.index') }}" class="btn btn-admin">Панель администратора</a>
    @endif

    <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>ФИО</label>
        <input type="text" name="name" value="{{ Auth::user()->name }}" required>

        <label>Телефон</label>
        <input type="tel" name="phone" value="{{ Auth::user()->phone }}">

        <label>Аватар</label>
        <input type="file" name="avatar" accept="image/*">

        <button type="submit" class="btn">Сохранить профиль</button>
    </form>

    <hr>

    <h3>Ваши заказы</h3>
    @forelse($orders as $order)
        <div class="order-item">
            <strong>Заказ #{{ $order->id }}</strong>
            <p>Программа: {{ $order->program?->name }}</p>
            <p>Дата: {{ $order->order_date }}</p>
        </div>
    @empty
        <p>У вас пока нет заказов.</p>
    @endforelse
@endsection
