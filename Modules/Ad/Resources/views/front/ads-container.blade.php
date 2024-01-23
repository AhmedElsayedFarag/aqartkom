 {{-- <div class="row"> --}}
 @foreach ($ads as $ad)
     @include('ad::front.ad-component')
 @endforeach

 {{-- </div> --}}
 @include('partials.not-licensed-ads');
