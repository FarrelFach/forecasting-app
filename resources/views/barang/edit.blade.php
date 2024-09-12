@extends('layouts.template')
@section('title', 'Data Barang')
@section('content')
<div class="container">
    <h2>Edit Item</h2>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit form -->
    <form action="{{ route('barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $barang->name }}" required>
        </div>
        <div class="form-group">
            <label for="name">Quantity</label>
            <input type="text" class="form-control" id="quantity" name="quantity" value="{{ $barang->quantity }}" required>
        </div>
        <div class="form-group">
                    <label for="forecastItem">Category</label>
                    <select class="form-control" id="category" name='category' required>
                        @foreach($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

        <!-- Add other fields -->

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
