@logged
<a href="{{wp_logout_url(get_bloginfo('url'))}}" class="login-out panel-item">
    @icon(logout)
</a>
@else
    <button class="icon panel-item" data-toggle="modal" data-target="#loginModal">
        @icon(profile)
    </button>
@endif