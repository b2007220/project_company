<div class="container-fluid bg-white border rounded">
    <div class="row my-3">
        <div class="col">
            <h4 class="p-3">Bảng thống kê doanh thu</h4>
        </div>
    </div>
    <div class="d-flex justify-content-center pb-4 gap-2 flex-column-max-lg ">

        <div class=" border rounded border-blue-700 p-3 border-2 bg-white w-50">
            <span>
                <h5 class="text-uppercase font-medium p-2">
                    Doanh thu theo tháng
                </h5>
            </span>
            <div class="border rounded">
                <div id="apexcharts-area" class="p-3"></div>
            </div>
        </div>
        <div class="border rounded-top border-bottom border-blue-700 p-3 border-2 bg-white w-50">
            <span>
                <h5 class="text-uppercase font-medium p-2">
                    Số đơn đặt hàng theo tháng
                </h5>
            </span>

            <div class="border rounded">
                <div id="column-chart" class="p-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function getDaysInCurrentMonth() {
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        const daysArray = [];
        for (let day = 1; day <= daysInMonth; day++) {
            daysArray.push(day.toString());
        }

        return daysArray;
    }
    const daysInCurrentMonth = getDaysInCurrentMonth();
    const countOrderPerDay = @json($countOrderPerDay);
    const incomePerDay = @json($incomePerDay);
    console.log(incomePerDay);

    const ordersByDay = {};
    const incomeByDay = {};
    for (let i = 0; i < countOrderPerDay.length; i++) {
        const dateObj = new Date(countOrderPerDay[i].date);
        const day = dateObj.getDate();
        ordersByDay[day] = countOrderPerDay[i].count;
        incomeByDay[day] = incomePerDay[i].total;
    }

    const orderPerDay = daysInCurrentMonth.map(day => {
        return ordersByDay[day] || 0;
    });
    const incomePerDayArray = daysInCurrentMonth.map(day => {
        return incomeByDay[day] || 0;
    });

    var options = {
        chart: {
            height: "300px",
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
            data: incomePerDayArray,
        }, ],
        xaxis: {
            type: "date",
            categories: daysInCurrentMonth,
        },
        tooltip: {
            x: {
                format: "dd/MM/yy",
            },
        },
    };
    var chart = new ApexCharts(
        document.querySelector("#apexcharts-area"),
        options
    );
    chart.render();
    var options3 = {
        chart: {
            height: "300px",
            type: "bar",
        },

        series: [{
            name: "sales",
            data: orderPerDay,
        }, ],
        xaxis: {
            categories: daysInCurrentMonth,
        },

    };
    var columnChart = new ApexCharts(
        document.querySelector("#column-chart"),
        options3
    );
    columnChart.render();
</script>
