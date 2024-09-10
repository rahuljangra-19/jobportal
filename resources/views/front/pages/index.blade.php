@extends('front.layouts.app')

@section('content')

@if(Auth::guest() || (Auth::check() && auth()->user()->role == 'employee'))
<div class="banner">
    <div class="container">
        <h1>Looking for a <span class="alt-text">Job</span></h1>
        <p>10 lakh+ jobs for you to explore</p>
        <form action="{{ route('find.jobs') }}" method="get" class="search-form">
            <div class="inline">
                <div class="form-group">
                    <div class="adv-input">
                        <i class="fa fa-briefcase"></i><input type="text" name="title" class="form-input" placeholder="Job Title or Keywords">
                    </div>
                </div>
                <div class="form-group">
                    <div class="adv-input">
                        <i class="fa fa-map-marker"></i>
                        <input type="text" name="location" class="form-input" list="locations" placeholder="Job location">
                        <datalist id="locations">
                            <option value="delhi">Delhi</option>
                            <option value="chandigarh">Chandigarh</option>
                            <option value="mohali">Mohali</option>

                        </datalist>
                    </div>
                </div>
                <div class="form-group form-submit">
                    <button type="submit" class="button">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<section class="featured-jobs">
    <div class="container">
        <div class="title">
            <h2>Explore Job <span class="alt-text">Feed</span></h2>
        </div>
        <div class="job-cards" id="jobs-wrap">
            {{-- latest jobs --}}
            <x-job-feed :data="$jobs" />
        </div>
    </div>
</section>
@endif

@can('company')
<div class="banner">
    <div class="container">
        <h1>Looking for <span class="alt-text">candidates</span></h1>
        <p>10 lakh+ candidates for you to explore</p>
        <form action="{{ route('find.candidates') }}" method="get" class="search-form">
            <div class="inline">
                <div class="form-group">
                    <div class="adv-input">
                        <i class="fa fa-briefcase"></i><input type="text" name="profile" class="form-input" placeholder="Profile">
                    </div>
                </div>
                <div class="form-group">
                    <div class="adv-input">
                        <i class="fa fa-map-marker"></i>
                        <input type="text" name="location" class="form-input" list="locations" placeholder="location">
                        <datalist id="locations">
                            <option value="delhi">Delhi</option>
                            <option value="chandigarh">Chandigarh</option>
                            <option value="mohali">Mohali</option>

                        </datalist>
                    </div>
                </div>
                <div class="form-group form-submit">
                    <button type="submit" class="button">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<section class="featured-jobs">
    <div class="container">
        <div class="title">
            <h2>Explore Candidates <span class="alt-text">Feed</span></h2>
        </div>
        <div class="candid-cards card-wrap" id="emp-wrap">
            <x-emp-feed :data="$data" />
        </div>
    </div>
</section>

@endcan


{{-- brands --}}
<x-brands-bar />

@if(Auth::guest() || (Auth::check() && auth()->user()->role == 'employee'))
{{-- jobs category --}}
<x-job-category />
@endif

@endsection
