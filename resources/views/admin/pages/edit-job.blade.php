@extends('admin.layouts.admin')
@section('style')
    <style>
        .radio.inline {
            display: flex;
            justify-content: space-between;
        }

        .extra-fields .conditional-field.show {
            display: flex;
            justify-content: space-between;
        }

        .extra-fields .conditional-field {
            display: none;
        }
    </style>
@endsection

@section('content')
    @inject('carbon', 'Carbon\Carbon')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Jobs Details Update</h4>
                    @php
                        $job = $data['job'];
                    @endphp
                    <form action="{{ route('update.job', ['jobId' => $job->id]) }}" class="add-job" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($job))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="job_title">Job Title</label>
                            <div class="adv-input">
                                <input type="text" id="job_title" name="job_title" class="form-control"
                                    placeholder="Senior UI/UX Designer" value="{{ old('title', $job->title ?? '') }}">
                            </div>
                            @error('job_title')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="job_role">Job Role</label>
                            <div class="adv-input">
                                <select name="job_role" id="job_role" class=" form-control">
                                    <option value="" selected disabled>Select job Role</option>
                                    @forelse($data['job_roles'] as $key => $role)
                                        <option value="{{ $role->id }}"
                                            {{ $role->id == old('job_role', $job->job_role ?? '') ? 'selected' : '' }}>
                                            {{ $role->name }}</option>
                                    @empty
                                        <option value="" disabled selected>Select job Role</option>
                                    @endforelse

                                </select>
                            </div>
                            @error('job_role')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="job_industry">Job Industry</label>
                            <div class="adv-input">
                                <select name="job_industry" id="job_industry" class="form-control">
                                    <option value="" selected disabled>Select job Industry</option>
                                    @forelse($data['job_industries'] as $key => $value)
                                        <option value="{{ $value->id }}"
                                            {{ $value->id == old('job_industry', $job->job_industry ?? '') ? 'selected' : '' }}>
                                            {{ $value->name }}</option>
                                    @empty
                                        <option value="" selected disabled>Select job Industry</option>
                                    @endforelse
                                </select>
                            </div>
                            @error('job_industry')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="job_type">Job Type</label>
                            <div class="adv-input">
                                <select name="job_type[]" id="job_type" class="form-control select-wrap" multiple>
                                    @forelse($data['job_types'] as $key => $value)
                                        <option value="{{ $value->name }}"
                                            {{ in_array($value->name, old('job_type', json_decode($job->job_type ?? '[]', true) ?? [])) ? 'selected' : '' }}>
                                            {{ $value->name }}</option>
                                    @empty
                                        <option value="" selected disabled>Select job type</option>
                                    @endforelse
                                </select>
                            </div>
                            @error('job_type')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="job_category">Job Category</label>
                            <div class="adv-input">
                                <select name="job_category" id="job_category" class="form-control">
                                    <option value="" selected disabled>Select job category</option>
                                    @forelse($data['job_categories'] as $key => $value)
                                        <option value="{{ $value->id }}"
                                            {{ $value->id == old('job_category', $job->job_category ?? '') ? 'selected' : '' }}>
                                            {{ $value->name }}</option>
                                    @empty
                                        <option value="" selected disabled>Select job category</option>
                                    @endforelse
                                </select>
                            </div>
                            @error('job_category')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="qualifications">Qualifications</label>
                            <div class="adv-input">
                                <select name="qualification[]" id="qualifications" class="form-control select-wrap" multiple
                                    placeholder="Select job ">
                                    @forelse($data['qualifications'] as $key => $value)
                                        <option value="{{ $value->name }}"
                                            {{ in_array($value->name, old('qualification', json_decode($job->qualification ?? '[]', true) ?? [])) ? 'selected' : '' }}>
                                            {{ $value->name }}</option>
                                    @empty
                                        <option value="" selected disabled>Select job Qualifications</option>
                                    @endforelse
                                </select>
                            </div>
                            @error('qualification')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vacancies">Vacancies</label>
                                    <div class="adv-input">
                                        <input type="text" id="vacancies" name="vacancies" class="form-control"
                                            placeholder="03 Persons" value="{{ old('vacancies', $job->vacancies ?? '') }}">
                                    </div>
                                    @error('vacancies')
                                        <p>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exp">Experience Level</label>
                                    <div class="adv-input">
                                        <input type="text" id="exp" name="experience" class="form-control"
                                            placeholder="Type Experience"
                                            value="{{ old('experience', $job->experience ?? '') }}">
                                    </div>
                                    @error('experience')
                                        <p>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="">Budget/Salary</label>
                                <div class="salary radio inline">
                                    <label><input type="radio" name="salary_type" value="fixed" class="fixed"
                                            {{ isset($job) ? ($job->salary_type === 'fixed' ? 'checked' : '') : '' }}>Fixed
                                        Salary</label>
                                    <label><input type="radio" name="salary_type" value="range" class="salary-range"
                                            {{ isset($job) ? ($job->salary_type === 'range' ? 'checked' : '') : '' }}>Salary
                                        Range</label>
                                    {{-- <label><input type="radio" name="salary_type" value="negotiable" class="form-control">Negotiable</label> --}}
                                </div>
                                <div class="extra-fields">
                                    <div class="adv-input conditional-field {{ isset($job) ? ($job->salary_type === 'fixed' ? 'show' : '') : '' }}"
                                        id="fixed_salary">
                                        <input type="number" name="fixed_salary" class="form-control"
                                            placeholder="Salary" value="{{ $job->salary ?? '' }}">
                                    </div>
                                    <div class="inline extra-field conditional-field {{ isset($job) ? ($job->salary_type === 'range' ? 'show' : '') : '' }}"
                                        id="salary_range">
                                        <div class="form-group">
                                            <div class="adv-input">
                                                <input type="number" name="min_salary" class="form-control"
                                                    placeholder="Min Salary" value="{{ $job->salary ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="adv-input">
                                                <input type="number" name="max_salary" class="form-control"
                                                    placeholder="Max Salary" value="{{ $job->max_salary ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <div class="adv-input">
                                <input type="date" id="deadline" name="deadline" class="form-control"
                                    placeholder="DD-MM-YY"
                                    value="{{ old('deadline', $carbon->parse($job->deadline ?? '')->format('Y-m-d')) }}">
                            </div> @error('deadline')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="job_desc">Job Description</label>
                            <div class="adv-input">
                                <textarea name="job_desc" id="job_desc" cols="30" rows="10" class="form-control"
                                    placeholder="Job Description">{{ old('job_desc', $job->description ?? '') }}</textarea>
                            </div>
                            @error('job_desc')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="radio inline">
                                @isset($job)
                                    <label><input type="radio" name="location" value="current_location" class=" "
                                            {{ old('location') == 'current_location' ? 'checked' : 'checked' }}>location</label>
                                    <label><input type="radio" name="location" value="other_location" class=" "
                                            {{ old('location') == 'other_location' ? 'checked' : '' }}>{{ isset($job) ? 'Update' : 'Other' }}
                                        location</label>
                                @endisset
                            </div>

                            <div class="inline" id="profile-details-wrap">
                                <div>
                                    @isset($job)
                                        <h6 style="margin-left: 38px">{{ $job->location }}</h6>
                                    @endisset
                                </div>
                            </div>


                            <div class="d-flex justify-content-between {{ $job ? (old('location') == 'other_location' ? '' : 'd-none') : '' }} "
                                id="locations-wrap">
                                <div class="form-group">
                                    <select name="country" id="country" class="form-control select-wrap">
                                        <option value="">Select Country</option>
                                    </select>
                                    @error('country')
                                        <p>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <select name="state" id="state" class="form-control select-wrap">
                                        <option value="">Select State</option>
                                    </select>
                                    @error('state')
                                        <p>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <select name="city" id="city" class="form-control select-wrap">
                                        <option value="">Select City</option>
                                    </select>
                                    @error('city')
                                        <p>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @isset($job)
                            <div class="form-group" id="status-wrap">
                                <label for="status">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1" {{ 1 === old('status', $job->status ?? null) ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="2" {{ 2 === old('status', $job->status ?? null) ? 'selected' : '' }}>
                                        Deleted</option>
                                </select>
                            </div>
                        @endisset
                        <div class="form-group form-submit">
                            <input type="submit" class="btn btn-primary"
                                value="{{ isset($job) ? 'Update Job' : 'Post Now' }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/12.3.1/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            console.log('working');
            $('.select-wrap').select2({
                theme: "classic",
                width: '100%'
            });

            $('input[name=location]').click(function() {

                if (this.value == 'current_location') {
                    $("#locations-wrap").addClass('d-none');
                    $("#profile-details-wrap").removeClass('d-none');
                }
                if (this.value == 'other_location') {
                    $("#locations-wrap").removeClass('d-none');
                    $("#profile-details-wrap").addClass('d-none');
                }
            });

            $('input[name=salary_type]').click(function() {

                if (this.value == 'range') {
                    $("#salary_range").addClass('show');
                    $("#fixed_salary").removeClass('show');
                }
                if (this.value == 'fixed') {
                    $("#fixed_salary").addClass('show');
                    $("#salary_range").removeClass('show');
                }
            });

            $('#country').select2({
                theme: "classic",
                width: '100%',
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
                width: '100%',
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
                width: '100%',
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


        ClassicEditor
            .create(document.querySelector('#job_desc'), {
                theme: 'classic',
                // Additional configuration options...
                simpleUpload: {
                    // The URL that the images are uploaded to.
                    uploadUrl: 'http://example.com',

                    // Enable the XMLHttpRequest.withCredentials property.
                    withCredentials: true,

                    // Headers sent along with the XMLHttpRequest to the upload server.
                    headers: {
                        'X-CSRF-TOKEN': 'CSRF-Token',
                        Authorization: 'Bearer <JSON Web Token>'
                    }
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    </script>
@endsection
