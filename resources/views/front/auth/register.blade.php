@extends('front.layouts.guest');
@section('content')
<section class="register">
    <div class="container">
        <div class="title">
            <h2>Register <span class="alt-text">Account</span></h2>
        </div>
        <div class="tabs-content">
            <div class="tabs">
                <ul>
                    <li onclick="toggleRole('employee')" class="{{ old('role', 'employee') == 'employee' ? 'active' : '' }}">Candidate</li>
                    <li onclick="toggleRole('company')" class="{{ old('role') == 'company' ? 'active' : '' }}">Employer</li>
                </ul>
            </div>

            <div class="flex tab-cards active" id="category-two">
                <form method="POST" class="register-form" action="{{ route('register') }}" id="registration-form">
                    @csrf
                    <input type="radio" name="role" id="role-candidate" value="employee" {{ old('role') == 'employee' ?'checked':'' }} class="d-none">
                    <input type="radio" name="role" id="role-employer" value="company" {{ old('role') == 'company' ? 'checked':'' }}  class="d-none">

                    <div class="inline">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <div class="adv-input">
                                <i class="fa fa-user"></i>
                                <input type="text" id="first_name" name="first_name" class="form-input @error('first_name') is-invalid @enderror" placeholder="First Name" value="{{ old('first_name') }}">
                            </div>
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <div class="adv-input">
                                <i class="fa fa-user"></i>
                                <input type="text" id="last_name" name="last_name" class="form-input @error('last_name') is-invalid @enderror" placeholder="Last Name" value="{{ old('last_name') }}">
                            </div>
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="inline">
                        <div class="form-group">
                            <label for="user_name">User Name</label>
                            <div class="adv-input">
                                <i class="fa fa-user"></i>
                                <input type="text" id="user_name" name="user_name" class="form-input @error('user_name') is-invalid @enderror" placeholder="User Name" value="{{ old('user_name') }}">
                            </div>
                            @error('user_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="adv-input">
                                <i class="fa fa-envelope"></i>
                                <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="inline" id="employer-fields" style="display: none;">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <div class="adv-input">
                                <i class="fa fa-briefcase"></i>
                                <input type="text" id="company_name" name="company_name" class="form-input @error('company_name') is-invalid @enderror" placeholder="Company Name" value="{{ old('company_name') }}">
                            </div>
                            @error('company_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="company_type">Company Type</label>
                            <div class="adv-input">
                                <i class="fa fa-list"></i>
                                <select name="company_type" id="company_type" class="form-input @error('company_type') is-invalid @enderror">
                                    <option value="" selected disabled>Select Company Type</option>
                                    @foreach (config('job.company_types') as $type )
                                    <option value="{{ $type }}" {{ $type == old('company_type') ?'selected':''  }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('company_type')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="inline">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="adv-input">
                                <i class="fa fa-eye-slash"></i>
                                <input type="password" id="password" name="password" class="form-input @error('password') is-invalid @enderror" placeholder="Password" autocomplete="off">
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="adv-input">
                                <i class="fa fa-eye-slash"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group checkbox">
                        <label>
                            <input type="checkbox" name="terms" class="form-input @error('terms') is-invalid @enderror"> Here, I will agree to the company terms & conditions.
                        </label>
                        @error('terms')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group form-submit">
                        <input type="submit" class="button" value="Sign Up">
                    </div>
                    <p class="inline-text">Already have an account? <a href="{{ route('login') }}">Login</a> Here</p>
                    {{-- <p class="inline-text"><a href="{{ url('login/google') }}" class="google-btns"><img src="{{ asset('assets/images/google.png') }}" alt="Google Logo"> Continue with Google</a></p> --}}

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
    </div>

</section>

@endsection

@section('scripts')

<script>
    const employerFields = document.getElementById('employer-fields');
    const candidateRadio = document.getElementById('role-candidate');
    const employerRadio = document.getElementById('role-employer');

    function toggleRole(role) {

        if (role === 'company') {
            employerFields.style.display = 'block';
            employerRadio.checked = true;
            document.getElementById('role-candidate').classList.add('active');
            document.getElementById('role-employer').classList.remove('active');
        } else {
            employerFields.style.display = 'none';
            candidateRadio.checked = true;
            document.getElementById('role-employer').classList.add('active');
            document.getElementById('role-candidate').classList.remove('active');
        }
    }


    document.addEventListener('DOMContentLoaded', function() {
        if (employerRadio.checked) {
            employerRadio.checked = true;
            employerFields.style.display = 'block';
        } else {
            candidateRadio.checked = true;
            employerFields.style.display = 'none';
        }
    });

</script>
@endsection
