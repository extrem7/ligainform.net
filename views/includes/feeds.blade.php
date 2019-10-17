@if (have_rows('feeds'))
    <div class="rss-list">
        @while (have_rows('feeds'))
            @php the_row() @endphp
            <a href="{{get_sub_field('link')}}" class="rss-item">{{get_sub_field('name')}}</a>
        @endwhile
    </div>
@endif