@extends('layouts.main')

@section('content-dashboard')
    <div class="row {{ auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin' ? 'row-cols-1 row-cols-md-2 row-cols-xl-4' : 'row-cols-1 row-cols-md-2' }} me-lg-5"
        style="margin-top: 32px;">
        @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
            <div class="col">
                <div class="dashboard-menu d-flex justify-content-between p-3">
                    <div class="wrapper">
                        <p class="menu-title mb-2">Total Produk</p>
                        <p class="menu-value mb-0">{{ $total_product }}</p>
                    </div>
                    <div class="menu-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/dashboard/product.png') }}" alt="Dashboard Icon" class="img-fluid"
                            height="20" width="20">
                    </div>
                </div>
            </div>
            <div class="col mt-4 mt-md-0">
                <div class="dashboard-menu d-flex justify-content-between p-3">
                    <div class="wrapper">
                        <p class="menu-title mb-2">Total Paket</p>
                        <p class="menu-value mb-0">{{ $total_package }}</p>
                    </div>
                    <div class="menu-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/dashboard/package.png') }}" alt="Dashboard Icon" class="img-fluid"
                            height="20" width="20">
                    </div>
                </div>
            </div>
            <div class="col mt-4 mt-xl-0">
                <div class="dashboard-menu d-flex justify-content-between p-3">
                    <div class="wrapper">
                        <p class="menu-title mb-2">Total Produk Dijual</p>
                        <p class="menu-value mb-0">{{ $total_product_sold }}</p>
                    </div>
                    <div class="menu-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/dashboard/product-sold.png') }}" alt="Dashboard Icon"
                            class="img-fluid" height="20" width="20">
                    </div>
                </div>
            </div>
            <div class="col mt-4 mt-xl-0 pe-xl-0">
                <div class="dashboard-menu d-flex justify-content-between p-3">
                    <div class="wrapper">
                        <p class="menu-title mb-2">Total Pendapatan</p>
                        <p class="menu-value mb-0">Rp. {{ number_format($total_revenue, 2, ',', '.') }}</p>
                    </div>
                    <div class="menu-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/dashboard/revenue.png') }}" alt="Dashboard Icon" class="img-fluid"
                            height="20" width="20">
                    </div>
                </div>
            </div>
        @else
            <div class="col">
                <div class="dashboard-menu d-flex justify-content-between p-3">
                    <div class="wrapper">
                        <p class="menu-title mb-2">Total Poin</p>
                        <p class="menu-value mb-0">{{ $total_poin }}</p>
                    </div>
                    <div class="menu-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/dashboard/product.png') }}" alt="Dashboard Icon"
                            class="img-fluid" height="20" width="20">
                    </div>
                </div>
            </div>
            <div class="col mt-4 mt-md-0">
                <div class="dashboard-menu d-flex justify-content-between p-3">
                    <div class="wrapper">
                        <p class="menu-title mb-2">Total Transaksi</p>
                        <p class="menu-value mb-0">{{ $total_transaction }}</p>
                    </div>
                    <div class="menu-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/dashboard/package.png') }}" alt="Dashboard Icon"
                            class="img-fluid" height="20" width="20">
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row mt-4 me-lg-5">
        <div
            class="order-1 {{ auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin' ? 'col-lg-8 pe-3' : 'col-md-6' }}">
            <div class="card-chart p-3 position-relative">
                <div class="wrapper d-flex align-items-center justify-content-between" style="margin: 4px 0 18px 0;">
                    <h5 class="chart-title">Grafik pembelian</h5>
                    <button type="button" class="button-small-default d-flex align-items-center" id="button_chart">
                        <span>Minggu Ini</span>
                        <img src="{{ asset('assets/images/icons/refresh.png') }}" alt="Arrow Down" class="img-fluid"
                            width="13">
                    </button>
                </div>
                <canvas style="width: 100%; height: 240px !important;" id="chartBarWeek"></canvas>
                <canvas class="hide" style="width: 100%; height: 240px !important;" id="chartBarYear"></canvas>
            </div>
        </div>
        <div
            class="{{ auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin' ? 'col-lg-4 pe-xl-0 order-2' : 'col-md-3 order-3' }}">
            <div class="card-chart p-3">
                <h5 class="chart-title" style="margin: 4px 0 18px 0;">Grafik Pesanan Hari Ini</h5>
                <canvas style="width: 100%;" id="chartPie"></canvas>
            </div>
        </div>
        @if (auth()->user()->role == 'reseller')
            <div class="col-md-3 order-4">
                <div class="card-chart p-3">
                    <h5 class="chart-title" style="margin: 4px 0 18px 0;">Akumulasi Pembelian Produk</h5>
                    <canvas style="width: 100%;" id="chartPieAcumulation"></canvas>
                </div>
            </div>
        @endif
    </div>

    @foreach ($graphic_week as $day => $graphic)
        <div class="data-hide graphic-{{ strtolower($day) }}">{{ count($graphic) }}</div>
    @endforeach

    @foreach ($graphic_month as $month => $graphic)
        <div class="data-hide graphic-{{ strtolower($month) }}">{{ count($graphic) }}</div>
    @endforeach

    @foreach ($graphic_day as $time => $graphic)
        <div class="data-hide graphic-{{ strtolower($time) }}">{{ count($graphic) }}</div>
    @endforeach

    @if (auth()->user()->role == 'reseller')
        <div class="product-name d-none">
            @foreach ($total_acumulation as $total){{ $total->name . ',' }}@endforeach
        </div>
        <div class="product-quantity d-none">
            @foreach ($total_acumulation as $total){{ $total->total_quantity . ',' }}@endforeach
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @push('js')
        <script>
            const buttonChart = document.querySelector('#button_chart');
            const buttonChartSpan = document.querySelector('#button_chart span');
            const elementChartBarWeek = document.querySelector('#chartBarWeek');
            const elementChartBarYear = document.querySelector('#chartBarYear');

            const graphicMorning = document.querySelector('.graphic-morning').innerHTML;
            const graphicAfternoon = document.querySelector('.graphic-afternoon').innerHTML;
            const graphicEvening = document.querySelector('.graphic-evening').innerHTML;
            const graphicNight = document.querySelector('.graphic-night').innerHTML;

            const graphicMonday = document.querySelector('.graphic-monday').innerHTML;
            const graphicTuesday = document.querySelector('.graphic-tuesday').innerHTML;
            const graphicWednesday = document.querySelector('.graphic-wednesday').innerHTML;
            const graphicThursday = document.querySelector('.graphic-thursday').innerHTML;
            const graphicFriday = document.querySelector('.graphic-friday').innerHTML;
            const graphicSaturday = document.querySelector('.graphic-saturday').innerHTML;
            const graphicSunday = document.querySelector('.graphic-sunday').innerHTML;

            const graphicJanuary = document.querySelector('.graphic-january').innerHTML;
            const graphicFebruary = document.querySelector('.graphic-february').innerHTML;
            const graphicMarch = document.querySelector('.graphic-march').innerHTML;
            const graphicApril = document.querySelector('.graphic-april').innerHTML;
            const graphicMay = document.querySelector('.graphic-may').innerHTML;
            const graphicJune = document.querySelector('.graphic-june').innerHTML;
            const graphicJuly = document.querySelector('.graphic-july').innerHTML;
            const graphicAugust = document.querySelector('.graphic-august').innerHTML;
            const graphicSeptember = document.querySelector('.graphic-september').innerHTML;
            const graphicOctober = document.querySelector('.graphic-october').innerHTML;
            const graphicNovember = document.querySelector('.graphic-november').innerHTML;
            const graphicDecember = document.querySelector('.graphic-december').innerHTML;

            buttonChart.addEventListener('click', function() {
                if (buttonChartSpan.innerHTML == 'Minggu Ini') {
                    buttonChartSpan.innerHTML = 'Tahun Ini';
                } else {
                    buttonChartSpan.innerHTML = 'Minggu Ini';
                }
                elementChartBarWeek.classList.toggle('hide');
                elementChartBarYear.classList.toggle('hide');
            });

            Chart.defaults.font.size = 12;
            Chart.defaults.font.family = 'Arial';
            Chart.defaults.borderColor = 'rgba(0,0,0,0.12)';
            Chart.defaults.color = 'rgba(0,0,0,0.62)';

            const chartPie = document.getElementById('chartPie');
            new Chart(chartPie, {
                type: 'pie',
                data: {
                    labels: ['Pagi', 'Siang', 'Sore', 'Malam'],
                    datasets: [{
                        label: 'Transaksi Diwaktu Ini',
                        data: [graphicMorning, graphicAfternoon, graphicEvening, graphicNight],
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

            const chartBarWeek = document.getElementById('chartBarWeek');
            new Chart(chartBarWeek, {
                type: 'bar',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Transaksi Dihari Ini',
                        data: [graphicMonday, graphicTuesday, graphicWednesday, graphicThursday, graphicFriday,
                            graphicSaturday, graphicSunday
                        ],
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
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', , 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Transaksi Dibulan Ini',
                        data: [graphicJanuary, graphicFebruary, graphicMarch, graphicApril, graphicMay,
                            graphicJune, graphicJuly, graphicAugust, graphicSeptember, graphicOctober,
                            graphicNovember, graphicDecember
                        ],
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

            const productName = document.querySelector('.product-name');
            const productQuantity = document.querySelector('.product-quantity');
            let productNameArray = productName.innerHTML.trim()
            let productQuantityArray = productQuantity.innerHTML.trim()
            productNameArray = productNameArray.split(',')
            productQuantityArray = productQuantityArray.split(',')
            productNameArray = productNameArray.filter(product => product)
            productQuantityArray = productQuantityArray.filter(product => product)

            const chartPieAcumulation = document.getElementById('chartPieAcumulation');
            new Chart(chartPieAcumulation, {
                type: 'pie',
                data: {
                    labels: productNameArray,
                    datasets: [{
                        label: 'Transaksi Diwaktu Ini',
                        data: productQuantityArray,
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
