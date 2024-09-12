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
                        <label for="numPeriods">Number of Periods</label>
                        <input type="number" class="form-control" id="numPeriods" placeholder="Enter number of periods" required>
                    </div>

                    <!-- Weights -->
                    <div class="form-group">
                        <label for="weights"><p>Weights</p> 
                        <ul>
                        <li>comma-separated</li>
                        <li>must match number of period</li>
                        </ul></label>
                        <input type="text" class="form-control" id="weights" name='weights' placeholder="Enter weights (e.g., 0.2, 0.3, 0.5)" required>
                    </div>

                    <!-- Item to be Forecasted -->
                    <div class="form-group">
                        <label for="forecastItem">What type of item do you want to forecast?</label>
                        <select class="form-control" id="itemid" name='itemid' required>
                            @foreach($barang as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
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
<div>
@endsection