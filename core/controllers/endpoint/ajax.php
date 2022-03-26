<?php
require_once('../../../vendor/autoload.php');
use mcdavidsh\controllers\controllers;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$controller = new controllers();

if (isset($_POST["get_staff"]) || isset($_POST["get_admin"])){
    $controller->get_users();
}elseif (isset($_POST["salary_log"]) ){
    $controller->get_salary_log();
}else {
    die(http_response_code(400));
}