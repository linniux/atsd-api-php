var widgetConfigs = {};

widgetConfigs.text = [{
    initSize: { width: 200, height: 300},
    title: 'Current Usage',
    timespan: '1 hour',
    timezone: 'UTC',
    format: getCfgFormat('watthour'),
    path: 'ApiProxy.php',
    series: [{
        label: 'Current Usage',
        metric: 'sml.power-consumed',
        icon: './css/ecology_color_21.svg',
        statistics: 'sum',
        period: '1 hour'
    }]
}]

widgetConfigs.chart = [{
    initSize: { width: 800, height: 300 },
    title: 'Daily Power Usage, Hourly Total',
    timespan: '1 day',
    timezone: 'UTC',
    endtime: 'next_day',
    format: getCfgFormat('watthour'),
    stepline: false,
    autoperiod: false,
    path: 'ApiProxy.php',
    style: 'padding: 20px',
    series: [{
        label: 'Today',
        color: 'limegreen'
    }, {
        label: 'Yesterday',
        timeoffset: '1 day',
        color: 'orange'
    }, {
        label: 'Month Ago',
        timeoffset: '1 month',
        color: 'silver'
    }].forEach(function(s){
            s.period = '1 hour';
            s.statistics = 'sum';
            s.metric = 'sml.power-consumed';
        })
}
, {
    initSize: { width: 1050, height: 300},
    title: 'Monthly Power Usage, Daily Total',
    timespan: '1 month',
    timezone: 'UTC',
    endtime: 'next_month',
    format: getCfgFormat('watthour'),
    stepline: false,
    autoperiod: false,
    mode: 'column',
    path: 'ApiProxy.php',
    dayformat: "%m/%d",
    style: 'padding: 20px',
    retaintimespan: true,
    series: [{
        widthUnits: '2',
        metric: 'sml.power-consumed',
        label: 'Today',
        color: 'limegreen',
        period: '1 day',
        statistics: 'sum'
    }]
},{
    initSize: { width: 1050, height: 300},
    timespan: '1 month',
    timezone: 'UTC',
    endtime: 'next_month',
    autoperiod: false,
    format: getCfgFormat('watthour'),
    dayformat: "%m/%d",
    mode: 'columnstack',
    path: 'ApiProxy.php',
    style: 'padding: 20px',
    series: []

}]
