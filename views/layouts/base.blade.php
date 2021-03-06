<!doctype html>
<html lang="{{get_bloginfo('language')}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{wp_get_document_title_fixed()}}</title>
    @yield('header')
    {{wp_head()}}
</head>
<body {{body_class()}} >
@include('header')
<main class="content container">
    @yield('content')
</main>
@include('footer')
{{wp_footer()}}
</body>
</html>