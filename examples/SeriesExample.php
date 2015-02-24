<?php
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

namespace axibase\atsdPHP;
require_once '../src/atsdPHP/AtsdClient.php';
require_once '../src/atsdPHP/models/Series.php';
require_once '../src/atsdPHP/HttpClient.php';
require_once '../src/atsdPHP/Utils.php';
require_once '../src/atsdPHP/Constants.php';

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
