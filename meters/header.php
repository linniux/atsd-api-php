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
<body onLoad="onBodyLoad()" onresize=resizeWidgets("<?=$request->getSelectedEntity()?>")>
<table width="100%">
    <tbody >
    <tr style="white-space: nowrap;">
        <td style="text-align: left; vertical-align: top; font-size: 20px;">
            <b><?=$title?></b>
        </td>
        <td style="width: 20px; white-space: nowrap">
            <form method="POST" action="index.php">
                User:
                <b><?=htmlspecialchars($_SESSION['user'])?></b>
            </form>
            <div style="font-size: 10px; text-align: right">All times specified in <?=$request->getTimezone()?>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<?php if($request->getError() !== null) {
    exit($request->getError());
}
