@extends('front.layouts.guest')

@section('content')
    <section class="login">
        <div class="container">
            <div class="title">
                <h2>Login <span class="alt-text">Account</span></h2>
            </div>
            <div>

            </div>
            <div class="flex tab-cards">
                {{-- <div>
                @if (session()->has('error'))
                <div class="alert alert-success error">
                    {{ session('error') }}
        </div>
        @endif
    </div> --}}
                <form action="{{ route('login.post') }}" class="login-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="inline">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="adv-input">
                                <i class="fa fa-envelope"></i><input type="email" id="email" name="email"
                                    class="form-input  @error('email') is-invalid @enderror" placeholder="Email">
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="inline">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="adv-input">
                                <i class="fa fa-eye-slash"></i><input type="password" id="password" name="password"
                                    class="form-input @error('password') is-invalid @enderror" placeholder="Password">
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group checkbox inline">
                        <label>
                            <input type="checkbox" name="remember" value="1" class="form-input ">Remember Me
                        </label>
                        <a href="{{ route('password.request') }}">Forget Password?</a>
                    </div>
                    <div class="form-group form-submit">
                        <input type="submit" class="button" value="Login">
                    </div>
                    <p class="inline-text">Don’t have an account? <a href="{{ route('register') }}">Sign Up</a> Here</p>
                    <div class="row">
                        <div class="col-3">
                            <div>
                                <a href="{{ url('login/google') }}" class="btn btn-soft-danger w-100"><i
                                        class="mdi mdi-google"></i>Google </a>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                <a href="{{ url('login/facebook') }}" class="btn btn-soft-info w-100"><i
                                        class="mdi mdi-facebook"></i>Facebook</a>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                <a href="{{ url('login/instagram') }}" class="btn btn-soft-danger w-100"><i
                                        class="mdi mdi-instagram"></i>Instagram</a>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                <a href="{{ url('login/linkedin') }}" class="btn btn-soft-danger w-100"><i
                                        class="mdi mdi-linkedin"></i>LinkedIn</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
