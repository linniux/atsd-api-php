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

class Entities  extends AtsdClient {
    const ENTITIES_URI = '/entities?';
    const ENTITIES_FOR_GROUP_URI = '/entity-groups/[[group]]/entities?';
    const ENTITY = '/entities/[[entity]]';
    const METRICS_FOR_ENTITY = '/entities/[[entity]]/metrics?';
    protected $queryUri;

    function __construct($client) {
        parent::__construct($client);
    }

    function findAll($getParameters = array()) {
        $this->queryUri = Entities::ENTITIES_URI;
        $this->applyGetParameters($getParameters);
        return $this->query($this->queryUri . $this->getParams);
    }

    function find($entity = "") {
        $this->queryUri = str_replace('[[entity]]', urlencode($entity), Entities::ENTITY);
        return $this->query($this->queryUri);
    } 

    function findForGroup($group, $getParameters = array()) {
        $this->queryUri = str_replace('[[group]]', urlencode($group), Entities::ENTITIES_FOR_GROUP_URI);
        $this->applyGetParameters($getParameters);
        return $this->query($this->queryUri . $this->getParams);
    }

    function findMetrics($entity, $getParameters = array()) {
        $this->queryUri = str_replace('[[entity]]', urlencode($entity), Entities::METRICS_FOR_ENTITY);
        $this->applyGetParameters($getParameters);
        return $this->query($this->queryUri . $this->getParams);
    }

    private function applyGetParameters($parameters) {
        $this->getParams = http_build_query($parameters);
    }
}