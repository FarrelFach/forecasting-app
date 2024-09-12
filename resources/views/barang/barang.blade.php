@extends('layouts.template')
@section('title', 'Data Barang')
@section('content')
<div class="container">
    <div class="row">
              <div class="col-2">
                    <a href="{{ route('upload-brg') }}" class="btn btn-primary">Go to Upload Page</a>
                  </div>
</div>
<div class="row">
                @foreach($barang as $data)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $data->name }}</h5>
                                <p class="card-text">{{ $data->quantity }}</p>
                                <p class="card-text"><strong>Category: </strong>{{ $data->kategori->name }}</p>
                                <div class="row">
                                    <div class="col">
                                    <a href="{{ route('barang.edit', $data->id) }}" class="btn btn-primary">Edit</a>
                                    </div>
                                    <div class="col">
                                    <form action="{{ route('barang.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
          </div>
@endsection
