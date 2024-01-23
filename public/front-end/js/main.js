const loadMazadCarousel = () => {
    $(".mzadSingle").owlCarousel({
        autoplay: false,
        rtl: true,
        loop: true,
        autoplayHoverPause: true,
        nav: false,
        dots: true,
        transitionStyle: true,
        autoplayTimeout: 10000,
        navText: false,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
    });
};
$(document).ready(function () {
    $("#stars li")
        .on("mouseover", function () {
            var onStar = parseInt($(this).data("value"), 10); // The star currently mouse on

            // Now highlight all the stars that's not after the current hovered star
            $(this)
                .parent()
                .children("li.star")
                .each(function (e) {
                    if (e < onStar) {
                        $(this).addClass("hover");
                    } else {
                        $(this).removeClass("hover");
                    }
                });
        })
        .on("mouseout", function () {
            $(this)
                .parent()
                .children("li.star")
                .each(function (e) {
                    $(this).removeClass("hover");
                });
        });

    /* 2. Action to perform on click */
    $("#stars li").on("click", function () {
        onStar = parseInt($(this).data("value"), 10); // The star currently selected
        stars = $(this).parent().children("li.star");

        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass("selected");
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass("selected");
        }
    });

    $("#order").select2({
        placeholder: "الترتيب حسب",
    });
    $("#city_select").select2({
        placeholder: "الرياض",
    });
    $("#city-select").select2({
        placeholder: "الرياض",
    });
    $("#advertiser_relation-select").select2({
        placeholder: "الرياض",
    });
    $("#city-input").select2({
        placeholder: "الرياض",
    });
    $("#country").select2({
        placeholder: "الرياض",
    });
    $("#destination").select2({
        placeholder: "تحديد الوجهة",
    });
    $("#neighborhood").select2({
        placeholder: "تحديد الوجهة",
    });
    $("#neighborhood-select").select2({
        placeholder: "تحديد الوجهة",
    });

    $("#lowest").select2({
        placeholder: "200000 رس",
    });
    $("#highest").select2({
        placeholder: "200000 رس",
    });
    $("#lowestPrice").select2({
        placeholder: "200000 رس",
    });
    $("#highestPrice").select2({
        placeholder: "200000 رس",
    });
    $("#lowestSize").select2({
        placeholder: "200000 رس",
    });
    $("#highestSize").select2({
        placeholder: "200000 رس",
    });
    $("#lowestArea").select2({
        placeholder: "200000 متر",
    });
    $("#highestArea").select2({
        placeholder: "200000 متر",
    });
    $("#type").select2({
        placeholder: "الرجاء تحديد نوع العقار للبيع أو الإيجار",
    });
    $("#cat").select2({
        placeholder: "الرجاء تحديد نوع العقار للبيع أو الإيجار",
    });
    $("#directionplace").select2({
        placeholder: "الرجاء تحديد واجهة المدينة",
    });
    $("#water").select2({
        placeholder: "الرجاء تحديد عدد دورات المياه",
    });
    $("#direction2").select2({
        placeholder: "الرجاء تحديد واجهة العقار",
    });
    $("#driver").select2({
        placeholder: "يوجد غرقة سائق",
    });
    $("#roomNum").select2({
        placeholder: "الرجاء تحديد عدد الغرف",
    });
    $("#kitchen").select2({
        placeholder: "يوجد مطبخ",
    });
    $("#salat").select2({
        placeholder: "الرجاء تحديد عدد الصالات",
    });
    $("#enterance").select2({
        placeholder: "يوجد مدخل سيارة",
    });
    $("#furniture").select2({
        placeholder: "الرجاء تحديد نوع التأثيث",
    });
    $("#elevator").select2({
        placeholder: "يوجد مصعد",
    });
    $("#category-select").select2({
        placeholder: "اختر الفئة",
    });
    $("#search").select2({
        placeholder: "كل المملكة",
    });

    $(window).on("scroll", function () {
        if ($(window).scrollTop() >= 95 && !$("#nav").hasClass("fixed")) {
            $("#nav").addClass("fixed");
            $(".pagination-nav").removeClass("fixed");
        } else if ($(window).scrollTop() < 95 && $("#nav").hasClass("fixed")) {
            $("#nav").removeClass("fixed");
        }
    });

    $("#aqarat").owlCarousel({
        autoplay: false,
        rtl: true,
        loop: true,
        URLhashListener: true,
        autoplayHoverPause: true,
        margin: 20,
        nav: true,
        dots: true,
        transitionStyle: true,
        autoplayTimeout: 10000,
        navText: [
            "<i class='fa fa-chevron-right'></i>",
            "<i class='fa fa-chevron-left'></i>",
        ],
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
    });

    $("#mzadPhotos").owlCarousel({
        autoplay: false,
        rtl: true,
        loop: true,
        autoplayHoverPause: true,
        nav: true,
        dots: false,
        transitionStyle: true,
        autoplayTimeout: 10000,
        navText: [
            "<i class='fa fa-chevron-right'></i>",
            "<i class='fa fa-chevron-left'></i>",
        ],
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
    });

    loadMazadCarousel();
});

/*  start of map location */

var locations = [
    [
        '<div class="mapFilter"><div class="photo"><img src="images/mapimage.png"></div><div class="words"><h2>فيلا للبيع حي النرجس</h2><h2 class="location">النرجس ، شمال ، الرياض</h2><h2 class="size">350 متر</h2><h2 class="time">تم إضافتها قبل 16 يوم</h2><h2 class="price">350 الف رس</h2></div></div><ul class="d-flex mapLinks"><li><a href="#">واتساب <img src="images/icons/whatsapp.svg"></a></li><li><a href="#">حجز موعد <i class="fa-solid fa-calendar-days"></i></a></li><li><a href="#">اتصل بنا <i class="fa-solid fa-phone-volume"></i></a></li></ul>',
        -33.80010128657071,
        151.28747820854187,
        2,
        "https://maps.google.com/mapfiles/ms/micons/blue.png",
    ],
    [
        '<div class="mapFilter"><div class="photo"><img src="images/mapimage.png"></div><div class="words"><h2>فيلا للبيع حي النرجس</h2><h2 class="location">النرجس ، شمال ، الرياض</h2><h2 class="size">350 متر</h2><h2 class="time">تم إضافتها قبل 16 يوم</h2><h2 class="price">350 الف رس</h2></div></div><ul class="d-flex mapLinks"><li><a href="#">واتساب <img src="images/icons/whatsapp.svg"></a></li><li><a href="#">حجز موعد <i class="fa-solid fa-calendar-days"></i></a></li><li><a href="#">اتصل بنا <i class="fa-solid fa-phone-volume"></i></a></li></ul>',
        -33.950198,
        151.259302,
        1,
        "https://maps.google.com/mapfiles/ms/micons/green.png",
    ],
];
// var map = new google.maps.Map(document.getElementById("map"), {
//     zoom: 10,
//     center: new google.maps.LatLng(-33.92, 151.25),
//     mapTypeId: google.maps.MapTypeId.ROADMAP,
// });
// var infowindow = new google.maps.InfoWindow();
// var marker, i;
// for (i = 0; i < locations.length; i++) {
//     marker = new google.maps.Marker({
//         position: new google.maps.LatLng(locations[i][1], locations[i][2]),
//         icon: locations[i][4],
//         map: map,
//     });
//     google.maps.event.addListener(
//         marker,
//         "click",
//         (function (marker, i) {
//             return function () {
//                 infowindow.setContent(locations[i][0]);
//                 infowindow.open(map, marker);
//             };
//         })(marker, i)
//     );
// }

function myFunction(id) {
    let pass = document.getElementById(id);
    if (pass.type === "password") {
        pass.type = "text";
    } else {
        pass.type = "password";
    }
}

function myFunction2(id) {
    let c = document.getElementById(id);
    if (c.type === "password") {
        c.type = "text";
    } else {
        c.type = "password";
    }
}

// upload img
$(function () {
    var e = {
        init: function () {
            e.setPreviewImg(), e.listenInput();
        },
        setPreviewImg: function (s) {
            var o = $(s).val(),
                i = $(s).siblings(".file-upload-text");
            o
                ? ((o = o.replace(/^C:\\fakepath\\/, "")),
                  $(i).val(o),
                  e.showPreview(s, o, i))
                : $(i).val("");
        },
        showPreview: function (e, s, o) {
            var i = $(e)[0].files;
            if (i && i[0]) {
                var t = new FileReader();
                (t.onload = function (i) {
                    var t = $(e)
                            .parents(".file-upload-wrapper")
                            .siblings(".preview"),
                        n = $(t).find("img");
                    0 === n.length
                        ? $(t).html(
                              '<img src="' + i.target.result + '" alt=""/>'
                          )
                        : n.attr("src", i.target.result),
                        o.val(s),
                        $.each($(".img-wrapper img"), function (e, s) {
                            var o = $(s).attr("src");
                            $(s)
                                .parent()
                                .css(
                                    "background",
                                    "url(" + o + ") no-repeat center center"
                                )
                                .css("background-size", "cover"),
                                $(s).remove();
                        });
                }),
                    (t.onloadstart = function () {
                        $(o).val("uploading..");
                    }),
                    t.readAsDataURL(i[0]);
            }
        },
        listenInput: function () {
            $(".file-upload-native").on("change", function () {
                e.setPreviewImg(this);
            });
        },
    };
    e.init();
});
