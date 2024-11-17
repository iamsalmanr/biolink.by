(function ($) {
    'use strict';

    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 200) {
            $('.navbar-area').addClass("is-sticky");
        } else {
            $('.navbar-area').removeClass("is-sticky");
        }
    });

    $(window).on('load', function () {
        var preload = $('.ctn-preloader');
        if (preload.length > 0) {
            preload.delay(800).fadeOut('slow');
        }
    })
    $('.reviews-slider3').owlCarousel({
        loop: false,
        margin: 20,
        nav: false,
        dots: true,
        thumbs: false,
        thumbsPrerendered: false,
        autoplay: false,
        responsive: {0: {items: 1,}, 576: {items: 1,}, 768: {items: 2,}, 992: {items: 2,}, 1200: {items: 2,},}
    });

    $('.filter-button-slider').owlCarousel({
        loop: true,
        margin: 16,
        autoWidth:true,
        nav: true,
        dots: false,
        thumbs: false,
        thumbsPrerendered: false,
        navText: ['<i class="fa-regular fa-arrow-left-long"></i>', '<i class="fa-regular fa-arrow-right-long"></i>',],
        responsive: {0: {items: 2,}, 576: {items: 5,}, 768: {items: 6,}, 992: {items: 6,}, 1200: {items: 6,},}
    });

    $(document).ready(function () {
        $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
            disableOn: 100,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    });

    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {enabled: true, navigateByImgClick: true, preload: [0, 1]},
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.', titleSrc: function (item) {
                return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
            }
        }
    });

    $(function () {
        $('.shorting').mixItUp();
    });
    let el = document.getElementById('filt-monthly');
    if (el) {
        let e = document.getElementById("filt-monthly"), d = document.getElementById("filt-yearly"),
            t = document.getElementById("switcher"), m = document.getElementById("monthly"),
            y = document.getElementById("yearly");
        e.addEventListener("click", function () {
            t.checked = false;
            e.classList.add("toggler--is-active");
            d.classList.remove("toggler--is-active");
            m.classList.remove("hide");
            y.classList.add("hide");
        });
        d.addEventListener("click", function () {
            t.checked = true;
            d.classList.add("toggler--is-active");
            e.classList.remove("toggler--is-active");
            m.classList.add("hide");
            y.classList.remove("hide");
        });
        t.addEventListener("click", function () {
            d.classList.toggle("toggler--is-active");
            e.classList.toggle("toggler--is-active");
            m.classList.toggle("hide");
            y.classList.toggle("hide");
        });
    }
    $('.tab-menu li a').on('click', function () {
        var target = $(this).attr('data-rel');
        $('.tab-menu li a').removeClass('active');
        $(this).addClass('active');
        $("#" + target).fadeIn('slow').siblings(".tab-box").hide();
        return false;
    });

    $('.accordion').find('.accordion-title').on('click', function () {
        $(this).toggleClass('active');
        $(this).next().slideToggle('fast');
        $('.accordion-content').not($(this).next()).slideUp('fast');
        $('.accordion-title').not($(this)).removeClass('active');
    });

    if ($('.range-slider-area').length) {
        $(".range-slider-area .range-slider").slider({
            range: true,
            min: 1900,
            max: 2030,
            values: [1923, 2023],
            slide: function (event, ui) {
                $(".range-slider-area .count").text(ui.values[0] + " - " + ui.values[1]);
            }
        });
        $(".range-slider-area .count").text($(".range-slider").slider("values", 0) + " - " + $(".range-slider").slider("values", 1));
    }
    if ($('.area-range-slider').length) {
        $(".area-range-slider").slider({
            range: true, min: 0, max: 100, values: [0, 50], slide: function (event, ui) {
                $(".area-amount").text(ui.values[1]);
            }
        });
        $(".area-amount").text($(".area-range-slider").slider("values", 1));
    }

    $('.burger-menu').on('click', function () {
        $(this).toggleClass('active');
        $('.main-content').toggleClass('hide-sidemenu-area');
        $('.sidemenu-area').toggleClass('toggle-sidemenu-area');
        $('.top-navbar').toggleClass('toggle-navbar-area');
    });
    $('.responsive-burger-menu').on('click', function () {
        $('.responsive-burger-menu').toggleClass('active');
        $('.sidemenu-area').toggleClass('active-sidemenu-area');
    });
    try {
        document.getElementById("year").innerHTML = new Date().getFullYear();
    } catch (err) {
    }
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip()
    });


    $(window).on('scroll', function () {
        var scrolled = $(window).scrollTop();
        if (scrolled > 300) $('.go-top').addClass('active');
        if (scrolled < 300) $('.go-top').removeClass('active');
    });
    $('.go-top').on('click', function () {
        $("html, body").animate({scrollTop: "0"}, 500);
    });
    /**
     * SVGInject
     * Replaces an img element with an inline SVG so you can apply colors to your SVGs
     * Requires assets/js/vendor/svg-inject.min.js
     */
    SVGInject.setOptions({
        onFail: function(img, svg) {
            img.classList.remove('svg-inject');
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        SVGInject(document.querySelectorAll('img.svg-inject'), {
            useCache: true
        });
    });

    $('body').append("<div class='vertical-element left d-none'><div class='switch-box'><label id='switch' class='switcher'><input type='checkbox' onchange='toggleTheme()' id='slider'><span class='slider round'></span><span class=\"labels\" data-on=\"Dark\" data-off=\"Light\"></span></label></div></div>");
})(jQuery);
new WOW().init();
try {
    function setTheme(themeName) {
        localStorage.setItem('quickcms_theme', themeName);
        document.documentElement.className = themeName;
    }

    function toggleTheme() {
        if (localStorage.getItem('quickcms_theme') === 'theme-dark') {
            setTheme('theme-light');
        } else {
            setTheme('theme-dark');
        }
    }

    (function () {
        if (localStorage.getItem('quickcms_theme') === 'theme-dark') {
            setTheme('theme-dark');
            document.getElementById('slider').checked = false;
        } else {
            setTheme('theme-light');
            document.getElementById('slider').checked = true;
        }
    })();
} catch (err) {
}
