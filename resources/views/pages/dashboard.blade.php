<x-layout>


    <div class="box_model">
        <div class="dsh_row row">
            <div class="left_chart">
                <div class="dash_body">

                    <div class="chart-title__heading">
                        <div id="chart1" class="chart chart1">
                        </div>
                        <h3 class="chart-title">{{ __('sentence.my_sales') }}</h3>
                    </div>
                </div>
            </div>
            <div class="rt_box">
                <div class="vr_grid_box">
                    <div class="vr_item grn">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>{{ __('sentence.today_total_orders') }}</h3>
                        <label>{{ $todaysSale }} €.</label>
                    </div>
                    <div class="vr_item grn">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>{{ __('sentence.todays_sale') }}</h3>
                        <label>{{ $orders }} €.</label>
                    </div>
                    <div class="vr_item grn">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>{{ __('sentence.last_7_days_sale') }}</h3>
                        <label>{{ $sevensSale }} €.</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            $.ajax({
                url: "/get-chart-data",
                type: "GET",
                success: function(response) {
                    let revenue = response.data.map((item) => item.total_profit);
                    let dates = response.data.map((item) => item.date);
                    new ApexCharts(document.getElementById("chart0"), {
                        series: [{
                            name: "Revenue",
                            data: revenue,
                        }, ],
                        chart: {
                            type: "area",
                            height: 225,
                            redrawOnParentResize: true,
                            redrawOnWindowResize: true,
                            toolbar: {
                                show: false,
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        stroke: {
                            curve: "smooth",
                            width: 3,
                            fill: "#00E396",
                        },
                        xaxis: {
                            type: "category",
                            categories: dates,
                            labels: {
                                show: true,
                                rotate: 0,
                                style: {
                                    colors: "#000000",
                                    fontSize: "12px",
                                    fontFamily: "Cabin, sans-serif",
                                    fontWeight: 600,
                                },
                            },
                        },
                        yaxis: {
                            tickAmount: 5,
                            labels: {
                                show: true,
                                style: {
                                    colors: "#000000",
                                    fontSize: "12px",
                                    fontFamily: "Cabin, sans-serif",
                                    fontWeight: 600,
                                },
                            },
                        },
                        tooltip: {
                            x: {
                                format: "MMMM",
                            },
                            y: {
                                formatter: function(val) {
                                    return val.toFixed(2) + " Tk";
                                },
                            },
                        },
                        fill: {
                            opacity: 1,
                            colors: ["#00E396", "#fff"],
                            gradient: {
                                shade: "light",
                                type: "vertical",
                                shadeIntensity: 0.5,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: 0.7,
                                opacityTo: 0.2,
                            },
                        },
                        responsive: [{
                            breakpoint: 1600,
                            options: {},
                        }, ],
                    }).render();
                },
                error: function(error) {
                    console.log(error);
                },
            });

            $.ajax({
                
                url: "/get-chart-data-month",
                type: "GET",
                success: function(response) {
                    
                    new ApexCharts(document.getElementById("chart1"), {
                        series: [{
                                name: "Sale",
                                data: response.data.sales,
                            },
                            {
                                name: "Earning",
                                data: response.data.profit,
                            }
                        ],
                        chart: {
                            type: "bar",
                            height: 400,
                            redrawOnParentResize: true,
                            redrawOnWindowResize: true,
                            toolbar: {
                                show: true,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "55%",
                                endingShape: "rounded",
                                borderRadius: 12,
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        stroke: {
                            show: false,
                        },
                        grid: {
                            show: false,
                        },
                        xaxis: {
                            categories: [
                                "{{ __('sentence.january') }}",
                                "{{ __('sentence.february') }}",
                                "{{ __('sentence.march') }}",
                                "{{ __('sentence.april') }}",
                                "{{ __('sentence.may') }}",
                                "{{ __('sentence.june') }}",
                                "{{ __('sentence.july') }}",
                                "{{ __('sentence.august') }}",
                                "{{ __('sentence.september') }}",
                                "{{ __('sentence.october') }}",
                                "{{ __('sentence.november') }}",
                                "{{ __('sentence.december') }}",
                            ],
                            tickAmount: 12,
                            labels: {
                                show: true,
                                rotate: 0,
                                trim: true,
                                style: {
                                    colors: "#000000",
                                    fontSize: "12px",
                                    fontFamily: "Cabin, sans-serif",
                                    fontWeight: 600,
                                },
                            },
                            axisBorder: {
                                show: false,
                                color: "#456456",
                                height: 1,
                                width: "100%",
                                offsetX: 0,
                                offsetY: 0,
                            },
                        },
                        yaxis: {
                            tickAmount: 8,
                            title: {
                                text: "Per Month",
                                style: {
                                    color: "#525050",
                                    fontSize: "20px",
                                    fontFamily: "Cabin, sans-serif",
                                    fontWeight: 600,
                                },
                            },
                            labels: {
                                show: true,
                                style: {
                                    colors: "#000000",
                                    fontSize: "12px",
                                    fontFamily: "Cabin, sans-serif",
                                    fontWeight: 600,
                                },
                            },
                        },
                        fill: {
                            opacity: 1,
                            colors: ["#008FFB", "#90C1E7", "#D1E3F1"],
                        },
                        stroke: {
                            width: 3,
                            colors: ["#008FFB", "#90C1E7", "#D1E3F1"],
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " Tk.";
                                },
                            },
                        },
                        legend: {
                            fontSize: "14px",
                            fontFamily: "Cabin, sans-serif",
                            fontWeight: 600,
                            labels: {
                                colors: "#525050",
                            },
                            markers: {
                                fillColors: ["#008FFB", "#90C1E7", "#D1E3F1"],
                                radius: 12,
                            },
                            itemMargin: {
                                horizontal: 30,
                                vertical: 0,
                            },
                        },

                        responsive: [{
                            breakpoint: 1600,
                            options: {
                                chart: {
                                    height: 200,
                                },
                                yaxis: {
                                    title: {
                                        style: {
                                            fontSize: '16px',
                                        },
                                    },
                                },
                                legend: {
                                    fontSize: '12px',
                                    itemMargin: {
                                        horizontal: 15,
                                    },
                                },
                            },
                        }]
                    }).render();
                },
                error: function(error) {
                    console.log(error);
                },
            });
        </script>
    @endpush
</x-layout>
