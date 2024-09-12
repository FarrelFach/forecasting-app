@extends('layouts.template')
@section('title', 'home')
@section('content')
<div class="container mt-5">
    <div class="card" style="max-width: 600px;">
        <div class="row g-0">
            <!-- Image Section -->
            <div class="col-md-4">
                <img src="https://via.placeholder.com/150" class="img-fluid rounded-start" alt="Profile Image">
            </div>
            <!-- Profile Data Section -->
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Profile Information</h5>
                    <ul class="list-group list-group-flush">
                        <!-- These will be dynamically filled using Laravel -->
                        <li class="list-group-item">Name: {{ Auth::user()->name }}</li>
                        <li class="list-group-item">Email: {{ Auth::user()->email }}</li>
                        <li class="list-group-item">Password: {{ str_repeat('*', 8) }}</li>
                        <li class="list-group-item">Created At: {{ Auth::user()->created_at }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection