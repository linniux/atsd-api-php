<?php require_once (dirname(__FILE__)) . '/Request.php';
$request = new Request();
$title = "Summary Report";?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once("./head.php") ?>
    <script type="text/javascript" src="js/summary-configs.js"></script>
    <script type="text/javascript" src="js/summary.js"></script>
</head>
<body onLoad="generateSummary()">

<?php include_once("./menu.php") ?>

<div id="data">
    <table>
        <tbody>
            <tr>
                <td><div id="chart-0" class="widget"></div></td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>

