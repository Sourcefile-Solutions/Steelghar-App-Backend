@extends('console.layouts.app')
@section('title', 'Home')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">


        <div id="kt_app_content" class="app-content flex-column-fluid">

            <div id="kt_app_content_container" class="app-container container-fluid">

                <div class="row g-5 g-xl-10 mt-1">
                    <div class="col-md-6 mb-md-5 ">
                        <div class="row g-5 g-xl-10">
                            <div class="col-md-6 col-xl-6 mb-xxl-10">
                                <div class="card overflow-hidden  mb-5 " style="background: cadetblue;">
                                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                        <div class="mb-4 px-9">
                                            <div class="d-flex align-items-center mb-2">

                                                <span class="fs-1 fw-bold text-white me-2 lh-1" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $todaySale }}" data-kt-countup-prefix="₹"
                                                    data-kt-countup-suffix=".00">{{ $todaySale }}</span>
                                            </div>
                                            <span class="fs-6 fw-semibold text-white">Today's Sales</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card overflow-hidden  mb-5" style="background: darkslateblue;">
                                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                        <div class="mb-4 px-9">
                                            <div class="d-flex align-items-center mb-2">

                                                <span class="fs-1 fw-bold text-white me-2 lh-1" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $thisMonthSale }}" data-kt-countup-prefix="₹"
                                                    data-kt-countup-suffix=".00">{{ $thisMonthSale }}</span>
                                            </div>
                                            <span class="fs-6 fw-semibold text-white">{{ now()->format('F') }}'s
                                                Sales</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card overflow-hidden  mb-5 " style="background: darkkhaki">
                                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                        <div class="mb-4 px-9">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="fs-1 fw-bold text-white me-2 lh-1" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $totalCustomers }}">{{ $totalCustomers }}</span>
                                            </div>
                                            <span class="fs-6 fw-semibold text-white">Total Customers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6 mb-xxl-10">
                                <div class="card overflow-hidden  mb-5 " style="background: burlywood;">
                                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                        <div class="mb-4 px-9">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="fs-1 fw-bold text-white me-2 lh-1" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $todayOrder }}">{{ $todayOrder }}</span>
                                            </div>
                                            <span class="fs-6 fw-semibold text-white">Today's Orders</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card overflow-hidden  mb-5 " style="background: salmon;">
                                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                        <div class="mb-4 px-9">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="fs-1 fw-bold text-white me-2 lh-1" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $thisMonthOrder }}">{{ $thisMonthOrder }}</span>
                                            </div>
                                            <span class="fs-6 fw-semibold text-white">{{ now()->format('F') }}'s
                                                Orders</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card overflow-hidden  mb-5 " style="background: orchid;">
                                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                        <div class="mb-4 px-9">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="fs-1 fw-bold text-white me-2 lh-1" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $totalFabricators }}">{{ $totalFabricators }}</span>

                                            </div>
                                            <span class="fs-6 fw-semibold text-white">Total Fabricators</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 mb-5">
                        <div class="card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <!--begin::Header-->
                                <div class="px-9 pt-7 card-rounded h-225px w-100 bg-dark">
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-3">All Time Data</h3>
                                    </div>
                                    <div class="d-flex text-center flex-column text-white">
                                        <span class="fw-semibold fs-7">Total Sales</span>
                                        <span class="fw-bold fs-2x pt-1" data-kt-countup="true"
                                            data-kt-countup-value="{{ $totalSale }}" data-kt-countup-prefix="₹"
                                            data-kt-countup-suffix=".00">{{ $totalSale }}</span>
                                    </div>
                                </div>

                                <!--begin::Items-->
                                <div class="bg-light-info shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1 animation animation-slide-in-down"
                                    style="margin-top: -100px">
                                    <div class="d-flex align-items-center mb-6">
                                        <div class="symbol symbol-25px w-25px me-5">
                                            <span class="symbol-label bg-lighten">
                                                <i class="bi bi-trophy-fill text-dark fs-3"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap w-100">
                                            <div class="mb-1 pe-3 flex-grow-1 ">
                                                <span class="fs-5 text-gray-800  fw-bold">Total Orders</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="fw-bold fs-5 text-gray-800 pe-1" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $totalOrder }}">{{ $totalOrder }}</div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-6">
                                        <div class="symbol symbol-25px w-25px me-5">
                                            <span class="symbol-label bg-lighten">
                                                <i class="bi bi-stars text-dark fs-3"></i>
                                            </span>
                                        </div>

                                        <div class="d-flex align-items-center flex-wrap w-100">
                                            <div class="mb-1 pe-3 flex-grow-1">
                                                <span class="fs-5 text-gray-800 text-hover-primary fw-bold">Total
                                                    Products</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="fw-bold fs-5 text-gray-800 pe-1" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $products }}">{{ $products }}</div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ">
                                        <div class="symbol symbol-25px w-25px me-5">
                                            <span class="symbol-label bg-lighten">
                                                <i class="bi bi-c-square-fill text-dark fs-3"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap w-100">
                                            <div class="mb-1 pe-3 flex-grow-1">
                                                <span class="fs-5 text-gray-800 text-hover-primary fw-bold">Total
                                                    Brands</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="fw-bold fs-5 text-gray-800 pe-1" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $brands }}">{{ $brands }}</div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card card-flush overflow-hidden h-xl-100 animation animation-slide-in-up">
                    <div class="card-header pt-7 mb-2">
                        <h3 class="card-title text-gray-800 fw-bold">Last 12 Month Sales</h3>
                    </div>
                    <div class="card-body d-flex justify-content-between flex-column pt-0 pb-1 px-0">
                        <div class="px-9 mb-5">
                            <div class="d-flex align-items-center mb-2">
                                <span class="fs-4 fw-semibold text-gray-500 align-self-start me-1">₹</span>
                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2" id="cTotal"></span>

                            </div>
                        </div>
                        <div id="salesChart" class="min-h-auto ps-4 pe-6" data-kt-chart-info="Transactions"
                            style="height: 300px"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        "use strict";
        const chartAmount = @json($chartAmount);
        const chartMonth = @json($chartMonth);
        var ChartWidget = function() {
            var chart = {
                self: null,
                rendered: false
            };
            var initChart = function() {
                var element = document.getElementById("salesChart");
                if (!element) {
                    return;
                }
                var height = parseInt(KTUtil.css(element, 'height'));
                var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
                var borderColor = KTUtil.getCssVariableValue('--kt-border-dashed-color');
                var baseColor = KTUtil.getCssVariableValue('--kt-primary');
                var lightColor = KTUtil.getCssVariableValue('--kt-primary');
                var chartInfo = element.getAttribute('data-kt-chart-info');
                var options = {
                    series: [{
                        name: chartInfo,
                        data: chartAmount
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'area',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {

                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0,
                            stops: [0, 80, 100]
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [baseColor]
                    },
                    xaxis: {
                        categories: chartMonth,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        tickAmount: 12,
                        labels: {
                            rotate: 0,
                            rotateAlways: true,
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        },
                        crosshairs: {
                            position: 'front',
                            stroke: {
                                color: baseColor,
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        max: 500000,
                        min: Math.min(...chartAmount),
                        tickAmount: 10,
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            },
                            formatter: function(val) {
                                return '₹' + val.toFixed(0)
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return '₹' + val
                            }
                        }
                    },
                    colors: [lightColor],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    markers: {
                        strokeColor: baseColor,
                        strokeWidth: 3
                    }
                };
                chart.self = new ApexCharts(element, options);
                setTimeout(function() {
                    chart.self.render();
                    chart.rendered = true;
                }, 200);
            }
            return {
                init: function() {
                    initChart();
                    KTThemeMode.on("kt.thememode.change", function() {
                        if (chart.rendered) {
                            chart.self.destroy();
                        }

                        initChart();
                    });
                }
            }
        }();
        if (typeof module !== 'undefined') {
            module.exports = ChartWidget;
        }
        KTUtil.onDOMContentLoaded(function() {
            ChartWidget.init();
        });
        document.getElementById('cTotal').innerHTML = chartAmount.reduce((partialSum, a) => partialSum + a, 0) + '.00'
    </script>

@endsection
