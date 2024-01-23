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
                <li>الشركات العقارية</li>
            </ul>
        </div>
    </section>
    <section class="aqar-companies">
        <div class="container">
            <div class="row">
                @foreach ($companies as $company)
                    <div class="col-md-6">
                        <div class="company">
                            <a href="{{ route('front.companies.show', ['company' => $company->uuid]) }}?type=sell">
                                <div class="parent">
                                    <div class="photo">
                                        <img src="{{ asset('storage/companies/' . $company->logo) }}" />
                                    </div>
                                    <div class="info">
                                        <h2>{{ $company->user->name }}</h2>
                                        <ul class="d-flex">

                                            <li>
                                                <div class="title">
                                                    <p>رخصة فال</p>
                                                </div>
                                                <div class="content">
                                                    @if ($company->commercial_register_number)
                                                        <p>{{ $company->commercial_register_number }}</p>
                                                    @endif
                                                </div>
                                            </li>

                                            <li>
                                                <div class="title">
                                                    <img src="{{ asset('front-end/images/compainies/megaphone.png') }}">
                                                </div>
                                                <div class="content">
                                                    <p>{{ $company->user->ads()->count() }}</p>
                                                </div>
                                            </li>
                                            @if ($company->user->is_authorized)
                                                <li>
                                                    <div class="title">
                                                        <img src="{{ asset('front-end/images/compainies/check.png') }}">
                                                    </div>
                                                    <div class="content">
                                                        <p> موثق</p>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </a>
                            @if ($company->user->is_featured)
                                <a href="#" class="ad"> مميز</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $companies->links('pagination::simple-bootstrap-5') }}
        </div>
    </section>
    {{-- <section class="aqar-company pagination">
        <div class="container">

            <div class="row">
                @foreach ($companies as $company)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="company">
                            <figure class="photo">
                                <a href="{{ route('front.companies.show', ['company' => $company->uuid]) }}?type=sell">
                                    <img src="{{ asset('storage/companies/' . $company->logo) }}" />
                                </a>
                            </figure>
                            <div class="address">
                                <a href="#">
                                    {{ $company->user->name }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $companies->links('pagination::simple-bootstrap-5') }}
        </div>
    </section> --}}
@endsection
