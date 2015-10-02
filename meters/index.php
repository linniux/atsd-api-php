<?php require_once ('includes/Request.php');
$request = new Request();
$title = "Meter Report";?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once("includes/head.php") ?>
    <script type="text/javascript" src="js/entity-configs.js"></script>
    <script type="text/javascript" src="js/entity.js"></script>
</head>
<body onLoad="generateWidgets('<?=$request->getSelectedEntity()?>')">

<?php include_once("includes/menu.php") ?>

<div id="data">
    <table>
        <tbody>
        <tr>
            <td>
                <div id="dailyUsage" class="widget"></div>
            </td>
            <td>
                <div id="currentUsage" class="widget"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div id="monthlyUsage" class="widget"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php if ($request->getSelectedEntity()) : ?>
                    <div>
                        <h4>Daily Reports:</h4>
                        <?php for ($i = 0; $i < 7; $i++) : ?>
                            <a href="javascript:getReport('<?= $request->getSelectedEntity() ?>','<?= $request->formatEndTime("day", $i, $view = false) ?>','1-DAY')"><?= $request->formatEndTime('day', $i, $view = true) ?></a></br>
                        <?php endfor; ?>
                    </div>
                    <div>
                        <h4>Weekly Reports:</h4>
                        <?php for ($i = 0; $i < 4; $i++) : ?>
                            <a href="javascript:getReport('<?= $request->getSelectedEntity() ?>','<?= $request->formatEndTime("week", $i, $view = false) ?>','1-WEEK')"><?= $request->formatEndTime('week', $i, $view = true) ?></a></br>
                        <?php endfor; ?>
                    </div>
                    <div>
                        <h4>Monthly Reports:</h4>
                        <?php for ($i = 0; $i < 3; $i++) : ?>
                            <a href="javascript:getReport('<?= $request->getSelectedEntity() ?>','<?= $request->formatEndTime("month", $i, $view = false) ?>','1-MONTH')"><?= $request->formatEndTime('month', $i, $view = true) ?></a></br>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>