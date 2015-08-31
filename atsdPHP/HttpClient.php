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

namespace axibase\atsdPHP {
    /**
     * Class ConnectionManager
     * @package axibase\atsdPHP
     */
    class HttpClient {
        const CONFIG = 'atsd.ini';

        function __construct() {
            if(!function_exists('curl_version')) {
                echo "ERROR: can not find curl extension.";
                die();
            }
            $this->defOptions = array(
                CURLOPT_HTTPHEADER => array('content-Type: application/json', 'charset=utf-8', 'Connection: keep-alive'),
                CURLOPT_RETURNTRANSFER => true
            );
            $iniArray = parse_ini_file(self::CONFIG);
            if(array_key_exists('url', $iniArray) && array_key_exists('username', $iniArray) && array_key_exists('password', $iniArray)) {
                $this->url = $iniArray["url"];
                $this->username = $iniArray["username"];
                $this->password =  $iniArray["password"];
            } else {
                throw new \Exception("url, username or password is not set.");
            }
        }
        /**
         * Init connection with specified url.
         *
         * @param string $url atsd base url (Example: "http://atsd.example.com:8090")
         * @param string $username username
         * @param string $password atsd user's password
         */
        public function connect() {
            $this->curlHandler = curl_init();
            curl_setopt_array($this->curlHandler, $this->defOptions);
            curl_setopt($this->curlHandler, CURLOPT_USERPWD, "$this->username:$this->password");
        }

        public function query($uri, $postdata = null) {
            if ($this->curlHandler == null) {
                throw new \Exception("Need to connect first.");
            }
            if($postdata === null) {
                curl_setopt($this->curlHandler, CURLOPT_POST, false);
                curl_setopt($this->curlHandler, CURLOPT_URL, $this->url . $uri);
            } else {
                curl_setopt($this->curlHandler, CURLOPT_POST, true);
                curl_setopt($this->curlHandler, CURLOPT_URL, $this->url . $uri);
                curl_setopt($this->curlHandler, CURLOPT_POSTFIELDS, json_encode($postdata));
            }
            $response = curl_exec($this->curlHandler);
            $responseContentType = curl_getinfo($this->curlHandler, CURLINFO_CONTENT_TYPE);
            if(strpos($responseContentType, "json") !== false) {
                $response = json_decode($response, true);
                if ($response === null) {
                    throw new \ErrorException("Error: " . var_export(curl_getinfo($this->curlHandler), true));
                }
                if (array_key_exists("error", $response) && isset($response["error"])) {
                    throw new \ErrorException('Error: ' . $response['error']);
                }
            }
            return $response;
        }

        /**
         *  Close current connection.
         */
        public function close() {
            curl_close($this->curlHandler);
            $this->curlHandler = null;
        }


        private $url;
        private $username;
        private $password;

        private $curlHandler;

        private $defOptions;
    }
}