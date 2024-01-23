@foreach ($ads as $ad)
    @include('ad::front.user.ad-component')
@endforeach

@include('partials.not-licensed-ads');
