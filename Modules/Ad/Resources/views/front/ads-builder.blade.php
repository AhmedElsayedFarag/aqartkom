<script>
    const buildAds = (ads) => {
        const adsContainerResults = document.querySelector("#result-ads .row");
        const adsHtml = ads
            .map((ad) => {
                //  <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#not-licensed-ad-modal"
                // class="watch-details">
                let adLink = "";
                if (ad.is_licensed) {
                    adLink = ` <a href="${ad.link}"`;
                } else {
                    adLink =
                        ` <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#not-licensed-ad-modal"`;
                }
                return `
                    <div class="col-lg-6 col-md-6" id="favorite-${ad.uuid}" data-sal-duration="700" data-sal="slide-up">
                        <div class="feat">
                            <div class="parent d-flex">
                                <div class="photo">
                                    ${adLink}>
                                        <img src="${ad.estate.media[0].url}" class="photo" />
                                    </a>
                                        <div class="d-flex">
                                        ` +
                    `
                                        <div class="verify ${ad.is_licensed?'':'unactive'} ">
                                            <span>${ad.is_licensed?'مرخص':'غير مرخص'}</span>
                                        </div>` + `
                                    </div>
                                </div>
                                <div class="info">
                                    <p class="title">
                                         ${adLink}>
                                            ${ad.estate.title}
                                        </a>
                                    </p>
                                    <p class="sub-title">${ad.estate.address}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span><img src="{{ asset('front-end/images/menu (3).png') }}">${ad.type_text}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span><img
                                                        src="{{ asset('front-end/images/Group 539.png') }}">${ad.accepted_at}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span><img
                                                        src="{{ asset('front-end/images/Group 44848.svg') }}">${ad.meter_price}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span><img
                                                        src="{{ asset('front-end/images/Group 44464.svg') }}">${ad.estate.area} متر</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="price">
                                                <p>${ad.price} ريال</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             ${adLink}
                                class="watch-details">
                                مشاهدة تفاصيل الإعلان
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                `;
            })
            .join("");
        if (currentPage == 1)
            adsContainerResults.innerHTML = adsHtml;
        else
            adsContainerResults.innerHTML += adsHtml;
    };
</script>
