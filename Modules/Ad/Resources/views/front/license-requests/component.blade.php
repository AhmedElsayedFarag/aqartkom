<div class="col-md-6">
    <div class="feat">

        <div class="parent d-flex">

            <div class="photo">
                <a href="#">
                    <img src="{{ asset($ad->estate->media->first()->url) }}">
                </a>


                <div class="ad-feat adLicend">

                    @if ($ad->is_licensed)
                        <div class="verify">
                            <span>مرخص</span>
                        </div>
                    @else
                        <a href="#">
                            إعلانك قيد الترخيص </a>
                    @endif
                </div>

                <div class="ad-feat">

                    <a href="{{ route('front.profile.licenceRequestState', ['ad' => $ad->uuid]) }}">
                        <img src="{{ asset('front-end/images/medal.svg') }}">
                        تفاصيل الطلب </a>

                </div>

            </div>

            <div class="info">
                <p class="title">
                    <a href="#">
                        {{ $ad->estate->title }}
                    </a>
                </p>
                <p class="sub-title">{{ $ad->estate->address }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="amount">
                            <span><img src="{{ asset('front-end/images/menu (3).png') }}">
                                {{ $ad->estate->category->name }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="amount">
                            <span><img src="{{ asset('front-end/images/Group 539.png') }}">
                                {{ $ad->formattedAcceptedDate }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="amount">
                            <span>
                                <img src="{{ asset('front-end/images/Group 44848.svg') }}">
                                {{ $ad->views }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="amount">
                            <span>
                                <img src="{{ asset('front-end/images/Group 44464.svg') }}">
                                {{ $ad->estate->area }} متر
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="price">
                            <p>{{ \number_format($ad->price) }} ريال</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="more">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('front-end/images/icons/option (2).svg') }}">
                                    المزيد
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <li><a class="dropdown-item"
                                            href="{{ route('front.ad.edit', ['ad' => $ad->uuid]) }}">تعديل الطلب</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;"
                                            onclick="deleteAd('{{ $ad->uuid }}')">حذف الطلب</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
