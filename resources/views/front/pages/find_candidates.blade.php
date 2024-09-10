@extends('front.layouts.app')

@section('content')
    <section class="jobs">
        <div class="container flex">
            <x-emp-filter /> 
            <div class="right-content">
                <form action="{{ route('find.candidates') }}" method="GET" class="search-form">
                    <div class="inline">
                        <div class="form-group">
                            <div class="adv-input">
                                <i class="fa fa-briefcase"></i><input type="text" id="profile" name="profile"
                                    class="form-input" placeholder="Job Profile" value="{{ request()->profile }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="adv-input">
                                <i class="fa fa-list"></i>
                                <input type="text" name="location" class="form-input" id="location" list="locations"
                                    placeholder="Location" value="{{ request()->location }}">
                                <datalist id="locations">
                                    <option value="delhi">Delhi</option>
                                    <option value="chandigarh">Chandigarh</option>
                                    <option value="mohali">Mohali</option>

                                </datalist>
                            </div>
                        </div>
                        <div class="form-group form-submit">
                            <button class="button" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <div class="candid-cards card-wrap" id="emp-wrap">
                    <x-emp-feed :data="$data" />
                </div>
                <div id="paginationLinks">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        var industryValues;
        var Page;

        function handleCheckboxChange(className) {
            document.querySelectorAll(`input[class=${className}]`).forEach(element => {
                element.addEventListener('change', async function() {
                    var checkedValues = Array.from(document.querySelectorAll(
                            `input[class=${className}]:checked`))
                        .map(checkbox => checkbox.value);
                    console.log(checkedValues);
                    await updateCheckedValues();
                    await updateURLParams();
                });
            });
        }

        // Handle different sets of checkboxes
        handleCheckboxChange('industry');

        function updateCheckedValues() {
            industryValues = Array.from(document.querySelectorAll('input[class=industry]:checked'))
                .map(checkbox => checkbox.value);
            Page = 1;
            getEmployees();
        }

        // Function to get a query parameter by name
        function getQueryParam(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Function to update the URL parameters
        function updateURLParams() {
            const url = new URL(window.location);

            if (industryValues && industryValues.length > 0) {
                url.searchParams.set('industry', industryValues.join(','));
            } else {
                url.searchParams.delete('industry');
            }
            if (Page) {
                url.searchParams.set('page', Page);
            } else {
                url.searchParams.delete('page');
            }
            window.history.pushState({}, '', url);
        }


        function getEmployees() {

            $('#emp-wrap').html(`<div class="image-wrapper loader-img">
                <img src="{{ asset('assets/loader.gif') }}" alt="Centered Image">
            </div>`);
            $.ajax({
                url: "{{ route('find.candidates') }}",
                method: 'GET',
                data: {
                    industry: industryValues,
                    profile: $('#profile').val(),
                    location: $('#location').val(),
                    page: Page
                },
                success: function(result) {
                    if (result.status == 200) {
                        $('#emp-wrap').html(result.data);
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
            getEmployees();
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
