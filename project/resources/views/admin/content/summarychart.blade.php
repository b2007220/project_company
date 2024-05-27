<div class="container-fluid bg-white border rounded">
    <div class="row my-3">
        <div class="col">
            <h4 class="p-3">Bảng thống kê doanh thu</h4>
        </div>
    </div>
    <div class="d-flex justify-content-center pb-4 gap-2 flex-column-max-lg">
        <div class="w-30 border rounded-top border-bottomlue-700 p-3 border-2 bg-white">
            <span>
                <h5 class="text-uppercase font-medium p-2">
                    Sản phẩm bán chạy
                </h5>
            </span>

            <div class="border rounded">
                <div id="pie-chart" class="p-3"></div>
            </div>
        </div>
        <div class="w-40 border rounded border-bottomlue-700 p-3 border-2 bg-white">
            <span>
                <h5 class="text-uppercase font-medium p-2">
                    Số đơn đặt hàng
                </h5>
            </span>
            <div class="border rounded">
                <div id="apexcharts-area" class="p-3"></div>
            </div>
        </div>
        <div class="w-30 border rounded-top border-bottomlue-700 p-3 border-2 bg-white">
            <span>
                <h5 class="text-uppercase font-medium p-2">
                    Doanh thu theo tháng
                </h5>
            </span>

            <div class="border rounded">
                <div id="column-chart" class="p-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var options = {
        chart: {
            height: "200px",
            type: "area",
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: "smooth",
        },
        series: [{
            name: "series1",
            data: [31, 40, 28, 51, 42, 109, 100],
        }, ],
        xaxis: {
            type: "datetime",
            categories: [
                "2018-09-19T00:00:00",
                "2018-09-19T01:30:00",
                "2018-09-19T02:30:00",
                "2018-09-19T03:30:00",
                "2018-09-19T04:30:00",
                "2018-09-19T05:30:00",
                "2018-09-19T06:30:00",
            ],
        },
        tooltip: {
            x: {
                format: "dd/MM/yy HH:mm",
            },
        },
    };
    var chart = new ApexCharts(
        document.querySelector("#apexcharts-area"),
        options
    );
    chart.render();

    var options2 = {
        chart: {
            height: "300px",
            width: "300px",
            type: "donut",
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val + "%";
            },
        },
        stroke: {
            curve: "smooth",
        },
        series: [40, 10, 5, 20, 25],
        labels: ["Apple", "Mango", "Orange", "Watermelon", "Banana"],
    };
    var pieChart = new ApexCharts(
        document.querySelector("#pie-chart"),
        options2
    );

    pieChart.render();
    var options3 = {
        chart: {
            height: "300px",
            type: "bar",
        },
        series: [{
            name: "sales",
            data: [30, 40, 45, 50, 49, 60, 70, 91, 125],
        }, ],
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
            ],
        },
    };
    var columnChart = new ApexCharts(
        document.querySelector("#column-chart"),
        options3
    );
    columnChart.render();
</script>
