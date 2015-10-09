<?php require_once ('includes/Request.php');
$request = new Request();
$title = "Summary Report";?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once("includes/head.php") ?>
    <script type="text/javascript" src="js/summary.js"></script>
</head>
<body onLoad="onBodyLoad();generateSummary()">

<?php include_once("includes/menu.php") ?>

<div id="data">
    <table>
        <tbody>
            <tr>
                <td><div id="summary-chart" class="widget"></div></td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>

