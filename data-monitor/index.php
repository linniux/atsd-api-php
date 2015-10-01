<?php
namespace axibase\atsdPHP;
require_once '../atsdPHP/HttpClient.php';
require_once '../atsdPHP/models/EntityGroups.php';
$client = new EntityGroups(HttpClient::getInstance());
$groups = $client->findAll();
if (!isset($_REQUEST['lag'])) {
    $_REQUEST['lag'] = "15";
}
if (!isset($_REQUEST['ahead'])) {
    $_REQUEST['ahead'] = "1";
}


if (!isset($_REQUEST['filter'])) {
    $_REQUEST['filter'] = 'all';
}
$entities = array();
if (!empty($_REQUEST['group'])) {
    $entities = $client->findEntities($_REQUEST['group'], array("tags" => "*"));
    if($entities === false) {
        $entities = array();
    }
}
function prepareTimestamp($timestamp) {
    $date = new \DateTime();
    $date->setTimestamp($timestamp / 1000);
    return $date->format('Y-m-d H:i:s');
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php require('head.html'); ?>
</head>
<body>

<?php require('menu.php') ?>


<table id="entities" border="1px" class="table-striped table-bordered table-condensed sortable midtable">
    <tr class="table-head">
        <th>Status</th>
        <th>Last Insert</th>
        <th>Name</th>
        <?php
        $orderedTags = array();
        foreach ($entities as $entity) {
            if (!empty($entity['tags'])) {
                foreach ($entity['tags'] as $key => $value) {
                    if (!in_array($key, $orderedTags)) {
                        $orderedTags[] = $key;
                        echo "<th>" . htmlspecialchars($key) . "</th>";
                    };
                }
            }
        }
        ?>

    </tr>
    <?php if (!empty($entities)) {
        foreach ($entities as $entity) {
            if (!$entity['enabled']) {
                continue;
            }
            echo "<tr class='entity'>";
            echo "<td class='status'></td>";
            echo "<td class='time' data-time=" . (empty($entity['lastInsertTime']) ? "" : $entity['lastInsertTime']) . ">" . (empty($entity['lastInsertTime']) ? "" : prepareTimestamp($entity['lastInsertTime'])) . "</td>";

            echo "<td>" . $entity['name'] . "</td>";


            foreach ($orderedTags as $tagName) {
                if (!empty($entity['tags'][$tagName])) {
                    echo "<td>" . $entity['tags'][$tagName] . "</td>";
                } else {
                    echo "<td></td>";
                }
            }

            echo "</tr>";
        }
    }
    ?>
</table>


</body>
</html>