@php
    $currencies = [
        'USD' => '$',
        'EUR' => '€'
    ];
@endphp
<div class="currency-box">
    @foreach ($currencies as $currency => $symbol)
        @php
            $arrow = 'fas fa-arrow-' . get_option($currency . '_CHANGE');
            $value = get_option($currency);
        @endphp
        <div class="{{$currency}}">
            <span>{{$symbol}}  <i class="fas fa-arrow-{{$arrow}}"></i> - {{$value}}</span>
        </div>
    @endforeach
</div>