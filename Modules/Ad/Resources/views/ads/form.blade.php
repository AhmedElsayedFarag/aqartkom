@include('estate::form')

<div class="mt-3">
    @include('partials.map-component')
</div>

@push('scriptsStack')
    @include('partials.map-scripts')
    @include('estate::scripts')
@endpush
