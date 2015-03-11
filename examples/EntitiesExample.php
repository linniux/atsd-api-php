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
require_once '../src/atsdPHP/models/Entities.php';
require_once '../src/atsdPHP/HttpClient.php';
require_once '../src/atsdPHP/Utils.php';

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
