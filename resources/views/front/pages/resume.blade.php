@extends('front.layouts.app')

@section('content')
    <section class="dash-banner">
        <div class="container">

            @if ($resume && isset($resume->cover_letter))
                    <h2>Cover Letter</h2>
            @else
                <h2>Resume</h2>
            @endif
        </div>
    </section>

    <section class="jobs-details cover_letter">
        <div class="container">
            @isset($resume)
                <div class="col right">
                    @if ($resume->cover_letter)
                        <h2>Cover Letter</h2>
                        <p>{{ $resume->cover_letter }}</p>
                    @endif
                </div>
            @endisset
            <div class="resume_sec">
                @if ($resume)
                    <iframe src="{{ env('IMAGE_PATH') . '/' . $resume->file }}"
                        style="width: 100%;height: 100vh !important;"></iframe>
                    <a href="{{ route('download.resume', ['file' => $resume->file]) }}" class="button">Download</a>
                @else
                    <P>Profile not completed .</P>
                @endif

            </div>
        </div>
    </section>
@endsection
