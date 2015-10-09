(function(global, undefined){

global.generateSummary = function() {
    var colors = [ 'steelblue', 'orange', 'green', 'magenta', 'silver'];
    var entities = document.getElementsByName('entity');
    for(i = 0; i < entities.length; i++) {
        entity = entities[i];
        var serie = {
            metric: metricValue,
            entity: entity.getAttribute('value'),
            label: entity.getAttribute('value'),
            period: '1 day',
            serverAggregate: true,
            statistic: 'sum',
            color: colors[i]

        };
        summaryConfig.series.push(serie);
    }
    updateWidget(summaryConfig, [summaryConfig.type, 0].join('-'));
}

})(window);
