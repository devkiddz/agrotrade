@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Deposit into your account
    </h1>
    <livewire:user.deposit.index />
@endsection
