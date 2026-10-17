@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Your Courses/learning center
    </h1>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                @forelse ($courses as $course)
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{ str_starts_with($course->course->course_image, 'http') ? $course->course->course_image : asset('storage/app/public/' . $course->course->course_image) }}"
                                class="card-img-top" alt="course image">
                            <div class="card-body">
                                <h5 class="font-weight-bolder">{{ $course->course->course_title }}</h5>
                                <div class="d-flex justify-content-between align-items-center my-2">
                                    <div class="d-flex align-items-center">
                                        <i class="mr-1 bi bi-book"></i>
                                        &nbsp;
                                        <span>
                                            {{ count($course->lessons) }}
                                            {{ count($course->lessons) > 1 ? 'Lessons' : 'Lesson' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{ route('user.mycoursedetails', $course->course->id) }}"
                                        class="btn btn-primary btn-block d-flex align-items-center justify-content-center">
                                        <i class="bi bi-play-circle-fill mr-1"></i>
                                        &nbsp;
                                        <span>Watch</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body text-center py-2">
                                <p>No Data Available</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
