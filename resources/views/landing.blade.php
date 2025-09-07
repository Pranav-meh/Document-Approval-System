@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1>Welcome to Document Approval System</h1>
    <p>Please login or register to continue.</p>
    <div class="mt-4">
        <a href="{{ route('login') }}" class="btn btn-primary mx-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-success mx-2">Register</a>
    </div>
</div>
@endsection
