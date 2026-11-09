@extends('admin.layout')

@section('admin_title', 'Пакеты')
@section('admin_heading', 'Пакеты услуг')
@section('admin_description', 'Объединяйте программы в выгодные предложения и управляйте скидками.')

@section('admin_content')
    <details class="admin-create-panel" @if($errors->any()) open @endif>
        <summary><span><i class="fas fa-plus"></i> Добавить пакет</span><small>Собрать новое комплексное предложение</small></summary>
        <form action="{{ route('admin.packages.store') }}" method="POST" class="admin-form-grid">
            @csrf
            <div class="admin-field span-2"><label>Название</label><input type="text" name="title" value="{{ old('title') }}" required></div>
            <div class="admin-field span-2"><label>Описание</label><textarea name="description" rows="3" required>{{ old('description') }}</textarea></div>
            <div class="admin-field"><label>Обычная цена, ₽</label><input type="number" name="original_price" min="0" step="0.01" value="{{ old('original_price') }}" required></div>
            <div class="admin-field"><label>Цена пакета, ₽</label><input type="number" name="discounted_price" min="0" step="0.01" value="{{ old('discounted_price') }}" required></div>
            <div class="admin-field"><label>Скидка, %</label><input type="number" name="discount_percent" min="0" max="100" value="{{ old('discount_percent', 0) }}" required></div>
            <div class="admin-field"><label>Порядок</label><input type="number" name="order" value="{{ old('order', 0) }}"></div>
            <div class="admin-field span-2"><label>Программы в пакете</label><div class="admin-checkbox-grid">@foreach($services as $service)<label><input type="checkbox" name="services_json[]" value="{{ $service->id }}" @checked(in_array($service->id, old('services_json', [])))><span>{{ $service->title }}</span></label>@endforeach</div></div>
            <div class="admin-switch-field"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" id="new-package-active" checked><label for="new-package-active"><span></span>Показывать на сайте</label></div>
            <div class="span-2"><button class="admin-primary-button"><i class="fas fa-plus"></i> Создать пакет</button></div>
        </form>
    </details>

    <div class="admin-entity-grid">
        @forelse($packages as $package)
            <article class="admin-entity-card">
                <div class="admin-entity-head">
                    <span class="admin-entity-icon package"><i class="fas fa-box-open"></i></span>
                    <div><span>Пакет #{{ $package->id }}</span><h2>{{ $package->title }}</h2></div>
                    <span class="admin-visibility {{ $package->is_active ? 'active' : 'inactive' }}">{{ $package->is_active ? 'На сайте' : 'Скрыт' }}</span>
                </div>
                <p class="admin-entity-description">{{ strip_tags($package->description) }}</p>
                <div class="admin-entity-summary">
                    <span><small>Цена</small><strong>{{ number_format($package->discounted_price, 0, '', ' ') }} ₽</strong></span>
                    <span><small>Старая цена</small><strong>{{ number_format($package->original_price, 0, '', ' ') }} ₽</strong></span>
                    <span><small>Скидка</small><strong>{{ $package->discount_percent }}%</strong></span>
                    <span><small>Программ</small><strong>{{ count($package->services_json ?? []) }}</strong></span>
                </div>

                <details class="admin-edit-panel">
                    <summary><i class="fas fa-pen"></i> Редактировать</summary>
                    <form action="{{ route('admin.packages.update', $package) }}" method="POST" class="admin-form-grid compact">
                        @csrf @method('PUT')
                        <div class="admin-field span-2"><label>Название</label><input type="text" name="title" value="{{ $package->title }}" required></div>
                        <div class="admin-field span-2"><label>Описание</label><textarea name="description" rows="3" required>{{ $package->description }}</textarea></div>
                        <div class="admin-field"><label>Обычная цена, ₽</label><input type="number" name="original_price" min="0" step="0.01" value="{{ $package->original_price }}" required></div>
                        <div class="admin-field"><label>Цена пакета, ₽</label><input type="number" name="discounted_price" min="0" step="0.01" value="{{ $package->discounted_price }}" required></div>
                        <div class="admin-field"><label>Скидка, %</label><input type="number" name="discount_percent" min="0" max="100" value="{{ $package->discount_percent }}" required></div>
                        <div class="admin-field"><label>Порядок</label><input type="number" name="order" value="{{ $package->order }}"></div>
                        <div class="admin-field span-2"><label>Программы в пакете</label><div class="admin-checkbox-grid">@foreach($services as $service)<label><input type="checkbox" name="services_json[]" value="{{ $service->id }}" @checked(in_array($service->id, $package->services_json ?? []))><span>{{ $service->title }}</span></label>@endforeach</div></div>
                        <div class="admin-switch-field"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" id="package-active-{{ $package->id }}" @checked($package->is_active)><label for="package-active-{{ $package->id }}"><span></span>Показывать на сайте</label></div>
                        <div class="span-2"><button class="admin-primary-button"><i class="fas fa-floppy-disk"></i> Сохранить</button></div>
                    </form>
                    <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="admin-delete-form" onsubmit="return confirm('Удалить этот пакет?')">@csrf @method('DELETE')<button><i class="fas fa-trash"></i> Удалить пакет</button></form>
                </details>
            </article>
        @empty
            <div class="admin-empty-card"><i class="fas fa-box-open"></i><h2>Пакетов пока нет</h2><p>Создайте первое комплексное предложение.</p></div>
        @endforelse
    </div>
@endsection
