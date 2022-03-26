<?php
require_once('../../../vendor/autoload.php');
use mcdavidsh\controllers\controllers;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$fetch =json_decode(file_get_contents('php://input'), true);


$controller = new controllers();


 if (isset($fetch['login_form']) || isset($fetch['staff_info'])|| isset($fetch['update_account_form'])|| isset($fetch['create_account'])|| isset($fetch['reset_pass'])|| isset($fetch['logout'])){
   $controller->account_init();
 }elseif (isset($fetch['pay_single_salary']) || isset($fetch['pay_multi_salary']) ){
   $controller->salary_init();
 }else {
     die(http_response_code(400));
 }