@extends('layots')
@section('title', 'Отзывы')
@section('content')
<div class="container py-4" style="margin-top:80px;">
    <div class="d-flex justify-content-between mb-3">
        <h2>Отзывы</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">← Назад</a>
    </div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card"><div class="card-body">
        @forelse($reviews as $review)
            <div class="border-bottom py-3 d-flex justify-content-between">
                <div>
                    <strong>★ {{ $review->rating }}</strong>
                    — {{ $review->author_name ?? $review->user->name ?? 'Аноним' }}
                    <div>{{ $review->text }}</div>
                    <small class="text-muted">{{ $review->created_at?->format('d.m.Y H:i') }}</small>
                </div>
                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Удалить отзыв?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Удалить</button>
                </form>
            </div>
        @empty
            <p class="text-muted">Отзывов нет</p>
        @endforelse
        {{ $reviews->links() }}
    </div></div>
</div>
@endsection
