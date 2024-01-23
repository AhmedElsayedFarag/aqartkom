$(document).ready(function () {



    $(window).on('scroll', function () {
        if ($(window).scrollTop() >= 95 && !$('nav').hasClass('fixed')) {
            $('nav').addClass('fixed');
            $('.pagination-nav').removeClass("fixed");
        } else if ($(window).scrollTop() < 95 && $('nav').hasClass('fixed')) {
            $('nav').removeClass('fixed')
        }
    });

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 95) {

            $(".navbar").addClass("clean");
        } else {
            $(".navbar").removeClass("clean");
        }
    });



    $('#slider').owlCarousel({

        autoplay: true,
        rtl: true,
        loop: true,
        nav: true,
        dots: true,
        transitionStyle: true,
        autoplayTimeout: 6000,
        smartSpeed: 1000,
        navText: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });


    
    
    


    $('#home').owlCarousel({

        autoplay: true,
        rtl: true,
        loop: true,
        nav: true,
        dots: true,
        margin: 20,
        transitionStyle: true,
        autoplayTimeout: 6000,
        smartSpeed: 1000,
        navText: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    });


    $('#client').owlCarousel({

        autoplay: true,
        rtl: true,
        loop: true,
        nav: true,
        dots: true,
        margin: 20,
        transitionStyle: true,
        autoplayTimeout: 6000,
        smartSpeed: 1000,
        navText: false,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    });
    
    
      $('#test').owlCarousel({

        autoplay: true,
        rtl: true,
        loop: true,
        nav: true,
        dots: true,
        margin: 20,
        transitionStyle: true,
        autoplayTimeout: 6000,
        smartSpeed: 1000,
        navText: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
      $('#big').owlCarousel({
        autoplay: true,
        rtl: true,
        loop: true,
        URLhashListener: true,
        autoplayHoverPause: true,
        margin: 20,
        nav: false,
        dots: false,
        transitionStyle: true,
        autoplayTimeout: 10000,
        navText: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    
        $('#product').owlCarousel({
        autoplay: true,
        rtl: true,
        loop: true,
        URLhashListener: true,
        autoplayHoverPause: true,
        margin: 20,
        nav: false,
        dots: false,
        transitionStyle: true,
        autoplayTimeout: 10000,
        navText: false,
        responsive: {
            0: {
                items: 3
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });
  



    $('#nav-men').click(function() {
        $('#s-nav').addClass('nav-go');
        $('#sa').show();
    });

    $('#overlay,.men-cl').click(function() {
        $('#s-nav').removeClass('nav-go');
    });

    $('#sa').on('click', function() {
        $('#s-nav').removeClass('nav-go');
        $('.nav-go').hide();
        $('#sa').hide();

    });
    

 
});


// play video
$(document).on('click', '.js-videoPoster', function(ev) {
    ev.preventDefault();
    var $poster = $(this);
    var $wrapper = $poster.closest('.js-videoWrapper');
    videoPlay($wrapper);
});

function videoPlay($wrapper) {
    var $iframe = $wrapper.find('.js-videoIframe');
    var src = $iframe.data('src');
    $wrapper.addClass('videoWrapperActive');
    $iframe.attr('src', src);
}

function videoStop($wrapper) {
    if (!$wrapper) {
        var $wrapper = $('.js-videoWrapper');
        var $iframe = $('.js-videoIframe');
    } else {
        var $iframe = $wrapper.find('.js-videoIframe');
    }
    $wrapper.removeClass('videoWrapperActive');
    $iframe.attr('src', '');
}





