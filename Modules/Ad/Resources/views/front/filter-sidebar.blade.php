<div class="col-md-4">
    <div class="search-filter">
        <div class="title">
            <p>فلتر البحث</p>
        </div>
        <div class="choosing">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" onclick="changeType('sell')" class="btn-check" name="btnradio"
                    id="sellBtn" autocomplete="off" checked />
                <label class="btn" for="sellBtn">للبيع</label>

                <input type="radio" onclick="changeType('rent')" class="btn-check" name="btnradio"
                    id="rentBtn" autocomplete="off" />
                <label class="btn" for="rentBtn">للإيجار</label>
            </div>
        </div>
        <div class="budget">
            <p>الميزانية ( ريال سعودي)</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="low">
                        <label>أقل سعر</label>
                        <select id="lowestPrice" class="js-states priceSelect"
                            onchange="removeLessValues(pricesSlider, priceSliderAttributes)">
                            <option></option>
                            @foreach ($filters['prices'][0]['values'] as $value)
                                <option value="{{ $value }}">{{ number_format($value) }} ر.س
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="high">
                        <label>اعلى سعر</label>
                        <select id="highestPrice" class="js-states priceSelect"
                            onchange="removeHighestValues(pricesSlider, priceSliderAttributes)">
                            <option></option>
                            @foreach ($filters['prices'][1]['values'] as $value)
                                <option value="{{ $value }}">{{ number_format($value) }} ر.س
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-12">
                    <input type="text" id="priceSlider" />
                </div>
            </div>
            <div class="slider-labels d-flex justify-content-around">
                <div class="caption">
                    <span id="slider-range-value2"></span>
                </div>
                <div class="caption text-right">
                    <span id="slider-range-value1"></span>
                </div>
            </div>
        </div>
        <div class="aqarType">
            <p>نوع العقار</p>
            <div class="btn-group d-flex justify-content-between" role="group"
                aria-label="Basic radio toggle button group">
                <div>
                    @foreach ($categories as $category)
                        <input type="hidden" value="{{ $category->is_building }}"
                            id="category-{{ $category->id }}" />
                        <input type="checkbox" class="btn-check categoryBtn" name="btnradio1"
                            id="type{{ $loop->index }}" autocomplete="off"
                            onclick="changeArrayFilter('category_array',{{ $category->id }})"
                            value="{{ $category->id }}" />

                        <label class="btn" for="type{{ $loop->index }}">
                            <img src="{{ $category->formattedUrl }}" class="category-icon" />
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="aqarType bedrooms">
            <p>غرف نوم</p>
            <div class="btn-group d-flex justify-content-center" role="group"
                aria-label="Basic checkbox toggle button group">
                <div>
                    @foreach ($filters['bedroom'][0]['values'] as $value)
                        <input type="checkbox" class="btn-check bedroomBtn"
                            id="btncheck{{ $loop->iteration }}" value="{{ $value }}"
                            autocomplete="off" />
                        <label class="btn" for="btncheck{{ $loop->iteration }}"
                            onclick="changeArrayFilter('bedroom',{{ $value }})">{{ $value }}</label>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="budget">
            <p>مساحة العقار</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="low">
                        <label>أقل مساحة</label>
                        <select id="lowestArea" class="js-states areaSelect"
                            onchange="removeLessValues(areaSlider, areaSliderAttributes)">>
                            <option></option>
                            @foreach ($filters['area'][0]['values'] as $value)
                                <option value="{{ $value }}">{{ $value }} متر</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="high">
                        <label>أعلى مساحة</label>
                        <select id="highestArea" class="js-states areaSelect"
                            onchange="removeHighestValues(areaSlider, areaSliderAttributes)">>
                            <option></option>
                            @foreach ($filters['area'][1]['values'] as $value)
                                <option value="{{ $value }}">{{ $value }} متر</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-12">
                    <input type="text" id="areaSlider" />
                </div>
            </div>
            <div class="slider-labels d-flex justify-content-around">
                <div class="caption">
                    <span id="slider-range-value2size"></span>
                </div>
                <div class="caption text-right">
                    <span id="slider-range-value1size"></span>
                </div>
            </div>
        </div>
        <div class="aqarType placeDirection ageBuilding">
            <p>عمر العقار</p>
            <div class="btn-group d-flex justify-content-center" role="group"
                aria-label="Basic radio toggle button group">
                <div>
                    @foreach ($filters['age'][0]['values'] as $ageFilter)
                        <input type="radio" class="btn-check ageBtn" name="age"
                            id="age{{ $loop->iteration }}" autocomplete="off"
                            data-min="{{ $ageFilter['values'][0] }}"
                            data-max="{{ $ageFilter['values'][1] }}" />
                        <label class="btn" for="age{{ $loop->iteration }}">
                            {{ $ageFilter['name'] }}
                        </label>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="aqarType placeDirection">
            <p>الأثاث</p>
            <div class="btn-group d-flex justify-content-center" role="group"
                aria-label="Basic radio toggle button group">
                <div>
                    <input type="radio" class="btn-check" name="furniture" id="nonFurnitureBtn"
                        autocomplete="off" />
                    <label class="btn furnitureBtn" for="non" onclick="changeFurniture(false)">
                        غير مفروش
                    </label>

                    <input type="radio" class="btn-check" name="furniture" id="furnitureBtn"
                        autocomplete="off" />
                    <label class="btn furnitureBtn" for="ya" onclick="changeFurniture(true)">
                        مفروش
                    </label>
                </div>
            </div>
        </div>
        <button class="clear-filters" onclick="clearFilters()">اعادة تعيين</button>
    </div>
    <figure class="aqar-photo">
        <a href="{{ route('front.ad.create') }}">
            <img src="{{ asset('front-end/images/add-aqar.png') }}" />
        </a>
    </figure>
</div>
@push('custom-script')
    <script>
        const clearFilters = () => {
            location.href = location.origin + location.pathname;
        };
    </script>
@endpush
