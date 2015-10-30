<?php
namespace axibase\atsdPHP;
require_once '../atsdPHP/HttpClient.php';
require_once '../atsdPHP/models/EntityGroups.php';


$client = new EntityGroups();
$groups = $client->findAll();
if (!isset($_REQUEST['lag']))
    $_REQUEST['lag'] = "15";
if (!isset($_REQUEST['ahead']))
    $_REQUEST['ahead'] = "1";


if (!isset($_REQUEST['status'])) {
    $_REQUEST['status'] = 'all';
}

$entities = array();
if (!empty($_REQUEST['group'])) {
    $entities = $client->findEntities($_REQUEST['group'], array("tags" => "*"));
    if($entities === false) {
        $entities = array();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php require('includes/head.html'); ?>
    <script type="text/javascript" src="js/index.js"></script>
</head>
<body>

<?php require('includes/menu.php') ?>
<?php require('includes/time.php');?>


<table id="data" border="1px" class="table-striped table-bordered table-condensed sortable midtable data-table">
    <tr class="table-head">
        <th>Status</th>
        <th>Last Insert</th>
        <th>Time Lag (min:sec)</th>
        <th>Entity</th>
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
            echo "<tr class='data-node'>";
            echo "<td class='status'><div class='status-div'></div></td>";
            echo "<td class='time' data-time=" . (empty($entity['lastInsertTime']) ? "" : $entity['lastInsertTime']) . ">" . (empty($entity['lastInsertTime']) ? "" : prepareTimestamp($entity['lastInsertTime'])) . "</td>";

            echo "<td class='diff' sorttable_customkey='" . (empty($entity['lastInsertTime']) ? "0" : $entity['lastInsertTime']) . "'>" . (empty($entity['lastInsertTime']) ? "" : getDiff($date, $entity['lastInsertTime'])) . "</td>";

            echo '<td><a href=javascript:redirect("' . rawurlencode($entity['name']) . '")>' . $entity['name']. '</a></td>';


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
