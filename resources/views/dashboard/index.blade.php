@extends('layouts.main')

@section('content-dashboard')
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 me-lg-5" style="margin-top: 32px;">
        <div class="col">
            <div class="dashboard-menu d-flex justify-content-between p-3">
                <div class="wrapper">
                    <p class="menu-title mb-2">Total Product</p>
                    <p class="menu-value mb-0">03</p>
                </div>
                <div class="menu-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/dashboard/product.png') }}" alt="Dashboard Icon" class="img-fluid" height="20" width="20">
                </div>
            </div>
        </div>
        <div class="col mt-4 mt-md-0">
            <div class="dashboard-menu d-flex justify-content-between p-3">
                <div class="wrapper">
                    <p class="menu-title mb-2">Total Package</p>
                    <p class="menu-value mb-0">03</p>
                </div>
                <div class="menu-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/dashboard/package.png') }}" alt="Dashboard Icon" class="img-fluid" height="20" width="20">
                </div>
            </div>
        </div>
        <div class="col mt-4 mt-xl-0">
            <div class="dashboard-menu d-flex justify-content-between p-3">
                <div class="wrapper">
                    <p class="menu-title mb-2">Total Products Sold</p>
                    <p class="menu-value mb-0">03</p>
                </div>
                <div class="menu-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/dashboard/product-sold.png') }}" alt="Dashboard Icon" class="img-fluid" height="20" width="20">
                </div>
            </div>
        </div>
        <div class="col mt-4 mt-xl-0 pe-xl-0">
            <div class="dashboard-menu d-flex justify-content-between p-3">
                <div class="wrapper">
                    <p class="menu-title mb-2">Total Revenue</p>
                    <p class="menu-value mb-0">03</p>
                </div>
                <div class="menu-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/dashboard/revenue.png') }}" alt="Dashboard Icon" class="img-fluid" height="20" width="20">
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 me-lg-5">
        <div class="col-lg-8 pe-3">
            <div class="card-chart p-3 position-relative">
                <div class="wrapper d-flex align-items-center justify-content-between" style="margin: 4px 0 18px 0;">
                    <h5 class="chart-title">Graphic Revenue</h5>
                    <button type="button" class="button-small-default d-flex align-items-center" id="button_chart">
                        This Week
                        <img src="{{ asset('assets/images/icons/refresh.png') }}" alt="Arrow Down" class="img-fluid" width="13">
                    </button>
                </div>
                <canvas style="width: 100%; height: 330px !important;" id="chartBarWeek"></canvas>
                <canvas class="hide" style="width: 100%; height: 330px !important;" id="chartBarYear"></canvas>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0 pe-xl-0">
            <div class="card-chart p-3">
                <h5 class="chart-title" style="margin: 4px 0 18px 0;">Graphic Order Time</h5>
                <canvas style="width: 100%;" id="chartPie"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @push('js')
    <script>
        const buttonChart = document.querySelector('#button_chart');
        const elementChartBarWeek = document.querySelector('#chartBarWeek');
        const elementChartBarYear = document.querySelector('#chartBarYear');

        buttonChart.addEventListener('click', function() {
            elementChartBarWeek.classList.toggle('hide');
            elementChartBarYear.classList.toggle('hide');
        });

        Chart.defaults.font.size = 12;
        Chart.defaults.font.family = 'Arial';
        Chart.defaults.borderColor = 'rgba(0,0,0,0.12)';
        Chart.defaults.color = 'rgba(0,0,0,0.62)';

        const chartBarWeek = document.getElementById('chartBarWeek');
        new Chart(chartBarWeek, {
          type: 'bar',
          data: {
            labels: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            datasets: [{
              label: '# of Votes',
              data: [12, 19, 3, 5, 2, 3 ,6],
              backgroundColor: 'rgba(136, 184, 0, 0.24)',
              borderColor: 'rgba(136, 184, 0, 0.62)',
              borderWidth: 1,
              borderRadius: 8,
              borderSkipped: false,
              barPercentage: 0.6,
            }]
          },
          options: {
            plugins: {
                legend: {
                    display: false
            },
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 5,
                }
              }
            }
          }
        });

        const chartBarYear = document.getElementById('chartBarYear');
        new Chart(chartBarYear, {
          type: 'bar',
          data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', ,'Okt' ,'Nov', 'Des'],
            datasets: [{
              label: '# of Votes',
              data: [12, 19, 3, 5, 2, 3 , 6, 10, 8, 9, 4, 5, 7],
              backgroundColor: 'rgba(136, 184, 0, 0.24)',
              borderColor: 'rgba(136, 184, 0, 0.62)',
              borderWidth: 1,
              borderRadius: 8,
              borderSkipped: false,
              barPercentage: 1,
            }]
          },
          options: {
            plugins: {
                legend: {
                    display: false
                },
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 5,
                }
              }
            }
          }
        });

        const chartPie = document.getElementById('chartPie');
        new Chart(chartPie, {
            type: 'pie',
            data: {
                labels: ['Pagi', 'Siang', 'Sore', 'Malam'],
                datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5],
                borderWidth: 1
                }]
            },
            options: {
                plugins: {
                legend: {
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'rectRounded',
                    },
                    position: 'bottom',
                },
                },
            }
        });
      </script>
    @endpush
@endsection