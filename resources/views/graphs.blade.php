<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Raspberry Pi Weather Station</title>
    <link href="{{ url("/assets/css/chartist.min.css") }}" type="text/css" rel="stylesheet">
    <style>
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
<div id="chart-temperature"></div>
<div id="chart-humidity"></div>

<script src="{{ url("/assets/js/chartist.min.js") }}" type="application/javascript"></script>
<script src="{{ url("/assets/js/rpi-weather.js") }}" type="application/javascript"></script>
</body>
</html>