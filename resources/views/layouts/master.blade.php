<!doctype html>
<html lang="en">
    <head>
        @include('layouts.subviews.header')
        @yield('header')
        @stack('css')
        <title>@yield('title')</title>
    </head>
    <body>
        @include('layouts.subviews.navbar')
        <div class="container">
            @include('layouts.subviews.errors')
            @include('flash::message')
            @yield('content')
            @stack('modals')
        </div>
        @include('layouts.subviews.footer')
        @yield('footer')
        @stack('scripts')
    </body>
</html>
