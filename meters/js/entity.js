(function(global, undefined){

global.getReport = function(entity, date, interval) {
    location.href = "CsvGenerator.php?entity=" + entity + "&endDate=" + date + "&interval=" + interval + "&metric=" + metricValue;
};

global.generateWidgets = function(entity){
    if(entity == "") {
        return;
    }
    for(var j = 0; j < currentUsageConfig.series.length; j++) {
        currentUsageConfig.series[j].entity = entity;
    }
    for(var j = 0; j < dailyUsageConfig.series.length; j++) {
        dailyUsageConfig.series[j].entity = entity;
    }
    for(var j = 0; j < monthlyUsageConfig.series.length; j++) {
        monthlyUsageConfig.series[j].entity = entity;
    }
    updateWidget(dailyUsageConfig, 'dailyUsage');
    updateWidget(currentUsageConfig, 'currentUsage');
    updateWidget(monthlyUsageConfig, 'monthlyUsage');
};

})(window);
