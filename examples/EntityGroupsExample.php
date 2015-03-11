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
require_once '../src/atsdPHP/models/EntityGroups.php';
require_once '../src/atsdPHP/models/Entities.php';
require_once '../src/atsdPHP/HttpClient.php';
require_once '../src/atsdPHP/Utils.php';

$iniArray = parse_ini_file("atsd.ini");
$client = new HttpClient();
$client->connect($iniArray["url"], $iniArray["username"], $iniArray["password"]);

$limit = 8;

$queryClient = new EntityGroups($client);

$params = array("limit" => $limit);
$responseEntities = $queryClient->findAll($params);

$viewConfig = new ViewConfiguration("Entity groups, limit:" . $limit, 'entGroups');
$groupsTbl = Utils::arrayAsHtmlTable($responseEntities, $viewConfig);

$group = "nmon-linux";
$responseGroup = $queryClient->find($group);

$viewConfigGroup = new ViewConfiguration('Group: ' . $group, 'group');
$groupsTable = Utils::arrayAsHtmlTable(array($responseGroup), $viewConfigGroup);

$responseEntitiesForGroup = $queryClient->findForGroup($group);

$viewConfigEntities = new ViewConfiguration('Entities for group: ' . $group , 'entForGroup', array('lastInsertTime' => 'unixtimestamp'));
$entitiesForGroupTable = Utils::arrayAsHtmlTable($responseEntitiesForGroup, $viewConfigEntities);


Utils::render(array($groupsTbl, $groupsTable, $entitiesForGroupTable));
$client->close();
