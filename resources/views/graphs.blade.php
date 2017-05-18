<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Raspberry Pi Weather Station</title>
    <link href="{{ url("/assets/css/chartist.min.css") }}" type="text/css" rel="stylesheet">
    <style>
        .chart svg.ct-chart-bar, .chart svg.ct-chart-line {
            overflow: visible;
        }

        .chart .ct-label.ct-horizontal.ct-end {
            position: relative;
            -webkit-box-pack: end;
            -ms-flex-pack: end;
            justify-content: flex-end;
            text-align: right;
            -webkit-transform-origin: 100% 0;
            transform-origin: 100% 0;
            -webkit-transform: translate(-100%) rotate(-45deg);
            transform: translate(-100%) rotate(-45deg);
            white-space: nowrap;
        }

        #chart-temperature .ct-line {
            stroke: rgba(255, 200, 0, 0.8);
        }

        #chart-temperature .ct-point {
            stroke: rgba(255, 200, 0, 1.0);
        }

        #chart-temperature .ct-area {
            fill: rgba(255, 200, 0, 0.6);
        }

        #chart-humidity .ct-line {
            stroke: rgba(80, 200, 200, 0.8);
        }

        #chart-humidity .ct-point {
            stroke: rgba(80, 200, 200, 1.0);
        }

        #chart-humidity .ct-area {
            fill: rgba(80, 200, 200, 0.6);
        }

        h1.title {
            text-align: center;
            color: #5f5f5f;
        }
    </style>
</head>
<body>

<h1 class="title">Raspberry Pi weather station</h1>
<div id="chart-temperature" class="chart"></div>
<div id="chart-humidity" class="chart"></div>

<script src="{{ url("/assets/js/chartist.min.js") }}" type="application/javascript"></script>
<script src="{{ url("/assets/js/rpi-weather.js") }}" type="application/javascript"></script>
</body>
</html>