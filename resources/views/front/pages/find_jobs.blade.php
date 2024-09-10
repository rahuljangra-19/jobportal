@extends('front.layouts.app')
@section('content')
    <section class="jobs">
        <div class="container flex">
            {{-- Job Filters component --}}
            <x-job-filter :data="$data" />
            <div class="right-content">
                <form action="{{ route('find.jobs') }}" method="get" class="search-form" id="search-form">
                    <div class="inline">
                        <div class="form-group">
                            <div class="adv-input">
                                <i class="fa fa-briefcase"></i><input type="text" id="title" name="title"
                                    class="form-input" placeholder="Job Title" value="{{ request()->title }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="adv-input">
                                <i class="fa fa-list"></i>
                                <input type="text" name="location" class="form-input" id="location" list="locations"
                                    placeholder="Job location" value="{{ request()->location }}">
                                <datalist id="locations">
                                    <option value="delhi">Delhi</option>
                                    <option value="chandigarh">Chandigarh</option>
                                    <option value="mohali">Mohali</option>
                                </datalist>
                            </div>
                        </div>
                        <div class="form-group form-submit">
                            <input type="submit" class="button" value="Search">
                        </div>
                    </div>
                </form>
                <div class="job-cards card-wrap" id="jobs-wrap">
                    <x-job-feed :data="$jobs" />
                </div>
                <div id="paginationLinks">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        var jobIndustryValues;
        var jobTypesValues;
        var jobRolesValues;
        var jobCategoryValues;
        var jobSalary;
        var Page;

        function handleCheckboxChange(className) {
            document.querySelectorAll(`input[class=${className}]`).forEach(element => {
                element.addEventListener('change', async function() {
                    await updateCheckedValues();
                    await updateURLParams();
                });
            });
        }

        // Handle different sets of checkboxes
        handleCheckboxChange('job_industry');
        handleCheckboxChange('job_types');
        handleCheckboxChange('job_roles');
        handleCheckboxChange('job_category');


        function updateCheckedValues() {
            jobIndustryValues = Array.from(document.querySelectorAll('input[class=job_industry]:checked'))
                .map(checkbox => checkbox.value);
            jobTypesValues = Array.from(document.querySelectorAll('input[class=job_types]:checked'))
                .map(checkbox => checkbox.value);
            jobRolesValues = Array.from(document.querySelectorAll('input[class=job_roles]:checked'))
                .map(checkbox => checkbox.value);
            jobCategoryValues = Array.from(document.querySelectorAll('input[class=job_category]:checked'))
                .map(checkbox => checkbox.value);
            Page = 1;
            getJobs();
        }

        // Function to get a query parameter by name
        function getQueryParam(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }


        // Get the 'range' parameter from the URL
        const urlRangeValue = getQueryParam('salary');
        const rangeInput = document.getElementById('range');
        const currentValueDisplay = document.getElementById('currentValue');

        if (urlRangeValue) {
            rangeInput.value = urlRangeValue;
            currentValueDisplay.textContent = urlRangeValue;
            jobSalary = urlRangeValue;
        } else {
            rangeInput.value = rangeInput.min;
            if (rangeInput.min == 0) {
                currentValueDisplay.textContent = '--';
            } else {
                currentValueDisplay.textContent = rangeInput.min;
            }
            jobSalary = rangeInput.min;
        }
        rangeInput.addEventListener('input', function() {
            if (this.value != 0) {
                currentValueDisplay.textContent = this.value;
            } else {
                currentValueDisplay.textContent = '--';
            }
            jobSalary = this.value;
            updateURLParams();
        });
        rangeInput.addEventListener('change', function() {
            if (this.value != 0) {
                currentValueDisplay.textContent = this.value;
            }
            jobSalary = this.value;
            getJobs();
        });

        // Function to update the URL parameters
        function updateURLParams() {
            const url = new URL(window.location);

            if (jobIndustryValues && jobIndustryValues.length > 0) {
                url.searchParams.set('industry', jobIndustryValues.join(','));
            } else {
                url.searchParams.delete('industry');
            }

            if (jobTypesValues && jobTypesValues.length > 0) {
                url.searchParams.set('types', jobTypesValues.join(','));
            } else {
                url.searchParams.delete('types');
            }
            if (jobRolesValues && jobRolesValues.length > 0) {
                url.searchParams.set('roles', jobRolesValues.join(','));
            } else {
                url.searchParams.delete('roles');
            }
            if (jobCategoryValues && jobCategoryValues.length > 0) {
                url.searchParams.set('category', jobCategoryValues.join(','));
            } else {
                url.searchParams.delete('category');
            }
            if (jobSalary) {
                if (jobSalary == '0') {
                    url.searchParams.delete('salary');
                } else {
                    url.searchParams.set('salary', jobSalary);
                }
            } else {
                url.searchParams.delete('salary');
            }

            if (Page) {
                url.searchParams.set('page', Page);
            } else {
                url.searchParams.delete('page');
            }

            window.history.pushState({}, '', url);
        }


        function getJobs() {
            $('#jobs-wrap').html(`<div class="image-wrapper loader-img">
                <img src="{{ asset('assets/loader.gif') }}" alt="Centered Image">
            </div>`);
            $.ajax({
                url: "{{ route('find.jobs') }}",
                method: 'GET',
                data: {
                    industry: jobIndustryValues,
                    types: jobTypesValues,
                    roles: jobRolesValues,
                    category: jobCategoryValues,
                    salary: jobSalary,
                    title: $('#title').val(),
                    location: $('#location').val(),
                    page: Page
                },
                success: function(result) {
                    if (result.status == 200) {
                        $('#jobs-wrap').html(result.data);
                        $('#paginationLinks').html(result.pagination);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var urlPage = $(this).attr('href');
            const url = new URL(urlPage);
            let params = new URLSearchParams(url.search);
            Page = params.get("page");
            updateURLParams();
            getJobs();
        });

        $(document).ready(function() {
            $('.filter h5').on('click', function() {
                var $contentBody = $(this).next('.filter ul');
                $('.filter ul').not($contentBody).slideUp();
                $contentBody.slideToggle();
            });
        });
    </script>
@endsection
