<?php
namespace axibase\atsdPHP;
require_once(dirname(__FILE__)) . '/../atsdPHP/HttpClient.php';
require_once(dirname(__FILE__)) . '/../atsdPHP/models/EntityGroups.php';

class Request {
    const TIMEZONE = 'UTC';
    private $selectedEntity;
    private $summary;
    private $timezone;

    function isSummary() {
        return $this->summary;
    }

    function getSelectedEntity() {
        return $this->selectedEntity;
    }

    function getTimezone() {
        return $this->timezone->getName();
    }

    function __construct() {
        $this->timezone = new \DateTimeZone(self::TIMEZONE);
        session_start();
        if(!array_key_exists('PHP_AUTH_USER', $_SERVER)) {
            exit("Authentication required");
        }
        if(!array_key_exists('user', $_SESSION) || $_SESSION['user'] != $_SERVER['PHP_AUTH_USER']) {
            session_unset();
            $_SESSION['user'] = $_SERVER['PHP_AUTH_USER'];
        }
        if(!array_key_exists('entities', $_SESSION)) {
            $this->cacheEntities();
        }
        $this->selectedEntity = null;
        $this->summary = (array_key_exists('summary', $_REQUEST) && $_REQUEST['summary'] == 'true');

        if(!$this->summary && array_key_exists('entity', $_REQUEST)) {
            $this->selectedEntity = $_POST['entity'];
        }
    }

    function cacheEntities() {
        $user = $_SESSION['user'];
        $userToGroup = parse_ini_file('users-group.ini');
        if(!array_key_exists($user, $userToGroup) || $userToGroup[$user] == "") {
            exit("Can not find group for user " . $user);
        }
        $entities = array();
        $httpClient = new HttpClient();
        $httpClient->connect();
        $entityGroups = new EntityGroups($httpClient);
        $response = $entityGroups->findEntities($userToGroup[$user]);
        foreach($response as $entity) {
            $entities[] = $entity["name"];
        }
        $_SESSION['entities'] = $entities;
    }

    function formatEndTime($intervalType, $num, $view = false) {
        $endDate = new \DateTime('now', $this->timezone);
        $dayInterval = new \DateInterval('P1D');
        switch ($intervalType) {
            case 'day':
                $interval = $dayInterval;
                break;
            case 'week':
                if($endDate->format('w') == 1) {
                    $endDate->add($dayInterval);
                }
                $interval = new \DateInterval('P1W');
                while($endDate->format('w') != 1) {
                    $endDate->add($dayInterval);
                }
                break;
            case 'month':
                if($endDate->format('d') == 1) {
                    $endDate->add($dayInterval);
                }
                $interval = new \DateInterval('P1M');
                while($endDate->format('d') != 1) {
                    $endDate->add($dayInterval);
                }
                break;
            default:
                return "";
                break;
        }
        for($i = 0; $i < $num; $i++) {
            $endDate->sub($interval);
        }
        $endTime = "";
        if($view) {
            switch($intervalType) {
                case 'day':
                    $endTime = $endDate->format('Y-m-d');
                    break;
                case 'week' || 'month':
                    $to = $endDate->sub($dayInterval)->format('Y-m-d');
                    $from = $endDate->add($dayInterval)->sub($interval)->format('Y-m-d');
                    $endTime = $from . "  -  " . $to;
                    break;
                default:
                    break;
            }

        } else {
            switch($intervalType) {
                case 'day':
                    $endDate->add($interval);
                    $endTime = $endDate->format('Y-m-d') . "T00:00:00.001Z";
                    break;
                case 'week' || 'month':
                    $to = $endDate->format('Y-m-d') . "T00:00:00.000Z";
                    $endTime = $to;
                    break;
                default:
                    break;
            }

        }
        return $endTime;
    }
}