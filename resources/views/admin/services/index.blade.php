@extends('admin.layout')

@section('admin_title', 'Программы')
@section('admin_heading', 'Программы и цены')
@section('admin_description', 'Управляйте описаниями, длительностью, стоимостью и видимостью программ на сайте.')

@section('admin_content')
    <details class="admin-create-panel" @if($errors->any()) open @endif>
        <summary><span><i class="fas fa-plus"></i> Добавить программу</span><small>Создать новую карточку на странице цен</small></summary>
        <form action="{{ route('admin.services.store') }}" method="POST" class="admin-form-grid">
            @csrf
            <div class="admin-field span-2"><label>Название</label><input type="text" name="title" value="{{ old('title') }}" required></div>
            <div class="admin-field span-2"><label>Описание</label><textarea name="description" rows="3" required>{{ old('description') }}</textarea></div>
            <div class="admin-field"><label>Длительность</label><input type="text" name="duration" value="{{ old('duration') }}" placeholder="Например, 30 минут"></div>
            <div class="admin-field"><label>Порядок</label><input type="number" name="order" value="{{ old('order', 0) }}"></div>
            <div class="admin-field"><label>Обычная цена, ₽</label><input type="number" name="price" min="0" step="0.01" value="{{ old('price') }}" required></div>
            <div class="admin-field"><label>Цена со скидкой, ₽</label><input type="number" name="discounted_price" min="0" step="0.01" value="{{ old('discounted_price') }}"></div>
            <div class="admin-field"><label>Скидка, %</label><input type="number" name="discount_percent" min="0" max="100" value="{{ old('discount_percent') }}"></div>
            <div class="admin-switch-field"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" id="new-service-active" checked><label for="new-service-active"><span></span>Показывать на сайте</label></div>
            <div class="admin-field span-2"><label>Особенности программы</label><input type="text" name="features[]" placeholder="Первая особенность"><input type="text" name="features[]" placeholder="Вторая особенность"><input type="text" name="features[]" placeholder="Третья особенность"></div>
            <div class="span-2"><button class="admin-primary-button"><i class="fas fa-plus"></i> Создать программу</button></div>
        </form>
    </details>

    <div class="admin-entity-grid">
        @forelse($services as $service)
            <article class="admin-entity-card" id="service-{{ $service->id }}">
                <div class="admin-entity-head">
                    <span class="admin-entity-icon"><i class="fas fa-wand-magic-sparkles"></i></span>
                    <div><span>Программа #{{ $service->id }}</span><h2>{{ $service->title }}</h2></div>
                    <span class="admin-visibility {{ $service->is_active ? 'active' : 'inactive' }}">{{ $service->is_active ? 'На сайте' : 'Скрыта' }}</span>
                </div>
                <div class="admin-entity-summary">
                    <span><small>Длительность</small><strong>{{ $service->duration ?: 'Не указана' }}</strong></span>
                    <span><small>Цена</small><strong>{{ number_format($service->discounted_price ?? $service->price, 0, '', ' ') }} ₽</strong></span>
                    <span><small>Особенности</small><strong>{{ $service->features_count }}</strong></span>
                    <span><small>Герои</small><strong>{{ $service->heroes_count }}</strong></span>
                </div>

                <details class="admin-edit-panel">
                    <summary><i class="fas fa-pen"></i> Редактировать</summary>
                    <form action="{{ route('admin.services.update', $service) }}" method="POST" class="admin-form-grid compact">
                        @csrf @method('PUT')
                        <div class="admin-field span-2"><label>Название</label><input type="text" name="title" value="{{ $service->title }}" required></div>
                        <div class="admin-field span-2"><label>Описание</label><textarea name="description" rows="3" required>{{ $service->description }}</textarea></div>
                        <div class="admin-field"><label>Длительность</label><input type="text" name="duration" value="{{ $service->duration }}"></div>
                        <div class="admin-field"><label>Порядок</label><input type="number" name="order" value="{{ $service->order }}"></div>
                        <div class="admin-field"><label>Обычная цена, ₽</label><input type="number" name="price" min="0" step="0.01" value="{{ $service->price }}" required></div>
                        <div class="admin-field"><label>Цена со скидкой, ₽</label><input type="number" name="discounted_price" min="0" step="0.01" value="{{ $service->discounted_price }}"></div>
                        <div class="admin-field"><label>Скидка, %</label><input type="number" name="discount_percent" min="0" max="100" value="{{ $service->discount_percent }}"></div>
                        <div class="admin-switch-field"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" id="service-active-{{ $service->id }}" @checked($service->is_active)><label for="service-active-{{ $service->id }}"><span></span>Показывать на сайте</label></div>
                        <div class="span-2 admin-form-actions"><button class="admin-primary-button"><i class="fas fa-floppy-disk"></i> Сохранить</button></div>
                    </form>
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="admin-delete-form" onsubmit="return confirm('Удалить эту программу?')">
                        @csrf @method('DELETE')
                        <button><i class="fas fa-trash"></i> Удалить программу</button>
                    </form>
                </details>
            </article>
        @empty
            <div class="admin-empty-card"><i class="fas fa-wand-magic-sparkles"></i><h2>Программ пока нет</h2><p>Добавьте первую программу с помощью формы выше.</p></div>
        @endforelse
    </div>
@endsection
