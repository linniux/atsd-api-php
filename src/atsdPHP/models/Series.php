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

class Series extends AtsdClient{
    const URL = "/series";
    private $startTime;
    private $endTime;
    private $seriesKeyIdMap;
    private $seriesKeyIndexMap;
    private $series;
    /**
     * @param ConnectionManager $client object for connect to server
     * @param int $startTime start interval time in millis
     * @param int $endTime end interval time in millis
     * @throws \Exception
     */
    function __construct($client, $startTime, $endTime) {
        parent::__construct($client);
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->postParams = [];
        $this->seriesKeyIdMap = array();
        $this->seriesKeyIndexMap = array();
    }

    /**
     * @param string $key series map key
     * @param string $entity
     * @param string $metric
     * @param array $tags map of tags arrays (Example: array('tag1' => ['val1', 'val2'], 'tag2' => ['val3'])
     * @return $this
     */
    public function addDetailSeries($key, $entity, $metric, $tags = null) {
        $this->addSeries($key, array(
            'entity' => $entity,
            'metric' => $metric,
            'tags' => $tags,
            'type' => AggregateType::DETAIL
        ));
        return $this;
    }

    /**
     * @param string $key series map key
     * @param string $entity
     * @param string $metric
     * @param array $tags map of tags arrays (Example: array('tag1' => ['val1', 'val2'], 'tag2' => ['val3'])
     * @param string $type AggregateType::Value aggregate type constant
     * @param int $intervalCount
     * @param string $intervalUnit TimeUnit::Value time constant
     * @return $this
     */
    public function addAggregateSeries($key, $entity, $metric, $tags, $type, $intervalCount, $intervalUnit) {
        $this->addSeries($key, array(
            'entity' => $entity,
            'metric' => $metric,
            'tags' => $tags,
            'type' => $type,
            'intervalCount' => $intervalCount,
            'intervalUnit' => $intervalUnit
        ));
        return $this;
    }

    /**
     * @param string $key series map key
     * @param array $reqMap
     * Example:
     * <code>
     * array(
     *  'entity' => 'NURSWGVML007',
     *  'metric' => 'disk_used',
     *  'tags' => array(
     *      'mount_point' => ['*']
     *  ),
     *  'type' => Type::SUM,
     *  'intervalCount' => 1,
     *  'intervalUnit' => TimeUnit::HOUR,
     *  'rateCount' => 1,
     *  'rateUnit' => TimeUnit::HOUR,
     *  'statistics' => 'forecast',
     *  'multipleSeries' => false
     * )
     * </code>
     *
     * @return $this
     */
    public function addSeries($key, $reqMap) {
        $standardReqMap = $this->toStandardReqMap($reqMap);

        $requestId = $this->buildRequestId($standardReqMap);
        $this->seriesKeyIdMap[$key] = $requestId;
        if (array_key_exists($key, $this->seriesKeyIndexMap)) {
            $this->postParams[$this->seriesKeyIndexMap[$key]] = $standardReqMap;
        } else {
            $this->postParams[] = $standardReqMap;
        }
        return $this;
    }

    public function execQuery() {
        $query = array(
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'json' => true
        );
        $response = $this->query(Series::URL . '?' . http_build_query($query));
        $this->series = $response;
    }

    public function getStartTime() {
        return $this->startTime;
    }

    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    public function getEndTime() {
        return $this->endTime;
    }

    public function setEndTime($endTime) {
        $this->endTime = $endTime;
    }

    private function toStandardReqMap($reqMap) {
        $standardReqMap = $reqMap;
        $standardReqMap['entity'] = strtolower($reqMap['entity']);
        $standardReqMap['metric'] = strtolower($reqMap['metric']);
        if (array_key_exists('tags', $reqMap)) {
            $lowerNamesTags = array();
            foreach ($reqMap['tags'] as $tagName => $tagValues) {
                $lowerNamesTags[strtolower($tagName)] = $tagValues;
            }
            $standardReqMap['tags'] = $lowerNamesTags;
        }
        $standardReqMap['multipleSeries'] = (array_key_exists('multipleSeries', $reqMap) && $reqMap['multipleSeries'] == false) ? 'false' : 'true';
        return $standardReqMap;
    }

    private function buildRequestId($standardReqMap) {
        $requestId = $standardReqMap['entity'] . ":" .
            $standardReqMap['metric'] . ":" .
            $this->tagsToIdPart($standardReqMap['tags']) . ":" .
            $standardReqMap['type'];
        if (array_key_exists('intervalUnit', $standardReqMap) && array_key_exists('intervalCount', $standardReqMap)) {
            $requestId .= ":" . $standardReqMap['intervalCount'] . "=" . $standardReqMap['intervalUnit'];
        }
        if (array_key_exists('rateUnit', $standardReqMap) && array_key_exists('rateCount', $standardReqMap)) {
            $requestId .= ":" . $standardReqMap['rateCount'] . "=" . $standardReqMap['rateUnit'];
        }
        if (array_key_exists('statistics', $standardReqMap)) {
            $requestId .= ":forecast";
        }
        $requestId .= ':multipleSeries=' . $standardReqMap['multipleSeries'];
        return $requestId;
    }

    private function tagsToIdPart($tags) {
        $string = '';
        if ($tags != null) {
            foreach ($tags as $tagName => $tagValues) {
                foreach ($tagValues as $tagValue) {
                    $string .= $tagName . "=" . $tagValue . ",";
                }
            }
        }
        return rtrim($string, ",");
    }

    public function getSeries($key) {
        $series = [];
        foreach ($this->series as $s) {
            if ($s['requestId'] == $this->seriesKeyIdMap[$key]) {
                $series[] = $s;
            }
        }
        return $series;
    }
}



