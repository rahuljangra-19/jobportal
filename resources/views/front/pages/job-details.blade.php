@extends('front.layouts.app')

@section('content')

    <section class="dash-banner">
        @can('employee')
            {{-- <div class="container"> 
        <h2>Back-End Developer</h2>
        <div class="inline">
            <img src="{{ asset('assets/images/candidate.png') }}" alt="">
    <div class="content">
        <p class="name">Jacoline Frankly</p>
        <p class="type">Candidate</p>
    </div>
    </div>
    <a href="#apply-form" class="more inline">Apply Now <img src="{{ asset('assets/images/right-arrow.png') }}" alt=""></a>
    </div> --}}
        @endcan
        <div class="container">
            <h5>{{ Str::ucfirst($job->title) }}</h5>
        </div>
    </section>

    @inject('carbon', 'Carbon\Carbon')
    <section class="jobs-details">
        <div class="container flex">
            <div class="col left sidebar">
                <h5>Job Information</h5>
                <div class="details flex">
                    @isset($job->job_type)
                        <div class="list">
                            <i class="fa fa-user"></i>
                            <div class="content">
                                <p class="list-head">Job Type:</p>
                                @foreach (json_decode($job->job_type, true) as $type)
                                    <p class="list-des">{{ $type }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endisset


                    <div class="list">
                        @isset($job->location)
                            <i class="fa fa-map-marker"></i>
                            <div class="content">
                                <p class="list-head">Location:</p>
                                <p class="list-des">{{ $job->location }}</p>
                            </div>
                        @endisset
                    </div>

                    <div class="list">
                        @isset($job->experience)
                            <i class="fa fa-briefcase"></i>
                            <div class="content">
                                <p class="list-head">Experience:</p>
                                <p class="list-des">{{ $job->experience }}</p>
                            </div>
                        @endisset
                    </div>
                    <div class="list">
                        @isset($job->qualification)
                            <i class="fa fa-graduation-cap"></i>
                            <div class="content">
                                <p class="list-head">Qualifications:</p>
                                @foreach (json_decode($job->qualification, true) as $val)
                                    <p class="list-des">{{ $val }}</p>
                                @endforeach
                            </div>
                        @endisset
                    </div>
                    <div class="list">
                        @isset($job->salary)
                            <i class="fa fa-usd"></i>
                            <div class="content">
                                <p class="list-head">Salary:</p>
                                <p class="list-des">${{ $job->salary }}</p>
                            </div>
                        @endisset
                    </div>
                    <div class="list">
                        <i class="fa fa-clock-o"></i>
                        <div class="content">
                            <p class="list-head">Date posted:</p>
                            <p class="list-des">{{ $carbon->parse($job->created_at)->format('d M , Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col right">
                <h5>Job Description:</h5>
                {!! $job->description !!}

                @php
                    $checkDeadline = jobDeadLineCheck($job->deadline);

                @endphp
                <div class="apply-div" id="apply-form">
                    @can('employee')
                        @if ($check)
                            <h2><span class="alt-text">Applied</span></h2>
                        @else
                            @if ($checkDeadline)
                                <h2>Job <span class="alt-text">Expired</span></h2>
                            @else
                                <h2>Apply <span class="alt-text">Now</span></h2>
                            @endif
                        @endif
                    @endcan

                    @guest
                        <div class="buttons-wrap">
                            <a href="{{ route('login') }}" class="button-alt">Log In</a>
                            <a href="{{ route('register') }}" class="button">Register</a>
                        </div>
                    @endguest
                    @can('employee')
                        @if ($check == null && $checkDeadline == false)
                            <form action="{{ route('apply.job') }}" method="post" enctype="multipart/form-data"
                                class="apply-job" id="apply-job-form">
                                @if (!$check)
                                    <input type="hidden" name="id" value="{{ request()->segment(2) }}">
                                @endif
                                @csrf
                                <div class="form-group">
                                    <label for="resume">Resume</label>
                                    <div class="adv-input upload">
                                        <i class="fa fa-upload"></i><input type="file" accept="application/pdf"
                                            id="resume" name="resume" class="form-input" placeholder="Resume">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="letter">Coverting Letter</label>
                                    <div class="adv-input">
                                        <textarea name="letter" id="letter" cols="30" rows="10" class="form-input"></textarea>
                                    </div>
                                </div>
                                <div>
                                    @if ($check)
                                        <button class="button" type="button" disabled>Applied</button>
                                    @else
                                        <button class="button" type="submit">Apply</button>
                                    @endif
                                </div>
                            </form>
                        @endcan
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
