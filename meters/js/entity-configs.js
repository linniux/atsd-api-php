var metricValue = "sml.power-consumed";

currentUsageConfig = {
    initSize: {width: 250, height: 300},
    url: "",
    type: 'text',
    title: 'Current Usage',
    timespan: '1 hour',
    timezone: 'UTC',
    format: getCfgFormat('watthour'),
    path: 'ApiProxy.php',
    series: [{
        label: 'Current Usage',
        metric: metricValue,
        icon: './css/ecology_color_21.svg',
        statistics: 'sum',
        period: '1 hour'
    }]
};

dailyUsageConfig = {
    initSize: {width: 500, height: 300},
    url: "",
    type: 'chart',
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
        color: 'green'
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
            s.metric = metricValue;
        })
};

monthlyUsageConfig = {
    initSize: {width: 800, height: 300},
    url: "",
    type: 'chart',
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
        metric: metricValue,
        label: 'Today',
        color: 'green',
        period: '1 day',
        statistics: 'sum'
    }]
};
