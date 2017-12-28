<!doctype html>
<html lang="en">
    <head>
        @include('layouts.subviews.headder')
        <title>@yield('title')</title>
    </head>
    <body>
        @include('layouts.subviews.navbar')
        <div class="container">
        @include('layouts.subviews.errors')
        @yield('content')
        </div>
@include('layouts.subviews.footer')
    </body>
</html>
