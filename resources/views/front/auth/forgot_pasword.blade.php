@extends('front.layouts.guest')

@section('content')
    <section class="login">
        <div class="container">
            <div class="title">
                <h2>Forgot <span class="alt-text">Password</span></h2>
            </div>
            <div>
                @if (Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif
            </div>
            <div class="flex tab-cards">
                <form action="{{ route('password.email') }}" class="login-form" method="post" enctype="multipart/form-data">
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

                    <div class="form-group form-submit">
                        <input type="submit" class="button" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
