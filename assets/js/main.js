(function ($) {
    function menu() {
        $("#search-btn, .search-box .close-btn").click((e) => {
            e.stopPropagation();
            $('.search-box').toggleClass('open-search');
        });
        $('body').on('click', () => {
            const $search = $('.search-box');
            if ($search.hasClass('open-search')) $search.toggleClass('open-search');
        });
        $('.search-box').on('click', e => e.stopPropagation());
        $("#mobile-btn").click(() => {
            $('.mobile-btn').toggleClass('open');
            $('.menu-container').toggleClass('open-menu');
        });
    }

    function header() {
        if ($(this).scrollTop() > 157 && window.innerWidth > 991) {
            console.log(2);
            $('body').addClass('stick');
            $(".header").addClass('sticky-header');
        } else {
            $('body').removeClass('stick');
            $(".header").removeClass('sticky-header');
        }
    }

    $(() => {
        menu();
        header();
        $('*[data-url]').on('click', function () {
            window.open($(this).data('url'));
        });
        $('#news-carousel').on('slide.bs.carousel', function (e) {
            const to = e.to + 1;
            $(this).find('.nav .active').removeClass('active');
            $(this).find(`.nav li:nth-child(${to})`).addClass('active');
        });
    });

    $(window).on('load resize scroll', () => header());

    $(window).on('load', () => {
        setTimeout(() => {
            $('.preloader .box').fadeOut(1000);
        }, 1000);
    });
})(jQuery);





