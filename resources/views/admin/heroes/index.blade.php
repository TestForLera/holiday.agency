@extends('admin.layout')
@section('admin_title', 'Герои')
@section('admin_heading', 'Герои и персонажи')
@section('admin_description', 'Добавляйте персонажей, изображения и управляйте их видимостью.')
@section('admin_content')

    <div class="admin-card mb-4">
        <div class="admin-card-header"><div><span>Новый персонаж</span><h2>Добавить героя</h2></div></div>
        <div class="admin-card-body">
            <form action="{{ route('admin.heroes.store') }}" method="POST" enctype="multipart/form-data" class="row g-2">
                @csrf
                <div class="col-md-3"><input type="text" name="name" class="form-control" placeholder="Имя" required></div>
                <div class="col-md-3"><input type="text" name="description" class="form-control" placeholder="Описание"></div>
                <div class="col-md-3"><input type="file" name="image" class="form-control" accept="image/*"></div>
                <div class="col-md-1"><input type="number" name="sort_order" class="form-control" value="0"></div>
                <div class="col-md-2"><button class="btn btn-success w-100">Добавить</button></div>
            </form>
        </div>
    </div>

    <div class="row g-3">
        @foreach($heroes as $hero)
            <div class="col-md-6">
                <div class="card h-100 admin-hero-card">
                    <div class="card-body">
                        <form action="{{ route('admin.heroes.update', $hero) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="d-flex gap-3 mb-2">
                                @if($hero->image)
                                    <img src="{{ asset('storage/'.$hero->image) }}" alt="" style="max-height:80px; background: repeating-conic-gradient(#ccc 0% 25%, #fff 0% 50%) 50% / 16px 16px;" class="rounded">
                                @endif
                                <div class="flex-grow-1">
                                    <input type="text" name="name" class="form-control mb-2" value="{{ $hero->name }}" required>
                                    <textarea name="description" class="form-control mb-2" rows="2">{{ $hero->description }}</textarea>
                                    <input type="file" name="image" class="form-control form-control-sm mb-2" accept="image/*">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="number" name="sort_order" class="form-control form-control-sm" style="width:80px" value="{{ $hero->sort_order }}">
                                        <div class="form-check">
                                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="active{{ $hero->id }}" @checked($hero->is_active)>
                                            <label class="form-check-label" for="active{{ $hero->id }}">Активен</label>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('admin.heroes.destroy', $hero) }}" method="POST" onsubmit="return confirm('Удалить?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
