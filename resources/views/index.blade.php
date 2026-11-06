@extends('layots')

@section('title', 'Поздравление ростовых кукл в Челябинске')

@section('content')
    <!-- Главная секция -->
    <section class="hero-section" id='hero'>
        <div class="container h-100">
            <div class="hero-content">
                <img src="{{ asset('img/logo.png') }}" alt="Логотип" class="hero-logo">

                <h1 class="hero-title">{{ $hero_title }}</h1>
                <div class="hero-highlight">
                    <img src="{{ asset('img/podarok.png') }}" alt="Подарок">
                    <span>{{ $hero_subtitle }}</span>
                </div>
                <div class="hero-phone">8 (908) 070 33-42</div>
                @if(!empty($promo_code))
                    <div class="mt-3">
                        <span class="badge bg-danger fs-6">Промокод: {{ $promo_code }}</span>
                        @if(!empty($promo_text))
                            <span class="ms-2">{{ $promo_text }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <div class="dolls-container">
                @if(!empty($hero_image))
                    <img src="{{ asset('storage/'.$hero_image) }}" class="doll" alt="Герой" style="background: transparent;">
                @endif
                <img src="{{ asset('img/зая.png') }}" class="doll zai" alt="Зая">
                <img src="{{ asset('img/капи.png') }}" class="doll kapi" alt="Капибара">
                <img src="{{ asset('img/мишка.png') }}" class="doll bearn" alt="Мишка">
                <img src="{{ asset('img/чеба.png') }}" class="doll cheba" alt="Чебурашка">
            </div>
        </div>
    </section>

    <!-- Секция с героями -->
    <section class="slider-section">
        <h2 class="section-title" id='heroes'>НАШИ ГЕРОИ</h2>

        <div class="slider-container">
            <button class="nav-btn prev">‹</button>
            <div class="slider" id="slider">
                @forelse($slides as $slide)
                    <div class="slide">
                        <div class="slide-content">
                            <img src="{{ asset($slide->image_path) }}" alt="{{ $slide->title }}">
                            <h3>{{ $slide->title }}</h3>
                        </div>
                    </div>
                @empty
                    <div class="slide">
                        <div class="slide-content">
                            <div class="no-slides">Герои скоро появятся</div>
                        </div>
                    </div>
                @endforelse
            </div>
            <button class="nav-btn next">›</button>
        </div>
    </section>

    <!-- Секция с программами -->
    <section class="programs-section">
        <h1 class="section-title" id='programm'>НАШИ ПРОГРАММЫ</h1>
        <div class="programs-container">
            @forelse($services as $service)
                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="{{ asset('img/1.jpg') }}" alt="{{ $service->title }}" class="program-image">
                    </div>
                    <div class="program-content">
                        <h3 class="program-title">{{ $service->title }}</h3>
                        <p class="program-description">{{ \Illuminate\Support\Str::limit($service->description, 120) }}</p>
                        <p class="program-price">
                            @if($service->discounted_price)
                                <s>{{ number_format($service->price, 0, '', ' ') }} ₽</s>
                                {{ number_format($service->discounted_price, 0, '', ' ') }} ₽
                            @else
                                от {{ number_format($service->price, 0, '', ' ') }} ₽
                            @endif
                        </p>
                        <a href="{{ route('services.index') }}" class="btn-more">Подробнее</a>
                    </div>
                </div>
            @empty
                <p class="no-programs">Программы не найдены.</p>
            @endforelse
        </div>
    </section>

    <!-- Секция "Почему мы" -->
    <section class="reasons-section" id="reasons">
        <h2 class="section-title">ПОЧЕМУ МЫ?</h2>
        <div class="reasons-grid">
            <div class="reason-item">К каждому празднику подбираем индивидуальный подход</div>
            <div class="reason-item">Большой опыт работы</div>
            <div class="reason-item">Дарим незабываемые эмоции</div>
            <div class="reason-item">Организуем срочные заказы в день мероприятия</div>
            <div class="reason-item">Уникальные ростовые куклы</div>
            <div class="reason-item">Классные и яркие фото</div>
        </div>
    </section>

    <!-- Секция с локациями -->
    <section class="locations-section">
        <div class="locations-container">
            <h2 class="section-title locations-title">ГДЕ МЫ МОЖЕМ ПРОВЕСТИ ПРАЗДНИК</h2>
            <div class="locations-content">
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-home"></i></div>
                    <h3>В доме, на даче или в квартире</h3>
                </div>
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-tree"></i></div>
                    <h3>На улице, в парке</h3>
                </div>
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-school"></i></div>
                    <h3>В школе, садике</h3>
                </div>
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-utensils"></i></div>
                    <h3>В ресторане, кафе</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Секция с отзывами -->
    <section class="reviews-section" id='reviews'>
        <h2 class="section-title">ОТЗЫВЫ НАШИХ КЛИЕНТОВ</h2>
        <div class="reviews-container">
            @forelse($reviews as $review)
                <div class="review-card">
                    <div class="review-header">
                        @if ($review->avatar_url)
                            <img src="{{ asset($review->avatar_url) }}" alt="{{ $review->author_name }}"
                                class="review-avatar">
                        @endif
                        <div>
                            <strong>{{ $review->author_name }}</strong>
                            <div class="review-category">{{ $review->category }}</div>
                        </div>
                    </div>

                    <div class="review-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                        @endfor
                    </div>

                    <p class="review-text">{!! nl2br(e($review->content)) !!}</p>

                    @if ($review->photo_url)
                        <img src="{{ asset($review->photo_url) }}" alt="Фото к отзыву" class="review-photo">
                    @endif

                    <small class="review-date">{{ $review->created_at }}</small>
                </div>
            @empty
                <p class="no-reviews">Отзывов пока нет. Будьте первым!</p>
            @endforelse
        </div>
    </section>

    <!-- Модальное окно с промокодом -->
    <div id="promoModal" class="promo-modal" style="display: none;">
        <div class="promo-modal-content">
            <span class="promo-modal-close">&times;</span>
            <div class="promo-content">
                <h2>Ваш промокод!</h2>
                <p class="promo-code">KUKLA2025</p>
                <p class="promo-desc">Скидка 15% на любую программу при заказе до конца месяца!</p>
            </div>
        </div>
    </div>
@endsection
