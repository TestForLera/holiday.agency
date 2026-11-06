@extends('layots')

@section('title', 'стоисость')

@section('content')
    <div class="services-grid">
        @foreach($services as $service)
            <div class="service-card">
                <h3>{{ $service->title }}</h3>
                @if($service->duration)
                    <p><strong>Длительность:</strong> {{ $service->duration }}</p>
                @endif
                <p>{!! $service->description !!}</p>
                
                @if($service->discount_percent)
                    <div class="price">
                        <span class="old-price"><strike>{{ $service->price }}</strike> руб.</span>
                        <span class="new-price">{{ $service->discounted_price }} руб.</span>
                        <span class="discount">Скидка {{ $service->discount_percent }}%</span>
                    </div>
                @else
                    <div class="price">{{ $service->price }} руб.</div>
                @endif
                
                <ul class="features">
                    @foreach($service->features as $feature)
                        <li>{{ $feature->feature_text }}</li>
                    @endforeach
                </ul>
                
                @if($service->heroes->count())
                    <div class="heroes">
                        <h4>Герои на выбор:</h4>
                        <p>{{ $service->heroes->pluck('name')->join(', ') }}</p>
                    </div>
                @endif
                <button class="btn zakaz">Заказать</button>
            </div>
        @endforeach
    </div>
@endsection
