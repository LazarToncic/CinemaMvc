<div class="card">
    <div class="card-header pb-0 text-left">
        <div class="row">
            <div class="col-md-6">
                <h3 class="font-weight-bolder text-info text-gradient">Reports</h3>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control price-range-helper" id="price-from" placeholder="Cena od">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control price-range-helper" id="price-to" placeholder="Cena do">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control date-range-helper" id="date-from" placeholder="yyyy-mm-dd">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control date-range-helper" id="date-to" placeholder="yyyy-mm-dd">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
            <div class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand">
                    <div class=""></div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                    <div class=""></div>
                </div>
            </div>
            <div id="order-panel">
                <canvas id="orders" style="min-height: 350px; height: 350px;
                max-height: 550px; max-width: 100%; display: block; width: 634px;"
                        width="634" height="250" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header pb-0 text-left">
        <div class="row">
            <div class="col-md-6">
                <h3 class="font-weight-bolder text-info text-gradient">Top 10 users</h3>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control top10-range-helper" id="top10-from" placeholder="Potrosnja od">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control top10-range-helper" id="top10-to" placeholder="Potrosnja do">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
            <div class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand">
                    <div class=""></div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                    <div class=""></div>
                </div>
            </div>
            <div id="order-panel-top10">
                <canvas id="orders-top10" style="min-height: 350px; height: 350px;
                max-height: 550px; max-width: 100%; display: block; width: 634px;"
                        width="634" height="250" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header pb-0 text-left">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="font-weight-bolder text-info text-gradient">Most watched movies</h3>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control movieTopQuantity-range-helper" id="movieTopQuantity-from" placeholder="Kolicina od">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control movieTopQuantity-range-helper" id="movieTopQuantity-to" placeholder="Kolicina do">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="chart">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <div id="order-panel-movieTopQuantity">
                    <canvas id="orders-movieTopQuantity" style="min-height: 350px; height: 350px;
                max-height: 550px; max-width: 100%; display: block; width: 634px;"
                            width="634" height="250" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>



</div>

<script>
    $(document).ready(function() {
        orders();
        ordersTop10();
        ordersTopMovie();

        $(".price-range-helper").change(function() {
            $("#order-panel").empty();

            $("#order-panel").append('<canvas id="orders" style="min-height: 350px; height: 350px;' +
                'max-height: 550px; max-width: 100%; display: block; width: 634px;"' +
                'width="634" height="250" class="chartjs-render-monitor"></canvas>');
            orders();
        });

        $(".date-range-helper").change(function() {
            $("#order-panel").empty();

            $("#order-panel").append('<canvas id="orders" style="min-height: 350px; height: 350px;' +
                'max-height: 550px; max-width: 100%; display: block; width: 634px;"' +
                'width="634" height="250" class="chartjs-render-monitor"></canvas>');
            orders();
        });

        $(".top10-range-helper").change(function() {
            $("#order-panel-top10").empty();

            $("#order-panel-top10").append('<canvas id="orders-top10" style="min-height: 350px; height: 350px;' +
                'max-height: 550px; max-width: 100%; display: block; width: 634px;"' +
                'width="634" height="250" class="chartjs-render-monitor"></canvas>');
            ordersTop10();
        });

        $(".movieTopQuantity-range-helper").change(function() {
            $("#order-panel-movieTopQuantity").empty();

            $("#order-panel-movieTopQuantity").append('<canvas id="orders-movieTopQuantity" style="min-height: 350px; height: 350px;' +
                'max-height: 550px; max-width: 100%; display: block; width: 634px;"' +
                'width="634" height="250" class="chartjs-render-monitor"></canvas>');
            ordersTopMovie();
        });
    });

    function orders() {
        var url = '/api/orders';
        var data = {"priceFrom": $("#price-from").val(), "priceTo": $("#price-to").val(), "dateFrom": $("#date-from").val(), "dateTo": $("#date-to").val()};

        $.getJSON(url, data, function (result) {
            var labels = result.map(function(e) {
                return e.data_created;
            });

            var dataValues = result.map(function(e) {
                return e.total_price;
            });

            var graph = $("#orders").get(0).getContext('2d');

            createGraph(dataValues, labels, graph, "Ukupna zarada", "Izvestaj o narudzbenicama", "line", 13000);
        });
    }

    function ordersTop10() {
        var url = '/api/orders/top10';
        var data = {"top10From": $("#top10-from").val(), "top10To": $("#top10-to").val()};

        $.getJSON(url, data, function (result) {
            var labels = result.map(function(e) {
                return e.email;
            });

            var dataValues = result.map(function(e) {
                return e.total_price;
            });

            var graph = $("#orders-top10").get(0).getContext('2d');

            createGraphBar(dataValues, labels, graph, "TOP10", "Izvestaj o najvernijim clanovima", "bar", 13000);
        });
    }

    function ordersTopMovie() {
        var url = '/api/orders/movieTopQuantity';
        var data = {"movieTopQuantityFrom": $("#movieTopQuantity-from").val(), "movieTopQuantityTo": $("#movieTopQuantity-to").val()};

        $.getJSON(url, data, function (result) {
            var labels = result.map(function(e) {
                return e.name;
            });

            var dataValues = result.map(function(e) {
                return e.quantity;
            });

            var graph = $("#orders-movieTopQuantity").get(0).getContext('2d');

            createGraphPie(dataValues, labels, graph, "Rezervacije", "Izvestaj o rezervacijama", "pie");
        });
    }

    function createGraph(dataValues, labels, graph, dataSetLabel, reportLabel, type, max) {
        new Chart(graph, {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    label: dataSetLabel,
                    backgroundColor: 'rgb(173, 5, 5)',
                    borderColor: 'rgb(173, 5, 5)',
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: reportLabel
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            max: max,
                            min: 0,
                        }
                    }]
                },
                legend: {
                    display: true
                }
            }
        });
    }

    function createGraphBar(dataValues, labels, graph, dataSetLabel, reportLabel, type, max) {
        new Chart(graph, {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    label: dataSetLabel,
                    backgroundColor: [
                        'rgb(173, 5, 5)',
                        'rgb(54, 162, 235)',
                        'rgb(100, 59, 100)',
                        'rgb(50, 150, 20)',
                        'rgb(200, 59, 120)',
                        'rgb(230, 200, 120)',
                        'rgb(0, 59, 120)',
                        'rgb(100, 59, 0)',
                        'rgb(120, 200, 200)',
                        'rgb(0, 25, 0)',
                        'rgb(255, 100, 100)'
                    ],
                    borderColor: [
                        'rgb(173, 5, 5)',
                        'rgb(54, 162, 235)',
                        'rgb(100, 59, 100)',
                        'rgb(50, 150, 20)',
                        'rgb(200, 59, 120)',
                        'rgb(230, 200, 120)',
                        'rgb(0, 59, 120)',
                        'rgb(100, 59, 0)',
                        'rgb(120, 200, 200)',
                        'rgb(0, 25, 0)',
                        'rgb(255, 100, 100)'
                    ],
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: reportLabel
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            max: max,
                            min: 0,
                        }
                    }]
                },
                legend: {
                    display: true
                }
            }
        });
    }

    function createGraphPie(dataValues, labels, graph, dataSetLabel, reportLabel, type) {
        new Chart(graph, {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    label: dataSetLabel,
                    backgroundColor: [
                        'rgb(173, 5, 5)',
                        'rgb(54, 162, 235)',
                        'rgb(100, 59, 100)',
                        'rgb(50, 150, 20)',
                        'rgb(200, 59, 120)',
                        'rgb(230, 200, 120)',
                        'rgb(0, 59, 120)',
                        'rgb(100, 59, 0)',
                        'rgb(120, 200, 200)'
                    ],
                    borderColor: [
                        'rgb(173, 5, 5)',
                        'rgb(54, 162, 235)',
                        'rgb(100, 59, 100)',
                        'rgb(50, 150, 20)',
                        'rgb(200, 59, 120)',
                        'rgb(230, 200, 120)',
                        'rgb(0, 59, 120)',
                        'rgb(100, 59, 0)',
                        'rgb(120, 200, 200)'
                    ],
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: reportLabel
                },
                legend: {
                    display: true
                }
            }
        });
    }
</script>
