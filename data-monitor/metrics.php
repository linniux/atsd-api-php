<?php
namespace axibase\atsdPHP;
require_once '../atsdPHP/HttpClient.php';
require_once '../atsdPHP/models/Entities.php';
$client = new Entities(HttpClient::getInstance());
if (empty($_REQUEST['entity'])) {
    exit("Entity is not specified");
}
$metrics = $client->findMetrics($_REQUEST['entity']);
if($metrics === false) {
    $metrics = array();
}

function prepareTimestamp($timestamp) {
    $date = new \DateTime();
    $date->setTimestamp($timestamp/1000);
    return $date->format('Y-m-d H:i:s');
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require('head.html'); ?>
</head>
<body>
<h3 class="metricTitle">Entity: <?= $_REQUEST['entity'] ?></h3>
<div id="timezone">
    All times specified in <b><?=date_default_timezone_get()?></b>
</div>
<table id="metrics" border="1px" class="table-striped table-bordered table-condensed sortable midtable">
    <tr class="table-head">
        <th>Last Insert</th>
        <th>Metric Name</th>

    </tr>
    <?php if (!empty($metrics)) {
        foreach ($metrics as $metric) {
            echo "<tr class='metric'>";
            echo "<td class='time'>" . (empty($metric['lastInsertTime']) ? "" : prepareTimestamp($metric['lastInsertTime'])) . "</td>";
            echo "<td>" . $metric['name'] . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>

</body>
</html>