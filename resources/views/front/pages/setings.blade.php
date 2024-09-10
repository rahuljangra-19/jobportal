@extends('front.layouts.app')

@section('content')
    <section class="jobs-details profile_setting">
        <div class="container flex">
            <div class="col left sidebar">
                <div class="details flex">
                    <div class="settng_profile">
                        @php
                            // Check if the feature_image key exists and is not empty
                            $imagePath = isset($user->image) ? env('IMAGE_PATH') . $user->image : null;
                        @endphp

                        @if ($imagePath && File::exists(storage_path('app/' . $user->image)))
                            <img src="{{ $imagePath }}" alt="" id="previewImage">
                        @else
                            <img src="{{ asset('assets/images/candidate.png') }}" id="previewImage" alt="">
                        @endif
                        <a href="#" onclick="openMedia()">
                            <div class="edit-overlay"><i class="fa fa-camera" aria-hidden="true"></i> Replace</div>
                        </a>

                    </div>
                    <div class="list">
                        <div class="content">
                            @can('employee')
                                <p class="list-head">Full Name:</p>
                                <p class="list-des">{{ $user->user_name }}</p>
                            @endcan
                            @can('company')
                                <p class="list-head">Company Name:</p>
                                <p class="list-des">{{ $user->company_name }}</p>
                            @endcan
                        </div>
                    </div>
                    <div class="list">
                        @isset($user->email)
                            <div class="content">
                                <p class="list-head">Email:</p>
                                <p class="list-des">{{ $user->email }}</p>
                            </div>
                        @endisset
                    </div>
                    <div class="list">
                        @isset($user->phone)
                            <div class="content">
                                <p class="list-head">Phone Number:</p>
                                <p class="list-des">{{ $user->phone }}</p>
                            </div>
                        @endisset
                    </div>
                    <div class="list">
                        @if ($user->is_profile_completed)
                            <div class="content">
                                <p class="list-head">Location:</p>
                                @if (isset($user->city) && isset($user->state))
                                    <p class="list-des">{{ $user->city->name }} , {{ $user->state->name }} ,
                                        {{ $user->country->name }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                    @can('employee')
                        @isset($user->exp)
                            <div class="list">
                                <div class="content">
                                    <p class="list-head">Experience:</p>
                                    <p class="list-des">{{ $user->exp }}</p>
                                </div>
                            </div>
                        @endisset
                        <div class="list">
                            @isset($user->qualifications)
                                <div class="content">
                                    <p class="list-head">Qualifications:</p>
                                    @foreach (json_decode($user->qualifications, true) as $value)
                                        <p class="list-des">{{ $value }}</p>
                                    @endforeach
                                </div>
                            @endisset
                        </div>
                        @if (count($user->skills))
                            <div class="list">
                                <div class="content">
                                    <p class="list-head">Skills:</p>
                                    <ul class="skills">
                                        @foreach ($user->skills as $skill)
                                            <li>{{ $skill->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endcan
                </div>
            </div>
            <div class="col right">
                <div class="apply-div" id="apply-form">
                    <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data"
                        class="apply-job">
                        <h2>Profile <span class="alt-text">Setting</span></h2>
                        @csrf
                        <div class="inline">
                            <div class="form-group">
                                <label for="user_name">Username</label>
                                <div class="adv-input upload">
                                    <i class="fa fa-user"></i><input type="text" id="user_name" name="user_name"
                                        value="{{ $user->user_name }}" class="form-input" placeholder="User Name">
                                </div>
                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="inline">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <div class="adv-input">
                                    <i class="fa fa-user"></i><input type="text" id="first_name" name="first_name"
                                        value="{{ $user->first_name }}" class="form-input" placeholder="Your First Name">
                                </div>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <div class="adv-input">
                                    <i class="fa fa-user"></i><input type="text" id="last_name" name="last_name"
                                        value="{{ $user->last_name }}" class="form-input" placeholder="Your Last Name">
                                </div>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        @can('company')
                            <div class="inline">
                                <div class="form-group">
                                    <label for="company_name">Company name</label>
                                    <div class="adv-input">
                                        <i class="fa fa-list"></i>
                                        <input type="text" id="company_name" name="company_name"
                                            class="form-input @error('company_name') is-invalid @enderror"
                                            placeholder="Company name" value="{{ old('company_name', $user->company_name) }}"
                                            required>
                                    </div>
                                    @error('company_name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="inline">
                                <div class="form-group">
                                    <label for="company_type">Company Type</label>
                                    <div class="adv-input">
                                        <i class="fa fa-list"></i>
                                        <select name="company_type" id="company_type"
                                            class="form-input @error('company_type') is-invalid @enderror">
                                            <option value="" selected disabled>Select Company Type</option>
                                            @foreach (config('job.company_types') as $type)
                                                <option value="{{ $user->company_type }}"
                                                    {{ $type == old('company_type', $user->company_type) ? 'selected' : '' }}>
                                                    {{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('company_type')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('employee')
                            <div class="inline">
                                <div class="form-group">
                                    <label for="profile">Job Profile</label>
                                    <div class="adv-input">
                                        <i class="fa fa-list"></i>
                                        <input type="text" id="profile" name="profile"
                                            class="form-input @error('profile') is-invalid @enderror"
                                            placeholder="Job profile" value="{{ old('profile', $user->profile) }}" required>
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
                                                    {{ $value->id == old('industry', $user->industry_id) ? 'selected' : '' }}>
                                                    {{ $value->name }}</option>
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
                                <label for="profile">Profile Image</label>
                                <div class="adv-input">
                                    <i class="fa fa-user"></i>
                                    <input type="file" id="imageInput" name="image" class="form-input"
                                        accept="image/*">
                                </div>
                            </div>
                        </div>

                        <h5 class="sett_pro_bais">Basic Information</h5>
                        <div class="form-group">
                            <label for="phone">Phone No</label>
                            <div class="adv-input">
                                <i class="fa fa-phone"></i><input type="text" id="phone" name="phone"
                                    value="{{ $user->phone }}" class="form-input" placeholder="Phone No">
                            </div>
                        </div>
                        <div class="inline">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select name="country" id="country"
                                    class="form-input @error('country') is-invalid @enderror" required>
                                    <option value="{{ $user->country_id ?? '' }}" selected>
                                        {{ $user->country ? $user->country->name : '' }}</option>
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
                                    <option value="{{ $user->state_id ?? '' }}" selected>
                                        {{ $user->state ? $user->state->name : '' }}</option>

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
                                    <option value="{{ $user->city_id ?? '' }}" selected>
                                        {{ isset($user->city) ? $user->city->name : '' }}</option>

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
                                            class="form-input @error('qualification') is-invalid @enderror" multiple>
                                            @foreach ($data['qualifications'] as $value)
                                                <option value="{{ $value->name }}"
                                                    {{ in_array($value->name, old('qualification', json_decode($user->qualifications, true) ?? [])) ? 'selected' : '' }}>
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
                                            placeholder="Experience 1.6 years" value="{{ old('exp', $user->exp) }}">
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
                                            class="form-input @error('skills') is-invalid @enderror" multiple>
                                            @foreach (config('job.skills') as $key => $type)
                                                <optgroup label="{{ $key }}">
                                                    @foreach ($type as $value)
                                                        <option value="{{ $value }}"
                                                            {{ in_array($value, old('skills', $user->skills->pluck('name')->toArray() ?? [])) ? 'selected' : '' }}>
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
                                            class="form-input @error('resume') is-invalid @enderror">
                                    </div>
                                    @error('resume')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        <div class="form-group form-submit">
                            <input type="submit" class="button" value="Update">
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


        const imageInput = document.getElementById('imageInput');
        const previewImage = document.getElementById('previewImage');

        function previewSelectedImage() {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                }
            }
        }
        imageInput.addEventListener('change', previewSelectedImage);

        function openMedia() {
            $('#imageInput').click();
        }
    </script>
@endsection
