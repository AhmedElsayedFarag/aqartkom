                                            <div class="col-md-6">
                                                <div class="single-mzad myMzad">
                                                    <div class="info">
                                                        <p class="title">
                                                            {{ $bid->auction->estate->title }}
                                                        </p>
                                                        <p class="sub-title">{{ $bid->auction->estate->address }}
                                                        </p>
                                                    </div>
                                                    <div class="building">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="types">
                                                                    <p>
                                                                                                    <img src="{{ asset('front-end/images/newIcons/Group 546.png') }} " />
                                                                        {{ $bid->auction->estate->category->name }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="types">
                                                                    
                                                                    <p>
                                                                         <img src="{{ asset('front-end/images/newIcons/area.png') }} " />
                                                                        {{ $bid->auction->estate->area }} متر</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="types">
                                                                    <p>
                                                                                                       <img src="{{ asset('front-end/images/newIcons/Path 2620.png') }} " />
                                                                        {{ 'AUC' . str_pad($bid->auction->id, 2, 0, STR_PAD_LEFT) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="{{ $bid->auction->end_at }}"
                                                        class="timer" />
                                                    <div class="some-details">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="finish">
                                                                    <p class="title">متبقي علي انتهاء المزاد</p>
                                                                    <ul class="d-flex">
                                                                        <li>
                                                                            <p class="number"
                                                                                id="days-{{ $loop->iteration }}">00</p>
                                                                            <p class="date">يوم</p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="number"
                                                                                id="hours-{{ $loop->iteration }}">00</p>
                                                                            <p class="date">ساعه</p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="number"
                                                                                id="minutes-{{ $loop->iteration }}">00
                                                                            </p>
                                                                            <p class="date">دقيقه</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p class="title">اعلي مزايدة</p>
                                                                <div class=" max">
                                                                    <p>
                                                                        <span>{{ $bid->auction->top_price }}</span>
                                                                        ريال لكل م 2
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($bid->auction->is_closed == 0 && now()->isBefore($bid->auction->end_at))
                                                        <div class="bottom-button">
                                                            <a
                                                                href="{{ route('front.auction.bid.edit', ['auction' => $bid->auction->uuid]) }}">
                                                                <i class="fa-regular fa-pen-to-square"></i>
                                                                تعديل
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
