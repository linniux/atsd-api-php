<?php require_once (dirname(__FILE__)) . '/Request.php';
$request = new axibase\atsdPHP\Request();
?>
<!DOCTYPE html>
<!--
/*
* Copyright 2015 Axibase Corporation or its affiliates. All Rights Reserved.
*
* Licensed under the Apache License, Version 2.0 (the "License").
* You may not use this file except in compliance with the License.
* A copy of the License is located at
*
* https://www.axibase.com/atsd/axibase-apache-2.0.pdf
*
* or in the "license" file accompanying this file. This file is distributed
* on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
* express or implied. See the License for the specific language governing
* permissions and limitations under the License.
*/
-->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" type="text/css" href="https://lab.axibase.com/chartlab/portal/CSS/charts.min.css"/>
    <link href="css/meters.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="https://axibase.com/atsd/portalFiddle/portal/JavaScript/d3.min.js"></script>
    <script type="text/javascript" src="https://axibase.com/atsd/portalFiddle/portal/JavaScript/portal_init.js"></script>
    <script type="text/javascript" src="https://lab.axibase.com/chartlab/portal/JavaScript/charts.min.js"></script>
    <script type="text/javascript" src="js/meters-config.js"></script>
    <script type="text/javascript" src="js/initialize.js"></script>
    <script type="text/javascript" src="js/meters.js"></script>
</head>
<body onLoad="onBodyLoad()">
<table width="100%">
    <tbody >
        <tr style="white-space: nowrap;">
            <td style="width: 20px">
                User:
            </td>
            <td style="width: 20px">
                <b><?=htmlspecialchars($_SESSION['user'])?></b>
            </td>
            <td align="right">
                All times specified in <?=$request->getTimezone()?>
            </td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
    <tr>
        <td style="padding-top: 10px">Meters:</td>
        <td></td>
    </tr>
    <tr>
        <td style="padding-top: 10px; padding-right: 20px" valign="top">
            <form method="POST" style="white-space: nowrap">
                    <?php foreach($_SESSION['entities'] as $entity): ?>
                        <input type="radio" <?=($request->getSelectedEntity() == $entity)?"checked":""?>
                               name="entity" value="<?=htmlspecialchars($entity)?>" id="<?=htmlspecialchars($entity) ?>" onchange="this.form.submit()">
                        <label for="<?=htmlspecialchars($entity)?>"><?=htmlspecialchars($entity)?></label></br>
                    <?php endforeach; ?>
                    <input type="hidden" value="false" id="summary" name="summary"/>
                    <input type="button" value="summary" onclick="document.getElementById('summary').value = true; this.form.submit()"/>
            </form>
       </td>
       <td>
           <div>
               <table style="width:100%">
                   <tbody>
                    <?php if(!$request->isSummary()) :?>
                        <tr>
                            <td><div class="widget-chart-0 widget"></div></td>
                            <td><div class="widget-text-0 widget"></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><div class="widget-chart-1 widget"></div></td>
                        </tr>
                    <?php else :?>
                        <tr>
                            <td colspan="2"><div class="widget-chart-2 widget"></div></td>
                        </tr>
                    <?php endif?>
                   </tbody>
               </table>
           </div>
       </td>
    </tr>
    <?php if(!$request->isSummary() && $request->getSelectedEntity()) :?>
        <tr>
            <td></td>
            <td>
                <div>
                    <h4>Daily Reports:</h4>
                    <?php for($i = 0; $i < 7; $i++) :?>
                        <a href="javascript:getReport('<?=$request->getSelectedEntity()?>','<?=$request->formatEndTime("day", $i, $view = false)?>','1-DAY')"><?=$request->formatEndTime('day', $i, $view = true)?></a></br>
                    <?php endfor;?>
                </div>
                <div>
                    <h4>Weekly Reports:</h4>
                    <?php for($i = 0; $i < 4; $i++) :?>
                        <a href="javascript:getReport('<?=$request->getSelectedEntity()?>','<?=$request->formatEndTime("week", $i, $view = false)?>','1-WEEK')"><?=$request->formatEndTime('week', $i, $view = true)?></a></br>
                    <?php endfor;?>
                </div>
                <div>
                    <h4>Monthly Reports:</h4>
                    <?php for($i = 0; $i < 3; $i++) :?>
                        <a href="javascript:getReport('<?=$request->getSelectedEntity()?>','<?=$request->formatEndTime("month", $i, $view = false)?>','1-MONTH')"><?=$request->formatEndTime('month', $i, $view = true)?></a></br>
                    <?php endfor;?>
                </div>
            </td>
        </tr>
    <?php endif;?>
    </tbody>
</table>
<script>
    function onBodyLoad(){
        <?php if(!$request->isSummary()) :?>
            generateWidgets("<?=$request->getSelectedEntity()?>");
        <?php else :?>
            generateSummary();
        <?php endif?>
    }
</script>

</body>
</html>