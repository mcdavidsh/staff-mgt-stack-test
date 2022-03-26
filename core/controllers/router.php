<?php

namespace mcdavidsh\controllers;

class router extends controllers
{

    public function route(){

        $route["home"] = array("route"=>"/","dir"=> $this->view."home.php" );
        $route["error"] = array("route"=>"/404","dir"=> $this->view."404.php" );
        $route["profile"] = array("route"=>"/profile","dir"=> $this->view."profile.php" );
        $route["staff"] = array("route"=>"/manage-staff","dir"=> $this->view."staff.php" );
        $route["admin"] = array("route"=>"/manage-admin","dir"=> $this->view."admin.php" );
        $route["login"] = array("route"=>"/auth/login","dir"=> $this->view."auth/login.php" );
        $route["forgot_pass"] = array("route"=>"/auth/forgot-password","dir"=> $this->view."auth/forgot-password.php" );
        $route["security"] = array("route"=>"/security","dir"=> $this->view."security.php" );
        $route["salary_log"] = array("route"=>"/salary-log","dir"=> $this->view."salary-log.php" );

        $route["error_exception"] = array($route["error"]["route"]);
        $route["auth_exceptions"] = array($route["login"]["route"], $route["forgot_pass"]["route"]);

        return json_encode($route);
    }
}