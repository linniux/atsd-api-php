# Axibase Time-Series Database Client for PHP

The **ATSD Client for PHP** enables PHP developers to easily read and write statistics and metadata from the 
[Axibase Time-Series Database][atsd]. With minimal effort, you can build reporting, analytics, and alerting solutions. Use [Composer][axibase_atsd-api-php] to get started with this PHP API.

* [Documentation][atsd-api]
* [Issues][atsd-issues]

## Implemented Methods

**The ATSD Client for PHP** in an easy-to-use client for interfacing with **ATSD** metadata and data REST API services.
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
Before you begin installing ATSD Client for PHP, you need to install a copy of the [Axibase Time-Series Database][atsd]. Download the latest version of ATSD that is available for your Linux distribution.

Minimum requirements for running the ATSD Client: PHP 5.3.2+

Installing the ATSD Client:

```
git clone https://github.com/axibase/atsd-api-php.git
mv atsd-api-php /{your_documentroot_folder}/
cd /{you_documentroot_folder}/atsd-api-php/examples
firefox *.php
```
## Composer
Once in composer.json, specify the following:
```
{
"require": {
    "axbase/atsd-api-php": "dev-master"
    }
}
```
## Examples

See:
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

$queryClient = new Entities($client);

$params = array("limit" => $limit, 'expression' => $expression, 'tags' => $tags );
$responseEntities = $queryClient->findAll($params);

$viewConfig = new ViewConfiguration('Entities for expression: ' . $expression . "; tags: " . $tags . "; limit: " . $limit, 'entities', array('lastInsertTime' => 'unixtimestamp'));
$entitiesTable = Utils::arrayAsHtmlTable($responseEntities, $viewConfig);

$entity = "awsswgvml001";
$responseEntity = $queryClient->find($entity);

$viewConfig = new ViewConfiguration('Entity: ' . $entity, "entity");
$entityTable = Utils::arrayAsHtmlTable(array($responseEntity), $viewConfig);

$params = array("limit" => $limit);
$responseMetrics = $queryClient->findMetrics($entity, $params);

$viewConfig = new ViewConfiguration('Metrics for entity: ' . $entity, "metrics");
$metricsTable = Utils::arrayAsHtmlTable($responseMetrics, $viewConfig);

Utils::render(array($entitiesTable, $entityTable, $metricsTable));


$client->close();
```

### Data Queries
```php
$iniArray = parse_ini_file("atsd.ini");
$client = new HttpClient();
$client->connect($iniArray["url"], $iniArray["username"], $iniArray["password"]);

$queryClient = new Series($client);
$queryClient->addDetailQuery('nurswgvml007', 'cpu_busy', 1424612226000, 1424612453000);

$aggregator = new Aggregator(array(AggregateType::AVG), array("count" => 1, "unit" => TimeUnit::HOUR));
$queryClient->addAggregateQuery('nurswgvml007', 'cpu_busy', 0, 1424612453000, $aggregator);
$queryClient->addQuery("nurswgvml007", "cpu_busy", array("limit" => "4"));
$response = $queryClient->execQueries();

$tables = array();
$tables[] = Utils::seriesAsHtml(array($response[0]), "detail series");
$tables[] = Utils::seriesAsHtml(array($response[1]), "aggregate series");
$tables[] = Utils::seriesAsHtml(array($response[2]), "custom series");

Utils::render($tables);
$client->close();
```

### Troubleshooting

If you get an error like the following, ensure that the variable date.timezone in your php.ini is set.
```
Fatal error: Uncaught exception 'Exception' with message 'DateTime::__construct():
It is not safe to rely on the system's timezone settings. You are required to use the date.timezone setting or the date_default_timezone_set() function.
In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier.
We selected the timezone 'UTC' for now, but please set date.timezone to select your timezone.' 
```

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
