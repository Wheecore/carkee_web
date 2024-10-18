@extends('backend.layouts.app')
@section('title', translate('Dashboard'))
@section('content')
<style>
.graph-loader {
  border: 10px solid #f3f3f3;
  border-radius: 50%;
  border-top: 10px solid #3498db;
  width: 80px;
  height: 80px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  position: absolute;
  left: 43%;
  background: white;
  display: none;
  top: 130px;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
    @php
        $user = Auth::user();
        $permissions = ($user->staff) ? $user->staff->role->permissions : '';
        $permissions = (array) json_decode($permissions);
    @endphp
    @if ($user->user_type == 'admin' || in_array(1, $permissions))
        <div class="row gutters-10">
            <div class="col-lg-6">
                <div class="row gutters-10">
                    <div class="col-6">
                        <div class="bg-grad-2 text-white rounded-lg mb-4 overflow-hidden">
                            <div class="px-3 pt-3">
                                <div class="fw-600">
                                    <span class="fs-12 d-block">{{ translate('Total') }}</span>
                                    {{ translate('Customer') }}
                                </div>
                                <div class="h1 fw-700 mb-3">{{ \App\Models\Customer::all()->count() }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="rgba(255,255,255,0.3)" fill-opacity="1"
                                    d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-grad-3 text-white rounded-lg mb-4 overflow-hidden">
                            <div class="px-3 pt-3">
                                <div class="fw-600">
                                    <span class="fs-12 d-block">{{ translate('Total') }}</span>
                                    {{ translate('Order') }}
                                </div>
                                <div class="h1 fw-700 mb-3">{{ \App\Models\Order::all()->count() }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="rgba(255,255,255,0.3)" fill-opacity="1"
                                    d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-grad-1 text-white rounded-lg mb-4 overflow-hidden">
                            <div class="px-3 pt-3">
                                <div class="fw-600">
                                    <span class="fs-12 d-block">{{ translate('Total') }}</span>
                                    {{ translate('Product Category') }}
                                </div>
                                <div class="h1 fw-700 mb-3">{{ count(get_all_categories()) }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="rgba(255,255,255,0.3)" fill-opacity="1"
                                    d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-grad-4 text-white rounded-lg mb-4 overflow-hidden">
                            <div class="px-3 pt-3">
                                <div class="fw-600">
                                    <span class="fs-12 d-block">{{ translate('Total') }}</span>
                                    {{ translate('Car brand') }}
                                </div>
                                <div class="h1 fw-700 mb-3">{{ \App\Models\Brand::all()->count() }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="rgba(255,255,255,0.3)" fill-opacity="1"
                                    d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="bg-grad-4 text-white rounded-lg mb-4 overflow-hidden">
                            <div class="px-3 pt-3">
                                <div class="fw-600">
                                    <span class="fs-12 d-block">{{ translate('Total Pending') }}</span>
                                    {{ translate('Availability Requests') }}
                                </div>
                                <div class="h1 fw-700 mb-3">
                                    {{ \App\Models\AvailabilityRequest::where('status', 'Pending')->count() }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="rgba(255,255,255,0.3)" fill-opacity="1"
                                    d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row gutters-10">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0 fs-14">{{ translate('Products') }}</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="pie-1" class="w-100" height="305"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="row gutters-10">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="col">
                            <h6 class="mb-0 fs-14">{{ translate('Sales') }}</h6>
                            </div>
                            <div class="col-lg-6 ml-auto">
                                @php
                                   $year = date("Y");
                                @endphp
                                <select class="form-control aiz-selectpicker" name="years" id="years">
                                    @for($i = $year; $i > $year-10; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="card-body graph-3-card">
                            <div class="graph-loader"></div>
                            <canvas id="graph-3" class="w-100" height="500"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="col">
                            <h6 class="mb-0 fs-14">{{ translate('Wallet Top-up') }}</h6>
                            </div>
                            <div class="col-lg-6 ml-auto">
                                <select class="form-control aiz-selectpicker" name="wallet_years" id="wallet_years">
                                    @for($i = $year; $i > $year-10; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="card-body graph-4-card">
                            <div class="graph-loader"></div>
                            <canvas id="graph-4" class="w-100" height="500"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters-10">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0 fs-14">{{ translate('Category wise product sale') }}</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="graph-1" class="w-100" height="500"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0 fs-14">{{ translate('Category wise product stock') }}</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="graph-2" class="w-100" height="500"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{ translate('Top 12 Products') }}</h6>
            </div>
            <div class="card-body">
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"
                    data-md-items="3" data-sm-items="2" data-arrows='true'>
                    @foreach ($top_products as $key => $product)
                        @php
                            $home_base_price = home_base_price($product);
                            $home_discounted_base_price = home_discounted_base_price($product);
                        @endphp
                        <div class="carousel-box">
                            <div class="aiz-card-box border border-light rounded shadow-sm hov-shadow-md mb-2 has-transition bg-white">
                                <div class="position-relative">
                                    {{-- <a href="{{ route('product', $product->slug) }}" class="d-block d-none"> --}}
                                    <img class="img-fit lazyload mx-auto h-210px" src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ my_asset($product->file_name) }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    {{-- </a> --}}
                                </div>
                                <div class="p-md-3 p-2 text-left">
                                    <div class="fs-15">
                                        @if ($home_base_price != $home_discounted_base_price)
                                            <del class="fw-600 opacity-50 mr-1">{{ $home_base_price }}</del>
                                        @endif
                                        <span class="fw-700 text-primary">{{ $home_discounted_base_price }}</span>
                                    </div>
                                    <div class="rating rating-sm mt-1">
                                        {{ renderStarRating($product->rating) }}
                                    </div>
                                    <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                                        {{-- <a href="{{ route('product', $product->slug) }}" class="d-block text-reset d-none"> --}}
                                        {{ $product->name }}
                                        {{-- </a> --}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endsection
@section('script')

    @if ($user->user_type == 'admin' || in_array(1, $permissions))
        <script type="text/javascript">
            AIZ.plugins.chart('#pie-1', {
                type: 'doughnut',
                data: {
                    labels: [
                        '{{ translate('Total published products') }}',
                        '{{ translate('Total admin products') }}'
                    ],
                    datasets: [{
                        data: [
                            {{ $products_count->published_products }},
                            {{ $products_count->admin_products }}
                        ],
                        backgroundColor: [
                            "#fd3995",
                            "#34bfa3",
                            "#5d78ff",
                            '#fdcb6e',
                            '#d35400',
                            '#8e44ad',
                            '#006442',
                            '#4D8FAC',
                            '#CA6924',
                            '#C91F37'
                        ]
                    }]
                },
                options: {
                    cutoutPercentage: 70,
                    legend: {
                        labels: {
                            fontFamily: 'Poppins',
                            boxWidth: 10,
                            usePointStyle: true
                        },
                        onClick: function() {
                            return '';
                        },
                        position: 'bottom'
                    }
                }
            });

            AIZ.plugins.chart('#graph-1', {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($categories as $category)
                            '{{ $category->name }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: '{{ translate('Number of sale') }}',
                        data: [
                            @foreach ($categories as $category)
                                {{ DB::table('products')->where('category_id', $category->id)->sum('num_of_sale') }},
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach ($categories as $category)
                                'rgba(55, 125, 255, 0.4)',
                            @endforeach
                        ],
                        borderColor: [
                            @foreach ($categories as $category)
                                'rgba(55, 125, 255, 1)',
                            @endforeach
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            gridLines: {
                                color: '#f2f3f8',
                                zeroLineColor: '#f2f3f8'
                            },
                            ticks: {
                                fontColor: "#8b8b8b",
                                fontFamily: 'Poppins',
                                fontSize: 10,
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: '#f2f3f8'
                            },
                            ticks: {
                                fontColor: "#8b8b8b",
                                fontFamily: 'Poppins',
                                fontSize: 10
                            }
                        }]
                    },
                    legend: {
                        labels: {
                            fontFamily: 'Poppins',
                            boxWidth: 10,
                            usePointStyle: true
                        },
                        onClick: function() {
                            return '';
                        },
                    }
                }
            });

            AIZ.plugins.chart('#graph-2', {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($categories as $category)
                            '{{ $category->name }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: '{{ translate('Number of Stock') }}',
                        data: [
                            @foreach ($categories as $key => $category)
                                {{ $product_stocks = DB::table('products')->where('category_id', $category->id)->sum('qty') }},
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach ($categories as $key => $category)
                                'rgba(253, 57, 149, 0.4)',
                            @endforeach
                        ],
                        borderColor: [
                            @foreach ($categories as $key => $category)
                                'rgba(253, 57, 149, 1)',
                            @endforeach
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            gridLines: {
                                color: '#f2f3f8',
                                zeroLineColor: '#f2f3f8'
                            },
                            ticks: {
                                fontColor: "#8b8b8b",
                                fontFamily: 'Poppins',
                                fontSize: 10,
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: '#f2f3f8'
                            },
                            ticks: {
                                fontColor: "#8b8b8b",
                                fontFamily: 'Poppins',
                                fontSize: 10
                            }
                        }]
                    },
                    legend: {
                        labels: {
                            fontFamily: 'Poppins',
                            boxWidth: 10,
                            usePointStyle: true
                        },
                        onClick: function() {
                            return '';
                        },
                    }
                }
            });
            
            let graph_3_chart = document.getElementById('graph-3').getContext('2d');
            var new_chart = new Chart(graph_3_chart, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($months as $month)
                           '{{ $month }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: '{{ translate('Total sale per month') }} (RM)',
                        data: [
                            @foreach ($months_in_numbers as $month)
                                '{{ DB::table('orders')->whereYear('created_at', date('Y'))->whereMonth('created_at', $month)->where('payment_status', 'paid')->sum('grand_total') }}',
                            @endforeach
                        ],
                        
                        backgroundColor: [
                            @foreach($months as $month)
                                '#C5519E',
                            @endforeach
                        ],
                        borderColor: [
                            @foreach($months as $month)
                                '#C5519E',
                            @endforeach
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            gridLines: {
                                color: '#f2f3f8',
                                zeroLineColor: '#f2f3f8'
                            },
                            ticks: {
                                // callback: function(value, index, values) {
                                //     return value + 'K';
                                // },
                                fontColor: "#8b8b8b",
                                fontFamily: 'Poppins',
                                fontSize: 10,
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: '#f2f3f8'
                            },
                            ticks: {
                                fontColor: "#8b8b8b",
                                fontFamily: 'Poppins',
                                fontSize: 10
                            }
                        }]
                    },
                    legend: {
                        labels: {
                            fontFamily: 'Poppins',
                            boxWidth: 10,
                            usePointStyle: true
                        },
                        onClick: function() {
                            return '';
                        },
                    }
                }
            });

            $("#years").change(function(){
                $(".graph-3-card .graph-loader").show();
                $("#graph-3").css("opacity", '0.5');
                var year = $(this).val();
                $.ajax({
                type: "GET",
                dataType: 'json',
                url: '{{ route('admin.show_year_sales_data') }}',
                data: { year: year }
                })
                .done(function( response ) {
                    new_chart.data.datasets[0].data = response;
                    new_chart.update();
                    $(".graph-3-card .graph-loader").hide();
                    $("#graph-3").css("opacity", '1');
                })
                .fail(function(error) {
                    $(".graph-3-card .graph-loader").hide();
                    $("#graph-3").css("opacity", '1');
                    alert("error occured");
                });
            });

            let graph_4_chart = document.getElementById('graph-4').getContext('2d');
            var new_wallet_chart = new Chart(graph_4_chart, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($months as $month)
                           '{{ $month }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: '{{ translate('Total top-up per month') }} (RM)',
                        data: [
                            @foreach ($months_in_numbers as $month)
                                '{{ DB::table('wallets')->whereYear('created_at', date('Y'))->whereMonth('created_at', $month)->where('type', 'add')->where('status', 1)->sum('amount') }}',
                            @endforeach
                        ],
                        
                        backgroundColor: [
                            @foreach($months as $month)
                                '#C5519E',
                            @endforeach
                        ],
                        borderColor: [
                            @foreach($months as $month)
                                '#C5519E',
                            @endforeach
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            gridLines: {
                                color: '#f2f3f8',
                                zeroLineColor: '#f2f3f8'
                            },
                            ticks: {
                                fontColor: "#8b8b8b",
                                fontFamily: 'Poppins',
                                fontSize: 10,
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: '#f2f3f8'
                            },
                            ticks: {
                                fontColor: "#8b8b8b",
                                fontFamily: 'Poppins',
                                fontSize: 10
                            }
                        }]
                    },
                    legend: {
                        labels: {
                            fontFamily: 'Poppins',
                            boxWidth: 10,
                            usePointStyle: true
                        },
                        onClick: function() {
                            return '';
                        },
                    }
                }
            });

            $("#wallet_years").change(function(){
                $(".graph-4-card .graph-loader").show();
                $("#graph-4").css("opacity", '0.5');
                var year = $(this).val();
                $.ajax({
                type: "GET",
                dataType: 'json',
                url: '{{ route('admin.show_year_wallet_data') }}',
                data: { year: year }
                })
                .done(function(response) {
                    new_wallet_chart.data.datasets[0].data = response;
                    new_wallet_chart.update();
                    $(".graph-4-card .graph-loader").hide();
                    $("#graph-4").css("opacity", '1');
                })
                .fail(function(error) {
                    $(".graph-4-card .graph-loader").hide();
                    $("#graph-4").css("opacity", '1');
                    alert("error occured");
                });
            });
            
        </script>
    @endif

@endsection
