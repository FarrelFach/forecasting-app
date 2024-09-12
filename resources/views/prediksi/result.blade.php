@extends('layouts.template')
@section('title', 'Test-forecasting')
@section('content')
<div class="container">
    <div class="row">
        <!-- Small Box 1 -->
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $weight }}</h3>
                    <p>Set Weight</p>
                </div>
            </div>
        </div>

        <!-- Small Box 2 -->
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$period}}</h3>
                    <p>Window Size</p>
                </div>
            </div>
        </div>

        <!-- Small Box 3 -->
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-warning">
                <div class="inner">
                     @foreach($item->barang as $barang)
                            <h3>{{ $barang->name }}</h3>
                        @endforeach
                    <p>Jenis Barang</p>
                </div>
                
            </div>
        </div>

        <!-- Small Box 4 -->
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$prediksi}}</h3>
                    <p>Hasil Prediksi</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    @if(isset($prediksi))
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                        <canvas id="forecastChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-6">
            <!-- Display the forecast result if available -->
        @endif

        <!-- Display error metrics if available -->
        @if(isset($mae) || isset($mse))
            <div class="card">
                <div class="card-body">
                    <h4>Error Metrics</h4>
                    <p><strong>Mean Absolute Error (MAE):</strong> {{ $mae }}</p>
                    <p><strong>Mean Squared Error (MSE):</strong> {{ $mse }}</p>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
            <table id="example1" class="table table-bordered table-hover table-striped">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>id_barang</th>
                        <th>quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($historiprediksi as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                            <td>{{ $data->barang->name }}</td>
                        <td>{{$data->quantity}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
        </div>
        <!-- Error Message if there's not enough data -->
        @if(isset($error))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        </div>
</div>
@endsection
@section('script')
<script src="{{asset('AdminLTE')}}/plugins/chart.js/Chart.min.js"></script>
<script>
    // Get the data passed from the controller
    const actualData = @json($actualValues ?? []);
    const forecastedData = @json($forecastedValues ?? []);

    const ctx = document.getElementById('forecastChart').getContext('2d');
    const forecastChart = new Chart(ctx, {
        type: 'line',  // Change chart type to 'line'
        data: {
            labels: actualData.map((_, index) => `Period ${index + 1}`),  // Labels for each period
            datasets: [
                {
                    label: 'Actual Data',
                    data: actualData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Blue color with light transparency for area fill
                    borderColor: 'rgba(54, 162, 235, 1)',        // Line color
                    borderWidth: 2,
                    fill: true,  // Fill the area under the line
                    tension: 0.1 // Smooth the line slightly
                },
                {
                    label: 'Forecasted Data',
                    data: forecastedData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Red color with light transparency for area fill
                    borderColor: 'rgba(255, 99, 132, 1)',       // Line color
                    borderWidth: 2,
                    fill: true,  // Fill the area under the line
                    tension: 0.1 // Smooth the line slightly
                }
            ]
        },
        options: {
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            plugins: {
                legend: {
                    position: 'top',  // Position legend at the top
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });
    </script>
@endsection
