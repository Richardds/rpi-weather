var Weather = {
    status: null,
    statusMessage: function (message, status) {
        this.status.textContent = message;
        this.status.className = 'status';
        if (typeof status !== 'undefined') {
            this.status.classList.add(status || '');
        }
    },
    init: function () {
        this.status = document.getElementById('status');
        this.statusMessage('Loading...', 'loading');
        this.reload();
    },
    reload: function () {
        var self = this;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/data');
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                if (!response.success) {
                    self.statusMessage('Failed to load weather data!', 'error');
                    return;
                }

                self.data(response.data)
            } else {
                this.statusMessage('Failed to load weather data!', 'error');
            }
        };
        xhr.send();
    },
    data: function (data) {
        var labels = [], temperature = [], humidity = [];

        for (var i = 0; i < data.history.length; i++) {
            var history_data = data.history[i];
            labels.push(history_data['time']);
            temperature.push(history_data['temperature']);
            humidity.push(history_data['humidity']);
        }

        var chart_temperature = new Chartist.Line('#chart-temperature', {
            labels: labels,
            series: [temperature]
        }, {
            height: 300,
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

        var chart_humidity = new Chartist.Bar('#chart-humidity', {
            labels: labels,
            series: [humidity]
        }, {
            height: 300,
            high: 100,
            low: 0,
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

        var now = data.now;
        this.statusMessage(now['time'] + ' / ' + now['temperature'] + '°C / ' + now['humidity'] + '%');
    }
};

var status = document.getElementById('status');
