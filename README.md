# Axibase Time-Series Database Client for PHP

The **ATSD Client for PHP** enables PHP developers to easily read and write statistics and metadata from
[Axibase Time-Series Database][atsd]. Build reporting, analytics, and alerting solutions with minimal effort.
Get started using this API for PHP using [Composer][axibase_atsd-api-php] .

* [Documentation][atsd-api]
* [Issues][atsd-issues]

## Implemented Methods

**The ATSD Client for PHP** provides an easy-to-use client for interfacing with **ATSD** metadata and data REST API services.
It has the ability to read time-series values, statistics, properties, alerts, and messages.

- Data API
    - Series
        - QUERY
    - Properties
        - QUERY
    - Alerts
        - QUERY
    - Alerts History
        - QUERY

- Metadata API
    - Metrics
        - Get Metrics
        - Get Metric
        - Get Entities and Series Tags for Metric
    - Entities
        - Get Entities
        - Get Metrics for Entity
    - Entity Groups
        - Get Entity Groups
        - Entities for Entity Group


## Getting Started
Installing ATSD - Before you begin, you need to install your own copy of the [Axibase Time-Series Database][atsd].
Download the latest version of ATSD available for your Linux distribution.

Minimum requirements - PHP 5.3.2+ is needed to run the ATSD Client.

Installing the ATSD Client

```
git clone https://github.com/axibase/atsd-api-php.git
mv atsd-api-php /{your_documentroot_folder}/
cd /{you_documentroot_folder}/atsd-api-php/examples
firefox *.php
```
## Composer
Inside of composer.json specify the following:
```
{
"require": {
    "axbase/atsd-api-php": "dev-master"
    }
}
```
## Examples

See
[AtsdClientBasicExample][atsd-basic-example]

[AtsdClientAlertsExample][atsd-alerts-example]

[AtsdClientAlertsHistoryExample][atsd-alertsHistory-example]

[AtsdClientEntitiesExample][atsd-entities-example]

[AtsdClientEntityAndTagsExample][atsd-entitiesEndTags-example]

[AtsdClientEntityGroupsExample][atsd-entityGroup-example]

[AtsdClientMetricsExample][atsd-metrics-example]

[AtsdClientPropertiesExample][atsd-properties-example]

[AtsdClientSeriesExample][atsd-series-example]

### Client Configuration

```php
$iniArray = parse_ini_file("atsd.ini");
```

### Metadata Processing
```php
$iniArray = parse_ini_file("atsd.ini");
$client = new HttpClient();
$client->connect($iniArray["url"], $iniArray["username"], $iniArray["password"]);

$expression = 'name like \'nurs*\'';
$tags = 'app, os';
$limit = 10;

$entities = new Entities($client);

$params = array("limit" => $limit, 'expression' => $expression, 'tags' => $tags );
$entitiesResponse = $entities->findAll($params);

$viewConfig = new ViewConfiguration('Entities for expression: ' . $expression . "; tags: " . $tags . "; limit: " . $limit, 'entities', array('lastInsertTime' => 'unixtimestamp'));
$entitiesTable = Utils::arrayAsHtmlTable($entitiesResponse, $viewConfig);

Utils::render(array($entitiesTable));

$client->close();
```

### Data Queries
```java
$iniArray = parse_ini_file("atsd.ini");
$client = new HttpClient();
$client->connect($iniArray["url"], $iniArray["username"], $iniArray["password"]);

$endTime = time() * 1000;
$startTime = $endTime - 2*60 * 60 * 1000;
$series = (new Series($client, $startTime, $endTime))
    ->addDetailSeries('s-detail', 'awsswgvml001', 'disk_used', array('mount_point' => ['/']))
    ->addAggregateSeries('s-avg', 'awsswgvml001', 'disk_used', array('mount_point' => ['/']), AggregateType::MIN, 1, TimeUnit::HOUR)
    ->addAggregateSeries('s-min', 'awsswgvml001', 'disk_used', array('mount_point' => ['/']), AggregateType::MAX, 1, TimeUnit::HOUR)
    ->addAggregateSeries('s-max', 'awsswgvml001', 'disk_used', array('mount_point' => ['/']), AggregateType::AVG, 1, TimeUnit::HOUR)
    ->addSeries('s-multiple', array(
        'entity' => 'awsswgvml001',
        'metric' => 'disk_used',
        'tags' => array(
            'mount_point' => ['*']
        ),
        'type' => AggregateType::PERCENTILE_99,
        'intervalCount' => 1,
        'intervalUnit' => TimeUnit::HOUR,
        'multipleSeries' => true
    ));
$series->execQuery();

$tables = array();
$tables[] = Utils::seriesAsHtml($series->getSeries('s-avg'));
$tables[] = Utils::seriesAsHtml($series->getSeries('s-min'));
$tables[] = Utils::seriesAsHtml($series->getSeries('s-max'));
$tables[] = Utils::seriesAsHtml($series->getSeries('s-multiple'));
$tables[] = Utils::seriesAsHtml($series->getSeries('s-detail'));

Utils::render($tables);
$client->close();
```

### Troubleshooting

If you get an error like
```
Fatal error: Uncaught exception 'Exception' with message 'DateTime::__construct():
It is not safe to rely on the system's timezone settings. You are required to use the date.timezone setting or the date_default_timezone_set() function.
In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier.
We selected the timezone 'UTC' for now, but please set date.timezone to select your timezone.' 
```
ensure that the variable date.timezone in your php.ini is set.

[atsd]:https://axibase.com/products/axibase-time-series-database/
[atsd-api]:https://axibase.com/products/axibase-time-series-database/reading-data/php/
[atsd-zip]:https://github.com/axibase/atsd-api-java/releases/download/untagged-0901a806a9372ef24c51/v0.3-alpha.zip
[atsd-issues]:https://www.axibase.com/support.htm

[atsd-alerts-example]:http://htmlpreview.github.io/?https://github.com/axibase/atsd-api-php/blob/master/examples/AlertsExample.html
[atsd-alertsHistory-example]:http://htmlpreview.github.io/?https://github.com/axibase/atsd-api-php/blob/master/examples/AlertsHistoryExample.html
[atsd-entities-example]:http://htmlpreview.github.io/?https://github.com/axibase/atsd-api-php/blob/master/examples/EntitiesExample.html
[atsd-entitiesEndTags-example]:http://htmlpreview.github.io/?https://github.com/axibase/atsd-api-php/blob/master/examples/EntityAndTagsExample.html
[atsd-entityGroup-example]:http://htmlpreview.github.io/?https://github.com/axibase/atsd-api-php/blob/master/examples/EntityGroupsExample.html
[atsd-metrics-example]:http://htmlpreview.github.io/?https://github.com/axibase/atsd-api-php/blob/master/examples/MetricsExample.html
[atsd-properties-example]:http://htmlpreview.github.io/?https://github.com/axibase/atsd-api-php/blob/master/examples/PropertiesExample.html
[atsd-series-example]:http://htmlpreview.github.io/?https://github.com/axibase/atsd-api-php/blob/master/examples/SeriesExample.html
[atsd-basic-example]:http://htmlpreview.github.io/?https://github.com/axibase/atsd-api-php/blob/master/examples/BasicExample.html
[axibase_atsd-api-php]:https://packagist.org/packages/axibase/atsd-api-php
