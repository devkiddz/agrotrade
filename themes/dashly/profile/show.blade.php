@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        {{ __('Security/Account Deletion') }}
    </h1>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="p-2 text-center col-md-12 p-md-3">
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div>
                    @livewire('profile.two-factor-authentication-form')
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="p-2 text-center col-md-12">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>
    </div>
    <div class="row">
        <div class="p-2 text-center col-md-12">
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />
                @livewire('profile.delete-user-form')
            @endif
        </div>
    </div>
@endsection
