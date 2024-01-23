@if (isset($isFavorite) && $isFavorite)
    <div class="col-md-6" id="favorite-{{ $auction->uuid }}">
    @else
        <div class="col-lg-4 col-md-6">
@endif
<a href="{{ route('front.auction.show', ['auction' => $auction->uuid]) }}">
    <input type="hidden" value="{{ $auction->end_at }}" class="timer" />
    <div class="single-mzad">
        <div class="slider">
            <div class="owl-carousel owl-theme mzadSingle">
                @foreach ($auction->estate->media as $media)
                    @if ($media->type == 'image')
                        <div class="box">
                            <figure class="photo">
                                <img src="{{ $media->formatted_url }}">
                            </figure>
                        </div>
                    @else
                        <div class="box">
                            <video controls>
                                <source src="{{ $media->formatted_url }}" type="video/mp4">
                            </video>
                        </div>
                    @endif
                @endforeach
            </div>
            @if (isset($isFavorite) && $isFavorite)
                <button class="heart" onclick="toggleFavorite('{{ $auction->uuid }}','auction',true)">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            @endif
        </div>
        <div class="building">
            <div class="row">
                <div class="col-4">
                    <div class="types">
                        <p>
                            <img src="{{ asset('front-end/images/newIcons/Group 546.png') }} " />
                            {{ $auction->estate->category->name }}
                            </p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="types">
                        <p>
                               <img src="{{ asset('front-end/images/newIcons/area.png') }} " />
                            {{ $auction->estate->area }} متر</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="types">
                        <p>
                               <img src="{{ asset('front-end/images/newIcons/Path 2620.png') }} " />
                            {{ 'AUC' . str_pad($auction->id, 2, 0, STR_PAD_LEFT) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="info">
            <p class="title">{{ $auction->estate->title }}</p>
            <p class="sub-title"> {{ $auction->estate->address }}</p>
        </div>
        <div class="some-details">
            <div class="row">
                <div class="col-md-6">
                    <div class="finish">
                        <p class="title">متبقي علي انتهاء المزاد</p>
                        <ul class="d-flex">
                            <li>
                                <p class="number" id="days-{{ $loop->iteration }}">00</p>
                                <p class="date">يوم</p>
                            </li>
                            <li>
                                <p class="number" id="hours-{{ $loop->iteration }}">00</p>
                                <p class="date">ساعه</p>
                            </li>
                            <li>
                                <p class="number" id="minutes-{{ $loop->iteration }}">00</p>
                                <p class="date">دقيقه</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <p class="title">اعلي مزايدة</p>
                    <div class=" max">
                        <p>
                            <span>{{ $auction->top_price }}</span>
                            ريال لكل م 2
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom d-flex">
            <div class="title">
                <p>إدارة المزاد من قبل منصات عقارتكم</p>
            </div>
            <div class="open">
                <p>{{ $auction->is_closed ? 'مغلق' : 'مفتوح' }}</p>
            </div>
        </div>
    </div>
</a>
</div>
