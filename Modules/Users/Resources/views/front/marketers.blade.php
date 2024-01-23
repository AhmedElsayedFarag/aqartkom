@extends('front-end.main')

@section('content')
    <section class="breadcramp">
        <div class="container">
            <ul class="d-flex">
                <li>
                    <a href="{{ route('front.index') }}">الرئسية</a>
                </li>
                <span>></span>
                &nbsp;
                <li>المسوقين العقاريين</li>
            </ul>
        </div>
    </section>
    <section class="aqar-companies">
        <div class="container">
            <div class="row">
                @foreach ($marketers as $marketer)
                    <div class="col-md-6">
                        <div class="company">
                            <a href="{{ route('front.marketer.show', ['marketer' => $marketer->uuid]) }}">
                                <div class="parent">
                                    <div class="photo">
                                        <img src="{{ $marketer->formattedProfile }}" />
                                    </div>
                                    <div class="info">
                                        <h2>{{ $marketer->name }}</h2>
                                        <ul class="d-flex">
                                            @if ($marketer->advertisement_number)
                                                <li>
                                                    <div class="title">
                                                        <p>رخصة فال</p>
                                                    </div>
                                                    <div class="content">
                                                        <p>{{ $marketer->advertisement_number }}</p>
                                                    </div>
                                                </li>
                                            @endif
                                            <li>
                                                <div class="title">
                                                    <img src="{{ asset('front-end/images/compainies/megaphone.png') }}">
                                                </div>
                                                <div class="content">
                                                    <p>{{ $marketer->ads()->count() }}</p>
                                                </div>
                                            </li>
                                            @if ($marketer->is_authorized)
                                                <li class="">
                                                    <div class="title">
                                                        <img src="{{ asset('front-end/images/compainies/check.png') }}">
                                                    </div>
                                                    <div class="content">
                                                        <p>موثق </p>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </a>
                            @if ($marketer->is_featured)
                                <a href="#" class="ad"> مميز</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $marketers->links('pagination::simple-bootstrap-5') }}
        </div>
    </section>
    {{-- <section class="aqar-marketer pagination">
        <div class="container">

            <div class="row">
                @foreach ($marketers as $marketer)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="marketer">
                            <figure class="photo">
                                <a href="{{ route('front.marketers.show', ['marketer' => $marketer->uuid]) }}?type=sell">
                                    <img src="{{ asset('storage/marketers/' . $marketer->logo) }}" />
                                </a>
                            </figure>
                            <div class="address">
                                <a href="#">
                                    {{ $marketer->user->name }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $marketers->links('pagination::simple-bootstrap-5') }}
        </div>
    </section> --}}
@endsection
