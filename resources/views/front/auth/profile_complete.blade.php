@extends('front.layouts.app');
@section('content')
    <section class="register profile">
        <div class="container">
            <div class="title">
                <h2>Profile <span class="alt-text">Complete</span></h2>
            </div>
            <div class="tabs-content">
                <div class="flex tab-cards active" id="category-two">
                    <form method="POST" class="register-form" action="{{ route('profile') }}" id="registration-form"
                        enctype="multipart/form-data" autocomplete="off" novalidate>
                        @csrf
                        @can('employee')
                            @if (Auth::user()->loginType == 2 && empty(Auth::user()->email))
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
                            @endif

                            <div class="inline">
                                <div class="form-group">
                                    <label for="profile">Job Profile</label>
                                    <div class="adv-input">
                                        <i class="fa fa-list"></i>
                                        <input type="text" id="profile" name="profile"
                                            class="form-input @error('profile') is-invalid @enderror" placeholder="Job profile"
                                            value="{{ old('profile') }}" required>
                                    </div>
                                    @error('profile')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="inline">
                                <div class="form-group">
                                    <label for="industry">Industry</label>
                                    <div class="adv-input">
                                        <i class="fa fa-clock-o"></i>
                                        <select name="industry" id="industry" class="form-input">
                                            <option value="" selected disabled>Select job Industry</option>
                                            @forelse($data['job_industries'] as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ $value->id == old('industry') ? 'selected' : '' }}>{{ $value->name }}
                                                </option>
                                            @empty
                                                <option value="" selected disabled>Select job Industry</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    @error('industry')
                                        <p>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endcan
                        <div class="inline">
                            <div class="form-group">
                                <div>
                                    <img src="public/assets/images/candidate.png" alt="" class="logo d-none"
                                        id="previceImage">
                                </div>
                                <div class="form-group">
                                    <label for="image">Profile Image</label>
                                    <div class="adv-input">
                                        <i class="fa fa-file"></i>
                                        <input type="file" accept="image/*" onchange="previewImage(event,'previceImage')"
                                            id="image" name="image"
                                            class="form-input @error('image') is-invalid @enderror" required>
                                    </div>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <div class="adv-input">
                                    <i class="fa fa-user"></i>
                                    <input type="tel" id="phone" name="phone"
                                        class="form-input @error('phone') is-invalid @enderror" placeholder="Phone"
                                        value="{{ old('phone') }}" required>
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="inline">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select name="country" id="country"
                                    class="form-input @error('country') is-invalid @enderror" required>

                                </select>
                                @error('country')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="inline">
                            <div class="form-group">
                                <label for="state">State</label>
                                <select name="state" id="state"
                                    class="form-input @error('state') is-invalid @enderror" required>

                                </select>
                                @error('state')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="inline">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select name="city" id="city"
                                    class="form-input @error('city') is-invalid @enderror" required>

                                </select>
                                @error('city')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @can('employee')
                            <div class="inline">
                                <div class="form-group">
                                    <label for="qualification">Qualification</label>
                                    <div class="adv-input">
                                        <i class="fa fa-list"></i>
                                        <select name="qualification[]" id="qualification"
                                            class="form-input @error('qualification') is-invalid @enderror" required multiple>
                                            @foreach ($data['qualifications'] as $value)
                                                <option value="{{ $value->name }}"
                                                    {{ in_array($value->name, old('qualification', [])) ? 'selected' : '' }}>
                                                    {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('qualification')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="inline">
                                <div class="form-group">
                                    <label for="exp">Experience</label>
                                    <div class="adv-input">
                                        <i class="fa fa-user"></i>
                                        <input type="text" id="exp" name="exp"
                                            class="form-input @error('exp') is-invalid @enderror"
                                            placeholder="Experience 1.6 , 1 , 5 " value="{{ old('exp') }}" required>
                                    </div>
                                    @error('exp')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="inline">
                                <div class="form-group">
                                    <label for="skills">Skills</label>
                                    <div class="adv-input">
                                        <i class="fa fa-list"></i>
                                        <select name="skills[]" id="skills"
                                            class="form-input @error('skills') is-invalid @enderror" required multiple>
                                            @foreach (config('job.skills') as $key => $type)
                                                <optgroup label="{{ $key }}">
                                                    @foreach ($type as $value)
                                                        <option value="{{ $value }}"
                                                            {{ in_array($value, old('skills', [])) ? 'selected' : '' }}>
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('skills')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="inline">
                                <div class="form-group">
                                    <label for="resume">Resume</label>
                                    <div class="adv-input">
                                        <i class="fa fa-file"></i>
                                        <input type="file" accept="application/pdf" id="resume" name="resume"
                                            class="form-input @error('resume') is-invalid @enderror" required>
                                    </div>
                                    @error('resume')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if (Auth::user()->loginType == 2)
                                <div class="inline">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <div class="adv-input">
                                            <i class="fa fa-eye-slash"></i>
                                            <input type="password" id="password" name="password"
                                                class="form-input @error('password') is-invalid @enderror"
                                                placeholder="Password" autocomplete="off">
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        @endcan

                        <div class="form-group form-submit">
                            <input type="submit" class="button" value="Complete">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#skills').select2({
                placeholder: 'Select your skills'
            });
            $('#qualification').select2({
                placeholder: 'Select your qualifications'
            });


            $('#country').select2({
                theme: "classic",
                ajax: {
                    url: '{{ route('country') }}',
                    dataType: 'json',
                    delay: 500,
                    data: function(params) {
                        return {
                            search: params.term // search term
                                ,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1 // start searching after typing 1 character
            });
            $('#state').select2({
                theme: "classic",
                ajax: {
                    url: '{{ route('state') }}',
                    dataType: 'json',
                    delay: 500,
                    data: function(params) {
                        return {
                            search: params.term // search term
                                ,
                            page: params.page || 1,
                            country_id: $('#country').val()
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1 // start searching after typing 1 character
            });
            $('#city').select2({
                theme: "classic",
                ajax: {
                    url: '{{ route('city') }}',
                    dataType: 'json',
                    delay: 500,
                    data: function(params) {
                        return {
                            search: params.term // search term
                                ,
                            page: params.page || 1,
                            state_id: $('#state').val()
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1 // start searching after typing 1 character
            });

            $('#country').on('change', function() {
                $('#state').val(null).trigger('change');
                $('#city').val(null).trigger('change');
            });

            $('#state').on('change', function() {
                $('#city').val(null).trigger('change');
            });

        });


        var previewImage = function(event, output) {
            var output = document.getElementById(output);
            output.src = URL.createObjectURL(event.target.files[0]);
            output.classList.remove('d-none');
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
@endsection
