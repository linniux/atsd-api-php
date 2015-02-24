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

abstract class TimeUnit {
    const YEAR = 'year';
    const QUARTER = 'quarter';
    const MONTH = 'month';
    const WEEK = 'week';
    const DAY = 'day';
    const HOUR = 'hour';
    const MINUTE = 'minute';
    const SECOND = 'second';
}

abstract class AggregateType {
    const DETAIL = 'detail';
    const AVG = 'avg';
    const MAX = 'max';
    const MIN = 'min';
    const COUNT = 'count';
    const SUM = 'sum';
    const PERCENTILE_999 = 'percentile_999';
    const PERCENTILE_995 = 'percentile_995';
    const PERCENTILE_99 = 'percentile_99';
    const PERCENTILE_95 = 'percentile_95';
    const PERCENTILE_90 = 'percentile_90';
    const PERCENTILE_75 = 'percentile_75';
    const PERCENTILE_50 = 'percentile_50';
    const STANDARD_DEVIATION = 'standard_deviation';
    const FIRST = 'first';
    const LAST = 'last';
    const DELTA = 'delta';
    const WAVG = 'wavg';
    const WTAVG = 'wtavg';
}

