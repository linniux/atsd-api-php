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

class EntityGroups extends AtsdClient {
    const URI = '/entity-groups?';
    const GROUP_URI = '/entity-groups/[[group]]';
    protected $queryUri;

    function __construct($client) {
        parent::__construct($client);
    }

    function findAll($getParameters = array()) {
        $this->queryUri = EntityGroups::URI;
        $this->applyGetParameters($getParameters);
        return $this->query($this->queryUri . $this->getParams);
    }

    function find($group) {
        $this->queryUri = str_replace('[[group]]', urlencode($group), EntityGroups::GROUP_URI);
        return $this->query($this->queryUri);
    }

    private function applyGetParameters($getParameters) {
        $this->getParams = http_build_query($getParameters);
    }
}