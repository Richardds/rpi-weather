<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Raspberry Pi Weather</title>
    <link rel="stylesheet" href="{{ asset_url("/assets/css/chartist.min.css") }}" type="text/css">
    <link rel="shortcut icon" href="{{ asset_url("/assets/images/favicon.ico") }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset_url("/assets/images/apple-touch-icon.png") }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset_url("/assets/images/favicon-32x32.png") }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset_url("/assets/images/favicon-16x16.png") }}">
    <link rel="manifest" href="{{ asset_url("/assets/images/manifest.json") }}">
    <link rel="mask-icon" href="{{ asset_url("/assets/images/safari-pinned-tab.svg") }}" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

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

        #chart-humidity .ct-bar {
            stroke: rgba(80, 200, 200, 0.8);
        }

        h1.title {
            text-align: center;
            color: #5f5f5f;
        }

        .status {
            font-size: 18px;
            text-align: center;
            margin: 5px;
        }

        .status.loading {
            color: blue;
        }

        .status.error {
            color: red;
        }
    </style>
</head>
<body onload="Weather.init()">
<h1 class="title">Raspberry Pi Weather</h1>
<div id="status" class="status loading"></div>
<div id="chart-temperature" class="chart"></div>
<div id="chart-humidity" class="chart"></div>

<script src="{{ asset_url("/assets/js/chartist.min.js") }}" type="application/javascript"></script>
<script src="{{ asset_url("/assets/js/rpi-weather.js") }}" type="application/javascript"></script>
</body>
</html>
