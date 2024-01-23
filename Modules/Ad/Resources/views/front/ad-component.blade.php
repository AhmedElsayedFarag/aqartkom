<div class="col-md-6" id="favorite-{{ $ad->uuid }}" data-sal-duration="700" data-sal="slide-up">
    <div class="feat">
        <div class="parent d-flex">
            <div class="photo">
                <div>
                    @if (isset($isFavorite) && $isFavorite)
                        <button class="heart" onclick="toggleFavorite('{{ $ad->uuid }}','ad',true)">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    @endif
                    <img src="{{ asset($ad->estate->media->first()->url) }}" class="photo" />
                </div>
                <div class="d-flex">
                    <div class="verify">
                        <span>نشط</span>
                    </div>

                    <div class="verify {{ $ad->is_licensed ? '' : 'unactive' }}">
                        <span>{{ $ad->is_licensed ? 'مرخص' : 'غير مرخص' }}</span>
                    </div>
                </div>
            </div>
            <div class="info">
                <p class="title">

                    {{ $ad->estate->title }}

                </p>
                <p class="sub-title"> {{ $ad->estate->address }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="amount">
                            <span><img
                                    src="{{ asset('front-end/images/menu (3).png') }}">{{ $ad->estate->category->name }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="amount">
                            <span><img
                                    src="{{ asset('front-end/images/Group 539.png') }}">{{ $ad->accepted_at->format('Y-m-d') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="amount">
                            <span><img
                                    src="{{ asset('front-end/images/Group 44848.svg') }}">{{ $ad->views }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="amount">
                            <span><img src="{{ asset('front-end/images/Group 44464.svg') }}">{{ $ad->estate->area }}
                                متر</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="price">
                            <p> {{ $ad->price }} ريال</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($ad->is_licensed)
            <a href="{{ route('front.aqar.show', ['ad' => $ad->uuid]) }}" class="watch-details">
                مشاهدة تفاصيل الإعلان
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        @else
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#not-licensed-ad-modal" class="watch-details">
                مشاهدة تفاصيل الإعلان
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        @endif
    </div>
</div>
