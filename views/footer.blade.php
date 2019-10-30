<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6 order-3 order-lg-0 text-center text-lg-left footer-description">
                    @option(registration)
                </div>
                <div class="col-md-12 col-lg-3 order-3 order-lg-0">
                    {!!  wp_nav_menu([
                        'menu' => 'Footer',
                        'container' => null,
                        'menu_class' => 'footer-menu text-center text-lg-left',
                        'echo' => false
                    ])!!}
                </div>
                <div class="col-md-12 col-lg-3">
                    <div class="media-title"><span>Мы в соцесетях</span></div>
                    @if (have_rows('social_networks', 'option'))
                        <div class="footer-follow">
                            @include('includes.social')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container d-flex justify-content-between flex-column flex-lg-row align-items-center">
            <p class="text-center text-lg-left">@option(copyright)</p>
            @include('includes.counters')
        </div>
    </div>
</footer>

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-login">
            <div class="modal-header text-center">
                <img src="{{asset('img/logo-orange.svg')}}" alt="logo-modal" class="modal-logo">
                <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                    <img src="{{asset('img/icons/close.svg')}}" alt="close-btn">
                </button>
            </div>
            <div class="modal-body">
                <div class="page-title text-center mb-3">Авторизация</div>
                <div class="text-center">Авторизируйтесь при помощи аккаунта в соцсетях:</div>
                {!! do_shortcode('[TheChamp-Login]') !!}
            </div>
        </div>
    </div>
</div>