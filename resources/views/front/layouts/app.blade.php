<!DOCTYPE html>
<html lang="en">
<head>
    @include('front.partials.head')
    @yield('style')
</head>
<body>
    @include('front.partials.navbar')
    <main>
        @yield('content')
    </main>
    @include('front.partials.footer')
    @include('front.partials.scripts')
    @yield('scripts')
</body>
</html>
