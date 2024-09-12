@extends('layouts.template')
@section('title', 'input barang')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif(!session('success'))
                    <div class="alert alert-info">
                        No success message found.
                    </div>
                @endif
                <div class="card-header">{{ __('Dashboard') }}</div>
                
                <div class="card-body">
                        <form action="{{ route('import-brg') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Choose Excel File</label>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection