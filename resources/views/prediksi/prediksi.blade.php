@extends('layouts.template')
@section('title', 'Test-forecasting')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card card-horizontal">
                <div class="card-header">
                    <h5 class="card-title">Weighted Moving Average Calculator</h5>
                </div>
                <div class="card-body">
                    
                    <form method="POST" action="{{ route('forecast-real') }}">
                    @csrf
                        <!-- Number of Periods -->
                        <div class="form-group">
                            <label for="numPeriods">Jumlah bulan yang akan digunakan dalam perhitungan</label>
                            <input type="number" class="form-control" id="numPeriods" placeholder="Enter number of periods" required>
                        </div>

                        <!-- Weights -->
                        <div class="form-group">
                            <label for="weights"><p>Bobot</p> 
                            <ul>
                            <li>Bobot yang akan digunakan dalam perhitungan</li>
                            <li>Bobot jika ditotal harus menjadi 1</li>
                            <li>Setiap bobot harus dipisahkan dengan koma</li>
                            <li>Jumlah bobot harus sesuai dengan periode</li>
                            </ul></label>
                            <input type="text" class="form-control" id="weights" name='weights' placeholder="Enter weights (e.g., 0.2, 0.3, 0.5)" required>
                        </div>

                        <!-- Item to be Forecasted -->
                        <div class="form-group">
                            <label for="forecastItem">Barang apa yang ingin dihitung stok inventori kedepannya?</label>
                            <select class="form-control" id="itemid" name='itemid' required>
                                @foreach($barang as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Calculate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(isset($forecast))
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-light rounded">
                    <h5 class="mb-3 text-primary">Predikis untuk {{ $item->barang->name }}</h5>
                    <p class="mb-1">Based on the following parameters:</p>
                    <ul class="list-unstyled ms-3 mb-3">
                        <li><strong>Periode:</strong> {{ $numWeights }}</li>
                        <li><strong>Bobot:</strong> {{ $weights }}</li>
                    </ul>
                    <div class="alert alert-info mt-3" role="alert">
                        <strong>Jumlah stok inventory:</strong> {{$forecast}} units
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
<div>
@endsection