<section class="category">
    <div class="container">
        <div class="title">
            <h2>New Job <span class="alt-text">Openings</span></h2>
        </div>
        <div class="card-list flex">
            @forelse ($categories as $category )
            <div class="card">
                <div class="overlay">
                    <img src="{{ asset('assets/images/marketing.png') }}">
                </div>
                <div class="content">
                    <h4>{{ $category->name }}</h4>
                    <p>{{ $category->jobs_count }} Jobs Available</p>
                    <a href="{{ route('find.jobs',['category'=>$category->id]) }}" class="more">View All jobs</a>
                </div>
            </div>
            @empty

            @endforelse

        </div>
    </div>
</section>
