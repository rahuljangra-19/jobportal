@forelse ($data as $emp )
<div class="card">
    <div class="above">
        @php
        // Check if the feature_image key exists and is not empty
        $imagePath = isset($emp->image) ? env('IMAGE_PATH') .$emp->image : null;
        @endphp

        @if ($imagePath && File::exists(storage_path('app/'.$emp->image)))
        <img src="{{ $imagePath }}" alt="" class="logo">
        @else
        <img src="{{ asset('assets/images/candidate.png') }}" alt="" class="logo">
        @endif
        <div class="post-details">
            <h5 class="position">{{ $emp->profile }}</h5>
            <p class="name">{{ $emp->first_name }} {{ $emp->last_name }}</p>
            <ul>
                @isset($emp->location)
                <li><i class="fa fa-map-marker"></i>{{ $emp->location }}</li>
                @endisset
                @isset($emp->exp)
                <li><i class="fa fa-briefcase"></i>{{ $emp->exp }}</li>
                @endisset

                @isset($emp->phone)
                <li><i class="fa fa-phone"></i>{{ $emp->phone }}</li>
                @endisset

                <li><i class="fa fa-envelope"></i>{{ $emp->email }}</li>
            </ul>
        </div>
    </div>
    <div class="bottom">
        <ul class="skills">
            @foreach ($emp->skills as $skill )
            <li>{{ $skill->name }}</li>
            @endforeach
        </ul>
        <a href="{{ route('resume',['userId'=>Crypt::encrypt($emp->id)]) }}" class="button">Resume</a>
    </div>
</div>
@empty

@endforelse
