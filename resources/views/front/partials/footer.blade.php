<footer>
    <div class="container">
        <ul class="footer-menu">
            <li><a href="{{ route('index') }}">home</a></li>
            @can('employee')
            <li><a href="{{ route('find.jobs') }}">Find a job</a></li>
            @endcan

            @can('company')

            <li class=""><a href="{{ route('find.candidates') }}">Find Candidate</a></li>
            <li><a href="{{ route('post.job') }}">Post a job</a></li>
            @endcan

            @guest
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
            @endguest
        </ul>
    </div>

    <div class="container copyright flex">
        <p>©Copyright 2024 My Rounder | All Rights Reserved.</p>
        <ul class="social">
            <li><a href=""><img src="{{ asset('assets/images/facebook.png') }}" alt=""></a></li>
            <li><a href=""><img src="{{ asset('assets/images/instagram.png') }}" alt=""></a></li>
            <li><a href=""><img src="{{ asset('assets/images/linkedin.png') }}" alt=""></a></li>
        </ul>
    </div>
</footer>
