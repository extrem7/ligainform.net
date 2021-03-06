function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

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
        $('.the_champ_login_ul li').click(function () {
            setCookie('login_reload', true);
        });
        if (getCookie('login_reload')) {
            location.reload();
            setCookie('login_reload', false);
        }
    });

    $(window).on('load resize scroll', () => header());

    if (Notification.permission === 'granted')
        localStorage.setItem('onesignal-notification-prompt',
            JSON.stringify({value: "dismissed", timestamp: 1576054897083})
        );

    $(window).on('load', () => {
        setTimeout(() => {
            $('.preloader .box').fadeOut(1000);
        }, 1000);
    });
})(jQuery);