@extends('admin.layout')
@section('admin_title', 'Контент сайта')
@section('admin_heading', 'Контент главной страницы')
@section('admin_description', 'Редактируйте главный экран, промокод, тексты и карточки слайдера.')
@section('admin_content')

    <div class="admin-card mb-4">
        <div class="admin-card-header"><div><span>Основные настройки</span><h2>Главная страница</h2></div></div>
        <div class="admin-card-body">
            <form action="{{ route('admin.content.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Заголовок (герой)</label>
                        <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $settings->hero_title) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Подзаголовок / промо-текст</label>
                        <input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $settings->hero_subtitle) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Текст на главной</label>
                        <input type="text" name="main_text" class="form-control" value="{{ old('main_text', $settings->main_text) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Промокод</label>
                        <input type="text" name="promo_code" class="form-control" value="{{ old('promo_code', $settings->promo_code) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Текст к промокоду</label>
                        <input type="text" name="promo_text" class="form-control" value="{{ old('promo_text', $settings->promo_text) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Картинка героя (прозрачный PNG предпочтителен)</label>
                        @if($settings->hero_image)
                            <div class="mb-2 p-2" style="background: repeating-conic-gradient(#ccc 0% 25%, #fff 0% 50%) 50% / 20px 20px;">
                                <img src="{{ asset('storage/'.$settings->hero_image) }}" alt="hero" style="max-height:120px">
                            </div>
                        @endif
                        <input type="file" name="hero_image" class="form-control" accept="image/*">
                        <small class="text-muted">Загружайте PNG с прозрачным фоном</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Заголовок «Почему мы»</label>
                        <input type="text" name="why_us_title" class="form-control" value="{{ old('why_us_title', $settings->why_us_title) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Текст «Почему мы»</label>
                        <textarea name="why_us_text" class="form-control" rows="5">{{ old('why_us_text', $settings->why_us_text) }}</textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Сохранить контент</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-card mb-4">
        <div class="admin-card-header"><div><span>Карточки на главной</span><h2>Слайдер героев</h2></div></div>
        <div class="admin-card-body">
            <h6>Добавить слайд</h6>
            <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data" class="row g-2 mb-4">
                @csrf
                <div class="col-md-3"><input type="text" name="title" class="form-control" placeholder="Заголовок" required></div>
                <div class="col-md-3"><input type="text" name="text" class="form-control" placeholder="Текст"></div>
                <div class="col-md-3"><input type="file" name="image" class="form-control" accept="image/*" required></div>
                <div class="col-md-2"><input type="number" name="sort_order" class="form-control" placeholder="Порядок" value="0"></div>
                <div class="col-md-1"><button class="btn btn-success w-100">+</button></div>
            </form>

            @foreach($slides as $slide)
                <div class="border rounded p-3 mb-3">
                    <form action="{{ route('admin.slides.update', $slide->id) }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-center">
                        @csrf
                        <div class="col-md-2">
                            @if($slide->image_path)
                                <img src="{{ asset('storage/'.$slide->image_path) }}" alt="" style="max-height:60px" class="rounded">
                            @endif
                        </div>
                        <div class="col-md-2"><input type="text" name="title" class="form-control form-control-sm" value="{{ $slide->title }}" required></div>
                        <div class="col-md-3"><input type="text" name="text" class="form-control form-control-sm" value="{{ $slide->text ?? '' }}"></div>
                        <div class="col-md-2"><input type="file" name="image" class="form-control form-control-sm" accept="image/*"></div>
                        <div class="col-md-1"><input type="number" name="sort_order" class="form-control form-control-sm" value="{{ $slide->sort_order ?? 0 }}"></div>
                        <div class="col-md-2 d-flex gap-1">
                            <button class="btn btn-sm btn-primary">Сохранить</button>
                        </div>
                    </form>
                    <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST" class="mt-1" onsubmit="return confirm('Удалить слайд?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Удалить</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
