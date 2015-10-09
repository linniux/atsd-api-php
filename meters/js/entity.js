(function(global, undefined){

global.getReport = function(entity, date, interval) {
    location.href = "CsvGenerator.php?entity=" + entity + "&endDate=" + date + "&interval=" + interval + "&metric=" + metricValue;
};

global.generateWidgets = function(entity){
    if(entity == "") {
        return;
    }
    var cEntity = entity;
    var configName = "entity.config";
    loadWidgets('conf/' + configName + '?cache=' + Date.now(), function (widgetConfigs) {
        var daily = widgetConfigs[0];
        var current = widgetConfigs[1];
        var monthly = widgetConfigs[2];


        for(var j = 0; j < daily.series.length; j++) {
            daily.series[j].entity = cEntity;
        }
        for(var j = 0; j < current.series.length; j++) {
            current.series[j].entity = cEntity;
        }
        for(var j = 0; j < monthly.series.length; j++) {
            monthly.series[j].entity = cEntity;
        }

        updateWidget(daily, 'daily-usage');
        updateWidget(current, 'current-usage');
        updateWidget(monthly, 'monthly-usage');
    });










};

})(window);
