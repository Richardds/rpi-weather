var xhr = new XMLHttpRequest();
xhr.open('GET', '/data');
xhr.onload = function () {
    if (xhr.status === 200) {
        var data = JSON.parse(xhr.responseText);
        var labels = [], temperature = [], humidity = [];

        for (var i = 0; i < data.length; i++) {
            labels.push(data[i].time);
            temperature.push(data[i].temperature);
            humidity.push(data[i].humidity);
        }

        var chart_temperature = new Chartist.Line('#chart-temperature', {
            labels: labels,
            series: [temperature]
        }, {
            fullWidth: true,
            showArea: true,
            lineSmooth: Chartist.Interpolation.cardinal({
                fillHoles: true
            }),
            axisY: {
                labelInterpolationFnc: function (value) {
                    return value + '°C'
                }
            }
        });

        var chart_humidity = new Chartist.Line('#chart-humidity', {
            labels: labels,
            series: [humidity]
        }, {
            fullWidth: true,
            showArea: true,
            lineSmooth: Chartist.Interpolation.cardinal({
                fillHoles: true
            }),
            axisY: {
                labelInterpolationFnc: function (value) {
                    return value + '%'
                }
            }
        });
    } else {
        alert('Error occurred!');
    }
};
xhr.send();
