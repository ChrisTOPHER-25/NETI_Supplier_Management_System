@extends('layouts.supplier')


@section('page-title')
    Dashboard
@endsection

@section('content')
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        const nav = document.getElementById('navDashboard');
        nav.classList.add('border-bottom');
    </script>

    {{-- Content Header --}}
    <div class="row mt-4">
        <div class="col-auto">
            <span class="fs-3 fw-bold">DASHBOARD</span>
        </div>
        @if (session()->has('message'))
            <div>
                <span class="text-success">{{ session('message') }}</span>
            </div>
        @endif
    </div>

    <hr class="mt-3 mb-3">

    {{-- Content --}}
    <div class="col">
        <div class="card shadow-lg">
            <h5 class="card-header text-center text-white" style="background-color: #020166;">SUMMARY</h5>
            <div class="card-body d-flex justify-content-center">
                <div id="myChart"></div>
            </div>
        </div>
        <style>

        </style>
    </div>

    <div class="col">
        <div class="card shadow-lg">
            <h5 class="card-header text-center text-white" style="background-color: #020166;">CATEGORIES</h5>
            <div class="card-body">
                <div id="curve_chart"></div>
            </div>
        </div>
    </div>
    </div>

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Catigories', ''],
                ['LAPTOP', 1000],
                ['MOUSE', 1170],
                ['KEYBOARD', 660],
                ['MONITOR', 1030]
            ]);

            var options = {
                curveType: 'function',
                legend: 'none',
                width: 705,
                height: 300,
            };

            var chart = new google.visualization.BarChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>

    <script>
        google.charts.load('current', {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        // Your Function
        function drawChart() {

            // Set Data
            const data = google.visualization.arrayToDataTable([
                ['data', 'Mhl'],
                ['Completed', 35],
                ['On going', 42],
                ['Declined', 15],
            ]);

            const completedColor = '#069C56';
            const ongoingColor = '#FF980E';
            const rejectedColor = '#D3212C';

            const options = {
                slices: {
                    0: {
                        color: completedColor
                    },
                    1: {
                        color: ongoingColor
                    },
                    2: {
                        color: rejectedColor
                    },
                },
                legend: 'none',
                width: 500,
                height: 300,
                pieHole: 0.5,
            };

            const chart = new google.visualization.PieChart(document.getElementById('myChart'));
            chart.draw(data, options);
        }
    </script>
@endsection
