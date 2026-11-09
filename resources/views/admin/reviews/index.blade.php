@extends('admin.layout')
@section('admin_title', 'Отзывы')
@section('admin_heading', 'Отзывы клиентов')
@section('admin_description', 'Проверяйте обратную связь и удаляйте неподходящие публикации.')
@section('admin_content')
    <section class="admin-card">
    <div class="admin-review-list">
        @forelse($reviews as $review)
            <article class="admin-review-item">
                <span class="admin-review-avatar">{{ mb_strtoupper(mb_substr($review->author_name ?? $review->user->name ?? 'А', 0, 1)) }}</span>
                <div class="admin-review-body">
                    <div class="admin-review-meta"><strong>{{ $review->author_name ?? $review->user->name ?? 'Аноним' }}</strong><span>{{ str_repeat('★', $review->rating) }}</span></div>
                    <p>{{ $review->text }}</p>
                    <small>{{ $review->created_at?->format('d.m.Y H:i') }}</small>
                </div>
                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Удалить отзыв?')">
                    @csrf @method('DELETE')
                    <button class="admin-icon-button danger" title="Удалить отзыв"><i class="fas fa-trash"></i></button>
                </form>
            </article>
        @empty
            <p class="text-muted">Отзывов нет</p>
        @endforelse
    </div>
    <div class="admin-pagination">{{ $reviews->links() }}</div>
    </section>
@endsection
