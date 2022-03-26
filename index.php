<?php

require_once("vendor/autoload.php");

use mcdavidsh\controllers\router;
$request = $_SERVER['REQUEST_URI'];
$route = json_decode((new router())->route());
$temp = new mcdavidsh\controllers\template\template();

if (!in_array($request, $route->auth_exceptions)){
    $temp->check_session();
}else {
    $temp->is_session();
}
    ?>
<!DOCTYPE html>
<html lang="en">

<?php $temp->head(); ?>

<body>
    <div id="app">

        <?php
        if (!in_array($request, $route->auth_exceptions)) {
            $temp->menu();
        }?>
        <div  id="<?php if (in_array($request, $route->auth_exceptions)) echo "auth"; else echo "main" ?>">
            <?php
            if (!in_array($request, $route->auth_exceptions)) :
             ?>
            <header class="mb-3">
                <a href="javascript:void(0)" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <?php
            endif;
            $temp->page_heading();

            switch ($request):
                case "/":
                case "":
                    require_once ($route->home->dir);
                    break;
                    case $route->profile->route:
                    require_once ($route->profile->dir);
                    break;
                    case $route->security->route:
                    require_once ($route->security->dir);
                    break;
                case $route->login->route:
                    require_once ($route->login->dir);
                    break; case $route->forgot_pass->route:
                    require_once ($route->forgot_pass->dir);
                    break;
                    case $route->staff->route:
                    require_once ($route->staff->dir);
                    break;
                case $route->admin->route:
                    require_once ($route->admin->dir);
                    break; case $route->salary_log->route:
                    require_once ($route->salary_log->dir);
                    break;
                default: http_response_code(400);
                    require_once($route->error->dir);
            endswitch;
            ?>

     <?php $temp->footer() ?>
        </div>
    </div>
<?php $temp->scripts() ?>
</body>

</html>