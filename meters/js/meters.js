(function(global, undefined){

function resizeWidgets(entity) {
    if(entity == "") {
        return;
    }
    var _widgetConfigs = widgetConfigs;
    for(var type in _widgetConfigs) {
        if(_widgetConfigs.hasOwnProperty(type)) {
            var configs = _widgetConfigs[type];
            for(var i = 0; i < configs.length; i++) {
                if(type != 'chart' || i != 2) {
                    var className = ["widget", type, i].join('-');
                    var widget = getWidget(className);
                    size = {
                        width: getActualWidth(type, i),
                        height: 300
                    }
                    resizeWidget(widget, false, size);
                }
            }
        }
    }
}

function resizeSummary() {
    var className = ["widget", "chart", 2].join("-");
    widget = getWidget(className);
    size = {
        width: getActualWidth("chart", 2),
        height: 300
    }
    resizeWidget(widget, false, size);
}

function getWidget(className) {
    var widget = document.getElementsByClassName(className)[0].__innerWidget__;
    return widget;
}

function getActualWidth(type, index) {
    var width;
    if(type == "text") {
        width = 300;
    } else {
        width = window.innerWidth - document.getElementById("menu").offsetWidth -150
        if(width < 720) {
            width = 720;
        }
        if(width > 1000) {
            width = 1000;
        }
        if(index == 0) {
            width -= 320;
        }
    }
    return width;
}

function getReport(entity, date, interval) {
    metric = widgetConfigs.chart[0].series[0].metric;
    url = "CsvGenerator.php?entity=" + entity + "&endDate=" + date + "&interval=" + interval + "&metric=" + metric;
    console.log(url);
    location.href = url;
}

function generateWidgets(entity){
    if(entity == "") {
        return;
    }
    var _widgetConfigs = widgetConfigs;
    for(var type in _widgetConfigs) {
        if(_widgetConfigs.hasOwnProperty(type)) {
            var configs = _widgetConfigs[type];
            for(var i = 0; i < configs.length; i++) {
                if(type != 'chart' || i != 2) {
                    for(var j = 0; j < configs[i]["series"].length; j++) {
                        configs[i]["series"][j]["entity"] = entity;
                    }
                    size = {
                        width: getActualWidth(type, i),
                        height: 300
                    }
                    configs[i].initSize = size;
                    updateWidget(configs[i], type, i);
                }
            }
        }
    }
}

function generateSummary() {
    var _widgetConfigs = widgetConfigs;
    var colors = [ 'steelblue', 'orange', 'green', 'magenta', 'silver'];

    var config = _widgetConfigs['chart'][2];
    var count = 0;
    size = {
        width: getActualWidth("chart", 2),
        height: 300
    }
    config.initSize = size;

    var entities = document.getElementsByName('entity');
    for(i = 0; i < entities.length; i++) {
        entity = entities[i];
        var serie = {
            metric: metricValue,
            entity: entity.getAttribute('value'),
            label: entity.getAttribute('value'),
            period: '1 day',
            serveraggregate: 'true',
            statistics: 'sum',
            color: colors[count++]

        };
        config.series.push(serie);
    }
    updateWidget(config, 'chart', 2);
}
global.getReport = getReport;
global.generateSummary = generateSummary;
global.resizeSummary = resizeSummary;
global.generateWidgets = generateWidgets;
global.resizeWidgets = resizeWidgets;
})(window);
