@extends('layots')

@section('title', trim($__env->yieldContent('admin_title', 'Админ-панель')))
@section('body_class', 'admin-page')

@section('content')
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <span class="admin-brand-icon"><i class="fas fa-sparkles"></i></span>
            <span><strong>Винни</strong><small>Управление сайтом</small></span>
        </a>

        <nav class="admin-navigation" aria-label="Административные разделы">
            <span class="admin-nav-caption">Основное</span>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i><span>Обзор</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="admin-nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i><span>Заявки</span>
            </a>
            <a href="{{ route('admin.users') }}" class="admin-nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i><span>Пользователи</span>
            </a>

            <span class="admin-nav-caption">Каталог</span>
            <a href="{{ route('admin.services.index') }}" class="admin-nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
                <i class="fas fa-wand-magic-sparkles"></i><span>Программы</span>
            </a>
            <a href="{{ route('admin.packages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.packages*') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i><span>Пакеты</span>
            </a>
            <a href="{{ route('admin.heroes.index') }}" class="admin-nav-link {{ request()->routeIs('admin.heroes*') ? 'active' : '' }}">
                <i class="fas fa-masks-theater"></i><span>Герои</span>
            </a>

            <span class="admin-nav-caption">Сайт</span>
            <a href="{{ route('admin.content.edit') }}" class="admin-nav-link {{ request()->routeIs('admin.content*') || request()->routeIs('admin.slides*') ? 'active' : '' }}">
                <i class="fas fa-pen-to-square"></i><span>Контент</span>
            </a>
            <a href="{{ route('admin.reviews') }}" class="admin-nav-link {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                <i class="fas fa-star"></i><span>Отзывы</span>
            </a>
        </nav>

        <div class="admin-sidebar-footer">
            <a href="{{ url('/') }}" class="admin-site-link">
                <i class="fas fa-arrow-up-right-from-square"></i>
                <span>Открыть сайт</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="admin-logout-button">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                    <span>Выйти</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <header class="admin-page-header">
            <div>
                <span class="admin-eyebrow">Административная панель</span>
                <h1>@yield('admin_heading', 'Управление')</h1>
                @hasSection('admin_description')
                    <p>@yield('admin_description')</p>
                @endif
            </div>
            <div class="admin-header-user">
                <span class="admin-header-avatar"><i class="fas fa-user-shield"></i></span>
                <span><strong>{{ auth()->user()->name }}</strong><small>Администратор</small></span>
            </div>
        </header>

        @if(session('success'))
            <div class="admin-alert success"><i class="fas fa-circle-check"></i><span>{{ session('success') }}</span></div>
        @endif
        @if($errors->any())
            <div class="admin-alert error">
                <i class="fas fa-circle-exclamation"></i>
                <div><strong>Проверьте заполнение формы</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            </div>
        @endif

        <div class="admin-content">
            @yield('admin_content')
        </div>
    </main>
</div>
@endsection
