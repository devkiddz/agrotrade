@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <div class="d-flex justify-content-between mb-5">
        <div>
            <h1 class="h2 m-0">
                {{ $lesson->title }}
            </h1>
            <p class="m-0">{{ $lesson->description }}</p>
        </div>

        @if ($course)
            <div>
                <a href="{{ route('user.mycoursedetails', ['id' => $course->id]) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </a>
            </div>
        @endif
    </div>

    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe width="100%" height="500" class="embed-responsive-item" src="{{ $lesson->video_link }}"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
@endsection
