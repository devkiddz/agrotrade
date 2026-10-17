@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Refer users to {{ $settings->site_name }} community
    </h1>
    <livewire:user.referral-system />
@endsection
