var metricValue = "sml.power-consumed";

summaryConfig = {
    initSize: {width: 800, height: 600},
    url: "",
    type: 'chart',
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
};

