@extends('layots')

@section('title', 'Программы и цены')

@section('content')
    <section class="services-page">
        <div class="services-hero">
            <a href="{{ url('/#programs') }}" class="services-back">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                На главную
            </a>
            <span class="services-eyebrow">Выберите формат праздника</span>
            <h1>Программы и цены</h1>
            <p>Яркие поздравления для любого возраста. Выберите программу — остальные детали уточним при оформлении.</p>
        </div>

        <div class="services-grid">
            @forelse($services as $service)
                <article class="service-card">
                    <div class="service-card-top">
                        <span class="service-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        @if($service->discount_percent)
                            <span class="service-discount">−{{ $service->discount_percent }}%</span>
                        @endif
                    </div>

                    <div class="service-icon" aria-hidden="true">
                        <i class="fas {{ $loop->first ? 'fa-gift' : 'fa-wand-magic-sparkles' }}"></i>
                    </div>

                    <h2>{{ $service->title }}</h2>

                    @if($service->duration)
                        <div class="service-duration">
                            <i class="far fa-clock" aria-hidden="true"></i>
                            {{ $service->duration }}
                        </div>
                    @endif

                    <p class="service-description">{{ strip_tags($service->description) }}</p>

                    @if($service->features->isNotEmpty())
                        <ul class="service-features">
                            @foreach($service->features as $feature)
                                <li><i class="fas fa-check" aria-hidden="true"></i>{{ $feature->feature_text }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if($service->heroes->isNotEmpty())
                        <div class="service-heroes">
                            <strong>Герои на выбор</strong>
                            <div class="service-hero-tags">
                                @foreach($service->heroes as $hero)
                                    <span>{{ $hero->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="service-card-footer">
                        <div class="service-price">
                            @if($service->discounted_price)
                                <span class="service-old-price">{{ number_format($service->price, 0, '', ' ') }} ₽</span>
                                <strong>{{ number_format($service->discounted_price, 0, '', ' ') }} ₽</strong>
                            @else
                                <small>Стоимость</small>
                                <strong>{{ number_format($service->price, 0, '', ' ') }} ₽</strong>
                            @endif
                        </div>

                        <a href="{{ route('services.order', $service) }}" class="service-order-button">
                            Заказать
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            @empty
                <div class="services-empty">Активных программ пока нет.</div>
            @endforelse
        </div>
    </section>
@endsection
