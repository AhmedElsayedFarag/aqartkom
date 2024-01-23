
@include('estate::form')

@include('partials.map-component')


@push('scriptsStack')
    @include('partials.map-scripts')
    @include('estate::scripts')
@endpush
