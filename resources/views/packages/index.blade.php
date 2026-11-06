@foreach($packages as $package)
    <div class="package-card">
        <h3>{{ $package->title }}</h3>
        <p>{!! $package->description !!}</p>
        
        <div class="price">
            <span class="old-price">{{ $package->original_price }} руб.</span>
            <span class="new-price">{{ $package->discounted_price }} руб.</span>
            <span class="discount">Экономия {{ $package->discount_percent }}%</span>
        </div>
    </div>
@endforeach
