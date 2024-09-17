@extends('layouts.template')
@section('title', 'home')
@section('content')
<div class="container-fluid mt-5">
  <div class="row">
    <!-- Monthly Sales Card -->
    <div class="col-md-6">
      
      <div class="card">
        <div class="card-header">
          Monthly Sales
        </div>
        <div class="card-body">
          <canvas id="monthlySalesChart"></canvas>
        </div>
      </div>
      <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Forecasted Sales vs Actual Sales (Over Time)</h5>
                        <canvas id="salesVsForecastChart"></canvas>
                    </div>
                </div>
      
      <div class="card">
        <div class="cardn-header">
            <div class="card-body">
                <p>Total Inventory Stock</p>
                <h1>{{ number_format($totalStock) }}</h1>
            </div>
        </div>
      </div>
      
    </div>
                
    <!-- Inventory Forecasting Card -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          Inventory Forecasting
        </div>
        <div class="card-body">
          <canvas id="forecastChart"></canvas>
                        <!-- Statistik List -->
                        <h6 class="mt-4">Forecast Status by Product Category</h6>
                        <ul class="list-group">
                            @foreach($forecastData as $data)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @if($data->barang && $data->barang->kategori)
                                        {{ $data->barang->kategori->name }}
                                    @else
                                        No category or product found
                                    @endif
                                    @if ($data->barang->quantity >= $data->forecast_value)
                                        <span class="badge bg-success">On Track</span>
                                    @elseif ($data->barang->quantity < $data->forecast_value)
                                        <span class="badge bg-danger">Below Expectations</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Above Expectations</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
        </div>
      </div>
      
    </div>
    
  </div>
</div>
@endsection
@section('script')
<!-- ChartJS -->
<script src="{{asset('AdminLTE')}}/plugins/chart.js/Chart.min.js"></script>
<!-- Chart.js Script for Monthly Sales and Inventory Forecasting Charts -->
<script>
 
   // Data from Laravel passed via Blade
        const months = @json($months ?? []);
        const actualSalesData = @json($actualSales ?? []);
        const forecastedSalesData = @json($forecastedSalesData ?? []);

        // Setup for the Forecast Breakdown chart
        const forecastData = {
            labels: @json($forecastData->pluck('barang.name')),
            datasets: [{
                label: 'Forecasted Sales ($)',
                data: @json($forecastData->pluck('forecast_value')),
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        const ctx3 = document.getElementById('forecastChart').getContext('2d');
        const forecastChart = new Chart(ctx3, {
            type: 'bar',
            data: forecastData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Setup for the Forecasted vs Actual Sales chart
        const ctx2 = document.getElementById('salesVsForecastChart').getContext('2d');
        const salesVsForecastChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Actual Sales ($)',
                        data: actualSalesData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Forecasted Sales ($)',
                        data: forecastedSalesData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

         // Monthly Sales Chart
  const ctx1 = document.getElementById('monthlySalesChart').getContext('2d');
  const monthlySalesChart = new Chart(ctx1, {
    type: 'line',
    data: {
      labels: months,
      datasets: [{
        label: 'Sales',
        data: actualSalesData,
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

</script>
@endsection