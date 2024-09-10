@extends('front.layouts.app')
  
@section('content')
@inject('carbon','Carbon\Carbon' )
<section class="dash-banner">
    <div class="container">
        <h2>My<span class="alt-text">Jobs</span></h2>
        <h5>{{ Str::ucfirst(Auth::user()->company_name) }}</h5>
    </div>
</section>

<section class="featured-jobs company_job">
    <div class="container">
        <form action="" class="search-form">
            <div class="inline">
                <div class="form-group">
                    <div class="adv-input">
                        <i class="fa fa-list"></i>
                        <select name="category" id="category" class="form-input">
                            <option value="" selected disabled>Job Category</option>
                            @foreach ($data['job_categories'] as $category )
                            <option value="{{ $category->id }}" {{ request()->category == $category->id ?'selected':'' }}>{{ $category->name }}</option>

                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="adv-input">
                        <i class="fa fa-list"></i>
                        <select name="type" id="type" class="form-input">
                            <option value="" selected disabled>Job Type</option>
                            @foreach ($data['job_types'] as $type )
                            <option value="{{ $type->name }}" {{ request()->type == $type->name ?'selected':'' }}>{{ $type->name }}</option>

                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="adv-input">
                        <i class="fa fa-list"></i>
                        <select name="industry" id="industry" class="form-input">
                            <option value="" selected disabled>Job Industry</option>
                            @foreach ($data['job_industries'] as $type )
                            <option value="{{ $type->id }}" {{ request()->industry == $type->id ?'selected':'' }}>{{ $type->name }}</option>

                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group form-submit">
                    <input type="submit" class="button" value="Search">
                </div>
            </div>
        </form>

        <div class="job-cards" id="job_crd">
            <x-job-feed  :data="$data['jobs']" :type="2"/>
        </div>
        {{ $data['jobs']->links() }}
        {{-- <a id="loadMoreBtn" class="button">Load More</a> --}}
    </div>

</section>
@endsection
