@extends('front.layouts.guest')

@section('content')
    <section class="login">
        <div class="container">
            <div class="title">
                <h2>Reset <span class="alt-text">Password</span></h2>
            </div>
            <div>

            </div>
            <div class="flex tab-cards">
                <form action="{{ route('password.update') }}" method="POST" class="login-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
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
                    <div class="inline">
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="adv-input">
                                <i class="fa fa-eye-slash"></i><input type="password" id="password_confirmation"
                                    name="password_confirmation" class="form-input @error('password') is-invalid @enderror"
                                    placeholder="Password">
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="button">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
