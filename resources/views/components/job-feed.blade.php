@inject('carbon', 'Carbon\Carbon') 
@forelse ($jobs as $job )
    <div class="card">
        <div class="above">
            <img src="{{ asset('assets/images/favicon.png') }}" alt="" class="logo">
            <div class="post-details">
                <h5><a href="{{ route('job.details', ['id' => Crypt::encrypt($job->id)]) }}">{{ $job->title }}</a>
                    @if ($viewType == 2)
                        @can('company')
                            <span>Total Applied: {{ $job->applied_count }}</span>
                        @endcan
                    @endif
                </h5>
                <ul>
                    <li><i class="fa fa-map-marker"></i>{{ $job->location }}</li>
                    <li><i class="fa fa-briefcase"></i>Exp: {{ $job->experience }}</li>
                    <li><i class="fa fa-dollar"></i>Salary: @if ($job->salary_type == 'fixed')
                            ${{ $job->salary }}
                        @endif
                        @if ($job->salary_type == 'range')
                            ${{ $job->salary }} - ${{ $job->max_salary }}
                        @endif
                        / Per Month
                    </li>
                    <li><i class="fa fa-clock-o"></i>Posted On:
                        {{ $carbon->parse($job->created_at)->format('d M , Y') }}</li>
                    <li><i class="fa fa-clock-o"></i>Deadline: {{ $carbon->parse($job->deadline)->format('d M , Y') }}
                    </li>
                </ul>
            </div>
            @if ($viewType == 2)
                @can('company')
                    <div class="total_resume">
                        <div class="compny_job_btn"><span>{{ $job->status == 1 ? 'Active' : 'Deleted' }}</span></div>
                        @if ($job->status == 1)
                            <ul>
                                <li><a href="{{ route('job.edit', ['id' => Crypt::encrypt($job->id)]) }}">Edit</a></li>
                                <li><a href="#" onclick="return confirm('Are you sure?')">Delete</a></li>
                            </ul>
                        @endif
                    </div>
                @endcan

                @can('employee')
                    @php
                        $jobStatus = jobDeadLineCheck($job->deadline);
                    @endphp
                    <div class="total_resume">
                        <div class="compny_job_btn">
                            @if ($jobStatus || $job->status != 1)
                                <span>Deleted or Expired</span>
                            @else
                                <span>Active</span>
                            @endif
                        </div>
                    </div>
                @endcan
            @endif
        </div>
        <div class="bottom">
            <ul class="timeline">
                @foreach (json_decode($job->job_type, true) as $type)
                    <li>{{ $type }}</li>
                @endforeach
            </ul>
            @if ($viewType == 2)
                <div class="company_job_btn">
                    @can('company')
                        <a href="{{ route('myjob.details', ['id' => Crypt::encrypt($job->id)]) }}" class="button">View</a>
                    @endcan
                    @can('employee')
                        <a href="{{ route('job.details', ['id' => Crypt::encrypt($job->id)]) }}" class="button">Job
                            Details</a>
                    @endcan
                </div>
            @endif

            @if ($viewType == 1 && $job->user_applied == null)
                <a href="{{ route('job.details', ['id' => Crypt::encrypt($job->id)]) }}" class="button apply-btn">Apply</a>
            @endif
            @if ($job->user_applied)
                <a href="#" class="button" disabled>Applied</a>
            @endif
        </div>
    </div>

@empty

@endforelse
