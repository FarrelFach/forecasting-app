@extends('layouts.template')
@section('title', 'Edit Penjualan')
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
    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">WO</label>
            <input type="text" class="form-control" id="wo" name="wo" value="{{ $penjualan->wo }}" required>
        </div>
        <div class="form-group">
            <label for="name">Invoice</label>
            <input type="text" class="form-control" id="invoice" name="invoice" value="{{ $penjualan->invoice }}" required>
        </div>
        <div class="form-group">
            <label for="name">Client</label>
            <input type="text" class="form-control" id="client" name="client" value="{{ $penjualan->client }}" required>
        </div>
        <div class="form-group">
            <label for="name">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $penjualan->description }}" required>
        </div>
        <div class="form-group">
            <label for="name">Quantity</label>
            <input type="text" class="form-control" id="quantity" name="quantity" value="{{ $penjualan->quantity }}" required>
        </div>
        <div class="form-group">
                    <label for="forecastItem">Jenis Barang</label>
                    <select class="form-control" id="barang" name='barang' required>
                        @foreach($barang as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

        <!-- Add other fields -->

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
