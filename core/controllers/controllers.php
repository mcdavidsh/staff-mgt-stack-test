<?php

namespace mcdavidsh\controllers;

session_start();

use Dotenv\Dotenv;
use mysql_xdevapi\Exception;
use NumberFormatter;

date_default_timezone_set("Africa/Lagos");
ini_set('apc.localcache', 1);// cache code
ini_set("log_errors", 1); // Enable error logging
ini_set("error_log", __DIR__ . "/error_logs.txt"); // set error path

$dotenv = Dotenv::createImmutable(__DIR__ . "/../../");

$dotenv->load();

class controllers
{
   public $dblink = null;
   public $view = "core/controllers/view/";
   public $assets = "core/assets/";

    public function __construct()
    {
        try {
            $this->dblink = new \mysqli($_ENV["DBHOST"], $_ENV["DBUSER"], $_ENV["DBPASS"], $_ENV["DBNAME"]);

            if ($this->dblink->connect_error) {
                throw new \Exception(die('Database Connection Failed. Check and try again'));
            }
        } catch (\Exception $exception) {
            throw new \Exception(die($exception->getMessage()));
        }
    }
    public function assets(){
        return $this->app_info()->app_domain.$this->assets;
    }
    public function dblink(){
        return $this->dblink;
    }
    public function app_info(){
        $q = $this->dblink()->prepare('select * from settings');
        $q->execute();
        return $q->get_result()->fetch_object();
    }

    function active_nav ($route=array()){
        $request = $_SERVER["REQUEST_URI"];
        if ($request === $route){
            echo "active";
        }elseif(in_array($request, $route)){
            echo "active";
        }
    }

    function page_title(){
        $request = $_SERVER["REQUEST_URI"];
        return ucwords(str_replace("/", " ", $request));
    }
    function naira_formatter($amount){

        $fmtcurr = new NumberFormatter("en_NG", NumberFormatter::CURRENCY);
        $fmtcurr->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'NGN');
        $fmtcurr->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
        return $fmtcurr->formatCurrency($amount, 'NGN');
    }


    function limit($start, $length){

        if ($_POST["length"] != -1) {
            $limit = ' LIMIT ' . $start . ', ' . $length;
        }
        return $limit;
    }
    function order($table, $sortOrder, $columnName){
        $orderby = ' ORDER BY '.$table.'.id '.$sortOrder.', '.$table.'.'.$columnName.' '.$sortOrder.' ';
        return $orderby;
    }

    function filter($searchRequest,$columns, $row){
        $multiple_search = array();


        for ($x=0;$x<count($columns['col']); $x++) {



            $multiple_search[] = '' . $columns['col'][$x] . ' LIKE  "%' . $searchRequest . '%" ';


        }
        $where = '';
        if (!empty($searchRequest)) {

            $where = 'where '.$row.' (' . implode(' OR ', $multiple_search) . ') ';
            }else {
            $where = 'where '.$row.' (' . implode(' OR ', $multiple_search) . ') ';
        }


        return $where;

    }
    public function validate($data)
    {

        try {


            $data = trim($data);
            $data = stripslashes($data);
            $data = strip_tags($data);
            $data = htmlspecialchars($data);
            $data = mysqli_real_escape_string($this->dblink, $data);
            $data = $this->dblink->real_escape_string($data);
            return $data;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    function check_session(){
        try {
            $route = json_decode((new router())->route());
            if (!isset($_SESSION["id"])){
            $url = $route->login->route;
            header("location:$url");
        }
            }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }
    function is_session(){
        try {
            $route = json_decode((new router())->route());
            if (isset($_SESSION["id"])){
                $url = $route->home->route;
                header("location:$url");
            }
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }
    function account_init(){
        try {
            $route = json_decode((new router())->route());
            $fetch =json_decode(file_get_contents('php://input'), true);
            if (isset($fetch['login_form'])){
                $email = $this->validate(filter_var($fetch['email'], FILTER_SANITIZE_EMAIL));
                $pass = $this->validate($fetch['password']);
                if (empty($email)){
                    $response = 'empty_email';
                }elseif (empty($pass)){
                    $response = 'empty_password';
                }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $response= 'invalid_email';
                }else {
                    $q = $this->dblink()->prepare('select * from users where email = ?');
                    $q->bind_param('s', $email);
                    $q->execute();
                    $res = $q->get_result();
                    if ($res->num_rows > 0){
                        $data = $res->fetch_object();
                        if ($data->status == 1) {
                            if (password_verify($pass, $data->password)) {
                                $_SESSION['id'] = $data->id;
                                switch ($data->role) {
                                    case 1:
                                        $_SESSION['admin'] = $email;
                                        $response = 'handshake';
                                        $rout = $route->home->route;
                                        break;
                                    case 2:
                                        $_SESSION['staff'] = $email;
                                        $response = 'handshake';
                                        $rout = $route->home->route;
                                        break;
                                }
                            } else {
                                $response = 'invalid_password';
                            }
                        }else {
                            $response = 'inactive_account';
                        }
                    }else {
                        $response='invalid_account';
                    }
                }

            }
            elseif (isset($fetch['create_account'])){
                $email = $this->validate(filter_var($fetch['email'], FILTER_SANITIZE_EMAIL));
                $pass = $this->validate($fetch['password']);
                $hash = password_hash($pass,PASSWORD_DEFAULT);
                $fname = $this->validate($fetch['fname']);
                $lname = $this->validate($fetch['lname']);
                $role = $fetch['role'];
                $status = 1;
                $ck = $this->dblink()->prepare( "select * from users where email =?");
                $ck->bind_param('s',$email);
                $ck->execute();
                $ckrs = $ck->get_result();

                if ($ckrs->num_rows > 0){
                    $response = 'exists';
                } elseif (empty($email)){
                    $response = 'empty_email';
                } elseif (empty($fname)){
                    $response = 'empty_fname';
                } elseif (empty($lname)){
                    $response = 'empty_lname';
                }elseif (empty($pass)){
                    $response = 'empty_password';
                }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $response= 'invalid_email';
                }else {
                    $q = $this->dblink()->prepare('insert into users(firstname, lastname, email, password, role, status) VALUES  (?,?,?,?,?,?)');
                    $q->bind_param('ssssii', $fname,$lname,$email,$hash,$role,$status);

                    if ($q->execute()){
                        $response='handshake';
                    }else {
                        $response='error';
                    }
                }

            }

            elseif(isset($fetch['staff_info'])){
                $id = !empty($fetch['pid'])?$fetch['pid']:$_SESSION['id'];
                $q = $this->dblink()->prepare('select * from users where id = ?');
                $q->bind_param('i',$id);
                $q->execute();
                $response = $q->get_result()->fetch_object();

            }
            elseif(isset($fetch['update_account_form'])){
                $id = $fetch['id'];
                $fname = $this->validate($fetch['fname']);
                $lname = $this->validate($fetch['lname']);
                $email = $this->validate($fetch['email']);
                $phone = $this->validate($fetch['phone']);
                $pin = $this->validate($fetch['pin']);
                $status = !empty($fetch['status'])?$this->validate($fetch['status']):'';
                $wallet = !empty($fetch['wallet'])?$this->validate(filter_var($fetch['wallet'], FILTER_SANITIZE_NUMBER_INT)):'';
                $address = $this->validate($fetch['address']);
                $q = $this->dblink()->prepare('update users set firstname = ?, lastname = ?, email = ?, phone = ?, wallet = ?, address = ?, status = ?  , pin = ? where id = ?');
                $q->bind_param('ssssssiii',$fname,$lname,$email,$phone,$wallet,$address,$status,$pin, $id);
               if ( $q->execute()) {
                   if ($q->affected_rows > 0) {
                       $response = 'handshake';
                   }
               }else {
                   $response = 'error';
               }


            }
            elseif(isset($fetch['reset_pass'])){
                $id = isset($_SESSION['id'])?$_SESSION['id']:"";
                $new = $this->validate($fetch['newpass']);
                $conf = $this->validate($fetch['confnewpass']);
                $pin = $fetch['pin'];
                if (!is_numeric($pin)){
                    $response ='invalid_pin';
                }elseif(strlen($pin) !== 4){
                    $response ='four_pin';
                }
                else {
                    $col = isset($_SESSION['id']) ? "where id = ?" : "where pin = ?";
                    $bind = isset($_SESSION['id']) ? $id : $pin;
                    $ck = $this->dblink()->prepare("select * from users $col");
                    $ck->bind_param('i', $bind);
                    $ck->execute();
                    $ckres = $ck->get_result()->fetch_object();
                    if (intval($pin) !== $ckres->pin) {
                        $response = 'mismatch_pin';
                    } elseif (empty($pin)) {
                        $response = 'empty_pin';
                    } elseif (empty($new)) {
                        $response = 'empty_new';
                    } elseif (empty($conf)) {
                        $response = 'empty_conf';
                    } elseif ($conf !== $new) {
                        $response = 'mismatch';
                    } else {
                        $hash = password_hash($new, PASSWORD_DEFAULT);
                        $q = $this->dblink()->prepare("update users set password = ?  $col");

                        $q->bind_param('si', $hash, $bind);
                        if ($q->execute()) {
                            if ($q->affected_rows > 0) {
                                $response = 'handshake';
                            }
                        } else {
                            $response = 'error';
                        }
                    }

                }
            }
            elseif(isset($fetch['logout'])){
                session_destroy();
             $response = 'handshake';
             $rout = $route->login->route;


            }
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }



        $return = array(
            'status'=>!empty($response)?$response:'',
            'route'=>!empty($rout)?$rout: ''
        );
        echo  json_encode($return);

    }
    function salary_init(){
        try {

            $fetch =json_decode(file_get_contents('php://input'), true);
           if(isset($fetch['pay_single_salary'])){
                $id = $fetch['id'];
                $sal = $this->validate(filter_var($fetch['salary'], FILTER_SANITIZE_NUMBER_INT));
               if (empty($sal)){
                    $response = 'empty_sal';
                }elseif (!is_numeric($sal)){
                   $response = 'invalid_format';
               } else {
                    $q = $this->dblink()->prepare("update users set wallet = wallet + ?  where id = ?");
                    $q->bind_param('ii', $sal, $id);
                    if ($q->execute()) {
                        if ($q->affected_rows > 0) {
                            $aid = $_SESSION['id'];
                            $ad = $this->dblink()->query("update users set wallet = wallet - $sal  where id = $aid");
                            if ($ad == true) {
                                $bal = $this->dblink()->query("select wallet from users where id = $aid");
                               $abal = $bal->fetch_object()->wallet;
                                $this->dblink()->query("insert into salary_log(admin_id, staff_id, salary_amount, admin_bal) values ($aid,$id,$sal,$abal)");
                                $response = 'handshake';

                            }

                        }
                       
                    } else {
                        $response = 'error';
                    }
                }

            }
           if(isset($fetch['pay_multi_salary'])){
                $sal = $this->validate(filter_var($fetch['salary'], FILTER_SANITIZE_NUMBER_INT));
                $role = 2;
               if (empty($sal)){
                    $response = 'empty_sal';
                }elseif (!intval($sal)){
                   $response = 'invalid_format';
               } else {
                    $q = $this->dblink()->prepare("update users set wallet = wallet + ? where role = ?");
                    $q->bind_param('ii', $sal, $role);
                    if ($q->execute()) {
                        if ($q->affected_rows > 0) {
                            $aid = $_SESSION['id'];
                            $ad = $this->dblink()->query("update users set wallet = wallet - $sal  where id = $aid");
                            if ($ad == true) {
                                $bal = $this->dblink()->query("select wallet from users where id = $aid");
                               $abal = $bal->fetch_object()->wallet;
                               $all = $q->affected_rows;
                                $this->dblink()->query("insert into salary_log(admin_id, staff_id, salary_amount, admin_bal) values ($aid,$all,$sal,$abal)");
                                $response = 'handshake';

                            }

                        }

                    } else {
                        $response = 'error';
                    }
                }

            }
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }



        $return = array(
            'status'=>!empty($response)?$response:'',
        );
        echo  json_encode($return);

    }



    function get_users(){
        try {

            $role = isset($_POST["get_staff"])?2:1;
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length'];
            $columnIndex = $_POST['order']["0"]["column"];
            $columnName = $_POST['columns'][$columnIndex]["data"];
            $columnOrder = $_POST['order']["0"]["dir"];
            $searchValue = $_POST['search']['value']; // Search value
            $table = 'users';
            $columns = array( 'col'=> array( 0 => 'firstname', 1  => 'lastname', 2  => 'email', 3  => 'phone', 4=>'wallet',5=>'address'));
            $role_query = 'role = '.$role.' and';
            $where = $this->filter($searchValue, $columns, $role_query);
            $orderby = $this->order($table,$columnOrder, $columnName);
            $limit = $this->limit($row, $rowperpage);
            $q = $this->dblink()->prepare("select * from $table $where $orderby $limit  ");
            $q->execute();
            $res = $q->get_result();
            $filter = $res->num_rows;
            $ftall = $this->dblink()->prepare("select * from $table");
            $ftall->execute();
            $ftres = $ftall->get_result();
            $recordTotal = $ftres->num_rows;

            if ($res->num_rows > 0) {
                $data = array();
                $i = 1;
                foreach ($res as $re):
                    $id = $i++;
                    $data[] = array(

                        'id' => $id,
                        'pid' => $re['id'],
                        'firstname' => $re['firstname'],
                        'lastname' => $re['lastname'],
                        'phone' => $re['phone'],
                        'wallet' => $this->naira_formatter($re['wallet']),
                        'status' => ($re['status'] == 1)? '<span class="badge bg-success">Active</span>':'<span class="badge bg-danger">Inactive</span>',
                        'actions' => '',

                    );
                endforeach;


            }

        }catch (\Exception $e){
            throw new Exception($e->getMessage());
        }
        $return = array(
            "draw" => !empty ($draw) ? intval($draw) : 0,
            'recordsTotal' =>!empty( $recordTotal)?$recordTotal:0,
            'recordsFiltered' => !empty($filter)?$filter:0,
            'data' => !empty($data)?$data:"",
        );
        echo  json_encode($return);
    }
    function get_salary_log(){
        try {

            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length'];
            $columnIndex = $_POST['order']["0"]["column"];
            $columnName = $_POST['columns'][$columnIndex]["data"];
            $columnOrder = $_POST['order']["0"]["dir"];
            $searchValue = $_POST['search']['value']; // Search value
            $table = 'salary_log';
            $columns = array( 'col'=> array( 0 => 'salary_amount', 1  => 'admin_bal'));
            $role_query = ' ';
            $where = $this->filter($searchValue, $columns, $role_query);
            $orderby = $this->order($table,$columnOrder, $columnName);
            $limit = $this->limit($row, $rowperpage);
            $q = $this->dblink()->prepare("select * from $table");
            $q->execute();
            $res = $q->get_result();
            $filter = $res->num_rows;
            $ftall = $this->dblink()->prepare("select * from $table  $limit");
            $ftall->execute();
            $ftres = $ftall->get_result();
            $recordTotal = $ftres->num_rows;

            if ($res->num_rows > 0) {
                $data = array();
                $i = 1;
                foreach ($res as $re):
                    $id = $i++;
                    $data[] = array(

                        'id' => $id,
                        'pid' => $re['id'],
                        'admin_name' => $re['admin_id'],
                        'staff_name' => $re['staff_id'],
                        'salary' => $this->naira_formatter($re['salary_amount']),
                        'balance' => $this->naira_formatter($re['admin_bal']),
                        'date' => date('Y-M-D H:i:s', strtotime($re['create_date'])),

                    );
                endforeach;


            }

        }catch (\Exception $e){
            throw new Exception($e->getMessage());
        }
        $return = array(
            "draw" => !empty ($draw) ? intval($draw) : 0,
            'recordsTotal' =>!empty( $recordTotal)?$recordTotal:0,
            'recordsFiltered' => !empty($filter)?$filter:0,
            'data' => !empty($data)?$data:"",
        );
        echo  json_encode($return);
    }

    function get_salary_amount(){

        $col = isset($_SESSION["staff"])?"where staff_id = ?":"";
        $id = $_SESSION["id"];
      $q = $this->dblink()->prepare("select SUM(salary_amount) as total_salary from salary_log $col");
      if (isset($_SESSION["staff"])){
      $q->bind_param("i", $id);
          }
      $q->execute();
      return $q->get_result()->fetch_object();
    }function get_salary(){

        $col = isset($_SESSION["staff"])?"where staff_id = ?":"";
        $id = $_SESSION["id"];
      $q = $this->dblink()->prepare("select *  from salary_log $col");
      if (isset($_SESSION["staff"])){
      $q->bind_param("i", $id);
          }
      $q->execute();
      return $q->get_result();
    }
    
    function get_account_info(){
        $role = isset($_SESSION["staff"])?2:1;
        $id = $_SESSION["id"];
        $q = $this->dblink()->prepare("select *  from users where role = ? and id = ? ");
        $q->bind_param("ii",$role, $id);
        $q->execute();
        return $q->get_result()->fetch_object();
    }
}