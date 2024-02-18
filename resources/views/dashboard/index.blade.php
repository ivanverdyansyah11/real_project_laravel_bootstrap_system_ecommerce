@extends('layouts.main')

@section('content-dashboard')
    <div class="row row-cols-4 me-5" style="margin-top: 32px;">
        <div class="col">
            <div class="dashboard-menu d-flex justify-content-between p-3">
                <div class="wrapper">
                    <div class="menu-title mb-2">Total Product</div>
                    <div class="menu-value">03</div>
                </div>
                <div class="menu-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/dashboard/product.png') }}" alt="Dashboard Icon" class="img-fluid" height="20" width="20">
                </div>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-menu d-flex justify-content-between p-3">
                <div class="wrapper">
                    <div class="menu-title mb-2">Total Package</div>
                    <div class="menu-value">03</div>
                </div>
                <div class="menu-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/dashboard/package.png') }}" alt="Dashboard Icon" class="img-fluid" height="20" width="20">
                </div>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-menu d-flex justify-content-between p-3">
                <div class="wrapper">
                    <div class="menu-title mb-2">Total Products Sold</div>
                    <div class="menu-value">03</div>
                </div>
                <div class="menu-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/dashboard/product-sold.png') }}" alt="Dashboard Icon" class="img-fluid" height="20" width="20">
                </div>
            </div>
        </div>
        <div class="col pe-0">
            <div class="dashboard-menu d-flex justify-content-between p-3">
                <div class="wrapper">
                    <div class="menu-title mb-2">Total Revenue</div>
                    <div class="menu-value">03</div>
                </div>
                <div class="menu-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/dashboard/revenue.png') }}" alt="Dashboard Icon" class="img-fluid" height="20" width="20">
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 me-5">
        <div class="col-12 pe-0">
            <div class="card-chart p-3">
                <canvas style="width: 100%; min-height: ;" id="myChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @push('js')
    <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
              label: '# of Votes',
              data: [12, 19, 3, 5, 2, 3],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      </script>
    @endpush
@endsection