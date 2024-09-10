@extends('front.layouts.app')

@section('content')
<section class="dash-banner">
    <div class="container">
        @php
        $users = $job->users;
        @endphp
        <h2>{{ $job->title }}</h2>
    </div>
</section>

<section class="jobs-details single_job">
    <div class="container flex">
        <div class="col left sidebar">
            <h5>Job Information</h5>
            <div class="details flex">
                <div class="list">
                    <i class="fa fa-map-marker"></i>
                    <div class="content">
                        <p class="list-head">Vacancies:</p>
                        <p class="list-des">{{ $job->vacancies }} Person</p>
                    </div>
                </div>
                <div class="list">
                    <i class="fa fa-desktop"></i>
                    <div class="content">
                        <p class="list-head">Budget/Salary:</p>
                        @if($job->salary_type === 'fixed')
                        <p class="list-des">Fixed Salary ( ${{ $job->salary }} )</p>

                        @elseif ($job->salary_type === 'range')
                        <p class="list-des">${{ $job->salary }} - ${{ $job->max_salary }}</p>
                        @endif
                    </div>
                </div>
                @isset($job->job_type)
                <div class="list">
                    <i class="fa fa-briefcase"></i>
                    <div class="content">
                        <p class="list-head">Job Type:</p>
                        @foreach (json_decode($job->job_type,true) as $type )
                        <p class="list-des">{{ $type }}</p>
                        @endforeach
                    </div>
                </div>
                @endisset

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
                        @foreach (json_decode($job->qualification,true) as $val )
                        <p class="list-des">{{ $val }}</p>
                        @endforeach
                    </div>
                    @endisset
                </div>
                <div class="list">
                    <i class="fa fa-clock-o"></i>
                    <div class="content">
                        <p class="list-head">Deadline:</p>
                        <p class="list-des">{{ Carbon\Carbon::parse($job->deadline)->format('d M , Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col right">

            <div class="job-cards">
                <h4>Candidates Applie for this jobs</h4>
                @forelse ($users as $user )
                <div class="card single_card">
                    <div class="above">
                        <div class="post-details">
                            <h5><a href="#">{{ $user->user->user_name }}</a></h5>
                            <ul>
                                <li><i class="fa fa-envelope-o" aria-hidden="true"></i>{{ $user->user->email }}</li>
                                <li><i class="fa fa-map-marker"></i>{{ $user->user->country ?$user->user->country->name .' ,' :'' }} {{ $user->user->state ?$user->user->state->name .' ,' :'' }} {{ $user->user->city?$user->user->city->name:'' }}</li>
                                <li><i class="fa fa-phone" aria-hidden="true"></i>{{ $user->user->phone }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="bottom">
                        <a href="{{ route('resume',['userId'=>Crypt::encrypt($user->user->id),'jobId'=>Crypt::encrypt($job->id)]) }}" class="button">Resume</a>
                    </div>
                </div>
                @empty
                <p>No Candiadate applied Yet</p>
                @endforelse
            </div>
            {{ $users->links() }}
        </div>
    </div>
</section>
@endsection
