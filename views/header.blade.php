<header class="header">
    <div class="header-top">
        <div class="container">
            @include('includes.exchange')
            @if (have_rows('social_networks', 'option'))
                <div class="follow-list">
                    @include('includes.social')
                </div>
            @endif
        </div>
    </div>
    <div class="header-middle">
        <a href="{{get_bloginfo('url')}}"><img src="@option(logo)" class="logo" alt="logo"></a>
    </div>
    <div class="header-bottom">
        <div class="container">
            <button class="mobile-btn" id="mobile-btn"><span></span><span></span><span></span></button>
            <a href="{{get_bloginfo('url')}}" class="home-link {{is_front_page() ? 'active' : '' }}">
                @icon(home)
                Главная</a>
            <a href="{{get_bloginfo('url')}}" class="logo-mob">
                <img src="@option(logo_mobile)" alt="logo-mob">
            </a>
            <nav class="menu-container">
                {!!  wp_nav_menu([
                    'menu' => 'header',
                    'container' => null,
                    'menu_class' => 'menu',
                    'echo' => false
                ])!!}
            </nav>
            <div class="panel-user">
                <button class="icon panel-item" id="search-btn">
                    @icon(search)
                </button>
                @include('includes.profile')
                @include('includes.search')
            </div>
        </div>
    </div>
</header>