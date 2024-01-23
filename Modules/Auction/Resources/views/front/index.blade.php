@extends('front-end.main')

@section('content')
    <section class="upFilter">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="search">
                        <select id="city_select" class="js-states" style="width: 100% !important;">
                            <option></option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <button>بحث</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="d-flex">
                        <li
                            class="{{ (!request()->has('closed') ? 'active' : request()->get('closed') == 0) ? 'active' : '' }}">
                            <a href="javascript:;" onclick="updateStatus(0)">جميع المزادات</a>
                        </li>
                        <li class="{{ request()->get('closed') == 1 ? 'active' : '' }}">
                            <a href="javascript:;" onclick="updateStatus(1)">سابق</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2 offset-md-2">
                    <a class="list">قائمة المزادات</a>
                </div>
            </div>

        </div>
    </section>

    <section class="allMzads">
        <div class="container">
            <div class="row">
                @foreach ($auctions as $auction)
                    @include('auction::front.auction-component')
                @endforeach

            </div>
            {{ $auctions->links('pagination::bootstrap-5') }}
        </div>
    </section>
@endsection

@push('custom-script')
    <script src="{{ asset('front-end/js/auction-multiple-timers.js') }}"></script>
    <script>
        const citySelect = document.getElementById('city_select');
        let cityId = 1;
        citySelect.onchange = (event) => {
            cityId = event.target.value;
            updateQuery('city', cityId);
        }

        function updateQuery(key, value) {
            const searchParams = new URLSearchParams(window.location.search);
            searchParams.set(key, value);
            window.location.search = searchParams.toString();
        }

        function updateStatus(status) {
            updateQuery('closed', status);
        }

        loadTimers();
    </script>
@endpush
