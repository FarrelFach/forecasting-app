@extends('layouts.template')
@section('title', 'home')
@section('content')
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="row g-0">
            <!-- Image Section -->
            <div class="col-md-4 d-flex justify-content-center align-items-center">
                <img src="https://via.placeholder.com/150" class="img-fluid rounded-circle" alt="Profile Image">
            </div>
            <!-- Profile Data Section -->
            <div class="col-md-8">
                <div class="card-body">
                    <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" >
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Jabatan</label>
                            <input type="text" class="form-control" id="role" name="role" value="Bagian {{ Auth::user()->role }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                        </div>

                        <!-- Add other fields -->

                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection