@php $last = new WP_Query(['posts_per_page' => 7]) @endphp
<div class="sidebar-articles">
    <div class="sidebar-title text-center text-uppercase">Лента новостей</div>
    @while ($last->have_posts())
        @php $last->the_post() @endphp
        @include('articles.includes.item-small')
    @endwhile
    <a href="{{get_the_permalink(48)}}" class="all-news">Все новости</a>
</div>