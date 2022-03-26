<?php
namespace mcdavidsh\controllers\template;
use mcdavidsh\controllers\controllers;
use mcdavidsh\controllers\router;

class template extends controllers
{

    function head(){
        $route = json_decode((new router())->route());
        $request = $_SERVER["REQUEST_URI"];
        $title = str_replace("/","", $request);
        ?>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <?php

            switch ($request):
            case $route->home->route:
            ?>

            <title><?php echo $this->app_info()->app_name ?> | <?php echo $this->app_info()->app_tagline ?></title>
            <meta name="title" content="<?php echo $this->app_info()->app_name ?> | <?php echo $this->app_info()->app_tagline ?>">
            <meta name="description" content="<?php echo $this->app_info()->app_tagline ?>">
            <meta property="og:type" content="website">
            <meta property="og:url" content="<?php echo $this->app_info()->app_domain ?>">
            <meta property="og:title" content="<?php echo $this->app_info()->app_name ?> | <?php echo $this->app_info()->app_tagline ?>">
            <meta property="og:description" content="<?php echo $this->app_info()->app_tagline ?>">

            <!-- Twitter -->
            <meta property="twitter:card" content="summary_large_image">
            <meta property="twitter:url" content="<?php echo $this->app_info()->app_domain ?>">
            <meta property="twitter:title" content="<?php echo $this->app_info()->app_name ?> | <?php echo $this->app_info()->app_tagline ?>">
            <meta property="twitter:description" content="<?php echo $this->app_info()->app_tagline ?>">
            <?php break;
            case $route->profile->route:
                ?>
            <title> <?php echo basename(ucwords($title)) ?> | <?php echo $this->app_info()->app_name ?> </title>

            <?php break;
            case $route->login->route:
                ?>
            <title> <?php echo basename(ucwords($title)) ?> | <?php echo $this->app_info()->app_name ?> </title>
            <?php

                case $route->staff->route:
                ?>
            <title> <?php echo str_replace("-"," ",basename(ucwords($title))) ?> | <?php echo $this->app_info()->app_name ?> </title>

            <?php
                break;
                case $route->admin->route:
                ?>
            <title> <?php echo str_replace("-"," ",basename(ucwords($title))) ?> | <?php echo $this->app_info()->app_name ?> </title>

            <?php
                break;
                case $route->salary_log->route:
                ?>
            <title> <?php echo str_replace("-"," ",basename(ucwords($title))) ?> | <?php echo $this->app_info()->app_name ?> </title>

            <?php
                break;
                case $route->security->route:
                ?>
            <title> <?php echo str_replace("-"," ",basename(ucwords($request))) ?> | <?php echo $this->app_info()->app_name ?> </title>
                    <?php
                    break;
                    case $route->forgot_pass->route:
                    ?>
                    <title> <?php echo str_replace("-"," ",basename(ucwords($request))) ?> | <?php echo $this->app_info()->app_name ?> </title>
            <?php
                break;
            default:
                ?>
            <title><?php echo $this->app_info()->app_name ?> | <?php echo $this->app_info()->app_tagline ?></title>
            <?php

                break;
        endswitch; ?>

            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link rel="stylesheet" href="<?php echo $this->assets() ?>css/google-fonts.css">
            <link rel="stylesheet" href="<?php echo $this->assets() ?>css/bootstrap.css">

            <link rel="stylesheet" href="<?php echo $this->assets() ?>vendors/perfect-scrollbar/perfect-scrollbar.css">
            <link rel="stylesheet" href="<?php echo $this->assets() ?>vendors/bootstrap-icons/bootstrap-icons.css">
            <link rel="stylesheet" href="<?php echo $this->assets() ?>css/app.css">
            <link rel="stylesheet" href="<?php echo $this->assets() ?>css/pages/error.css">
            <link rel="stylesheet" href="<?php echo $this->assets() ?>vendors/toastify/toastify.css">
            <?php if (in_array($_SERVER["REQUEST_URI"], $route->auth_exceptions)): ?>
            <link rel="stylesheet" href="<?php echo $this->assets() ?>css/pages/auth.css">
            <?php endif; ?>
        <?php if ($request ===  $route->staff->route || $request ===  $route->admin->route|| $request ===  $route->salary_log->route): ?>
            <link rel="stylesheet" href="<?php echo $this->assets() ?>vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css">
            <link rel="stylesheet" href="<?php echo $this->assets() ?>vendors/fontawesome/all.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo $this->assets()?>vendors/jquery-datatables/responsive.bootstrap5.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo $this->assets()?>vendors/jquery-datatables/responsive.dataTables.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo $this->assets()?>vendors/jquery-datatables/select.dataTables.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo $this->assets()?>vendors/jquery-datatables/buttons.bootstrap5.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo $this->assets()?>vendors/jquery-datatables/rowGroup.bootstrap4.min.css">

        <?php endif; ?>


        </head>
        <?php
    }
    function menu(){
        ?>
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="/"><?php echo $this->app_info()->app_name ?></a>
                        </div>
                        <div class="toggler">
                            <a href="javascript:void(0)" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li
                            class="sidebar-item <?php $this->active_nav("/"); ?> ">
                            <a href="/" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Home</span>
                            </a></li>
                        <li
                            class="sidebar-item <?php $this->active_nav("/profile"); ?> ">
                            <a href="/profile" class='sidebar-link'>
                                <i class="bi bi-person-fill"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <?php
                        if (isset($_SESSION["admin"])):
                        ?>
                            <li
                                    class="sidebar-item  has-sub <?php $this->active_nav(array("/manage-staff","/manage-admin" )); ?>">
                                <a href="javascript:void(0)" class='sidebar-link'>
                                    <i class="bi bi-people-fill"></i>
                                    <span>Account</span>
                                </a>
                                <ul class="submenu <?php $this->active_nav(array("/manage-staff","/manage-admin" )); ?> ">
                                    <li class="submenu-item <?php $this->active_nav("/manage-staff"); ?> ">
                                        <a href="/manage-staff">Manage Staff</a>
                                    </li>
                                    <li class="submenu-item <?php $this->active_nav("/manage-admin"); ?>">
                                        <a href="/manage-admin">Manage Admin</a>
                                    </li> <li class="submenu-item <?php $this->active_nav("/salary-log"); ?>">
                                        <a href="/salary-log">Salary log</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="sidebar-item <?php $this->active_nav("/security"); ?> ">
                            <a href="/security" class='sidebar-link'>
                                <i class="bi bi-shield-fill"></i>
                                <span>Security</span>
                            </a>
                        </li>

                        <li
                                class="sidebar-item ">
                            <a href="javascript:void(0)" id="logout" class='sidebar-link'>
                                <i class="bi bi-power"></i>
                                <span>Logout</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <?php
    }
    function page_heading()
    {
        $request = $_SERVER["REQUEST_URI"];
        $route = json_decode((new router())->route());
        if ($request !== $route->home->route && $request !== $route->login->route && $request !== $route->forgot_pass->route ):
       ?>
            <div class="page-heading">

                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3><?php
                                echo ucwords(str_replace("-"," ", $this->page_title())); ?></h3>
                            <p class="text-subtitle text-muted">Manage <?php
                                echo ucwords(str_replace("-"," ", $this->page_title())); ?> Information.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php
                                        echo ucwords(str_replace("-"," ", $this->page_title())); ?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endif;

    }


    function footer(){
        $request = $_SERVER["REQUEST_URI"];
        $route = json_decode((new router())->route());
        if ($request !== $route->login->route && $request !== $route->forgot_pass->route && $request !== $route->home->route ):
        ?>
        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p><?php echo date("Y")?> &copy; <?php echo $this->app_info()->app_name ?> Powered by <a href="https://github.com/mcdavidsh" target="_blank">David</a></p>
                </div>
                <div class="float-end d-flex align-items-baseline">
                    <p>Template Credits <a
                            href="http://ahmadsaugi.com">A. Saugi</a></p>
                </div>
            </div>
        </footer>
            <?php
        endif;

        }
    function scripts(){
        $route = json_decode((new router())->route());
        $request = $_SERVER["REQUEST_URI"];
        ?>
        <script src="<?php echo $this->assets() ?>vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="<?php echo $this->assets() ?>js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo $this->assets() ?>vendors/toastify/toastify.js"></script>
        <script src="<?php echo $this->assets() ?>js/mazer.js"></script>

        <?php if ($request ===  $route->staff->route || $request ===  $route->admin->route|| $request ===  $route->salary_log->route): ?>
        <script src="<?php echo $this->assets() ?>vendors/jquery/jquery.min.js"></script>
        <script src="<?php echo $this->assets() ?>vendors/jquery-datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo $this->assets() ?>vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js"></script>
            <script src="<?php echo $this->assets()?>vendors/jquery-datatables/responsive.bootstrap5.min.js"></script>
            <script src="<?php echo $this->assets()?>vendors/jquery-datatables/responsive.dataTables.min.js"></script>

        <script src="<?php echo $this->assets() ?>vendors/fontawesome/all.min.js"></script>
        <?php endif; ?>

        <script src="<?php echo $this->app_info()->app_domain ?>core/controllers/util.min.js"></script>
        <script src="<?php echo $this->app_info()->app_domain ?>core/controllers/controllers.min.js"></script>
<?php
    }

    function modal(){
        ?>
        <div class="modal fade text-left" id="create-account-modal" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                 role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Create Account </h4>
                        <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form id="create_account_form">
                        <div class="modal-body">
                            <label>First Name: </label>
                            <div class="form-group">
                                <input type="text" name="fname" placeholder="First Name"
                                       class="form-control">
                            </div>
                            <label>First Name: </label>
                            <div class="form-group">
                                <input type="text" name="lname" placeholder="Last Name"
                                       class="form-control">
                            </div>
                            <label>Email: </label>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email Address"
                                       class="form-control">
                            </div>
                            <label>Password: </label>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password"
                                       class="form-control input_password">
                            </div>
                            <div class="form-check form-check-lg d-flex align-items-end">
                                <input class="form-check-input me-2 " type="checkbox"  id="view_password">
                                <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                    Show Password
                                </label>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary"
                                    data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button class="btn btn-primary ml-1" type="button" id="create_account_button">
                                <span class="d-none spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="account-info-modal" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog "
                 role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="info-title"></h4>
                        <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form id="account_info_form">
                        <div class="modal-body">
                            <input name="id" hidden>
                            <label>Status: </label>
                            <div class="form-group">
                                <select name="status" class="form-control form-select">
                                    <option value="">Select Status</option>
                                    <option value="1">Enable Account</option>
                                    <option value="0">Disable Account</option>
                                </select>
                            </div>
                            <label>First Name: </label>
                            <div class="form-group">
                                <input type="text" name="fname" placeholder="First Name"
                                       class="form-control">
                            </div>
                            <label>Last Name: </label>
                            <div class="form-group">
                                <input type="text" name="lname" placeholder="Last Name"
                                       class="form-control">
                            </div> <label>Phone: </label>
                            <div class="form-group">
                                <input type="tel" name="phone" placeholder="Phone"
                                       class="form-control">
                            </div>
                            <label>Wallet Balance: </label>
                            <div class="form-group">
                                <input type="tel" name="wallet" onfocus="convert_input_to_currency(this)" placeholder="wallet"
                                       class="form-control">
                            </div>
                            <label>Email: </label>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email Address"
                                       class="form-control">
                            </div>

                            <label>Password: </label>
                            <div class="form-group">
                                <textarea type="text" placeholder="Address" name="address"
                                          class="form-control " rows="4"></textarea>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary"
                                    data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button class="btn btn-primary ml-1" type="button" id="update_account_button">
                                <span class="d-none spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                               Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="account-salary-modal" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog "
                 role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="info-title"></h4>
                        <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form id="account_salary_form">
                        <div class="modal-body">
                            <label>Salary Amount: </label>
                            <div class="form-group">
                                <input type="tel" name="salary" onfocus="convert_input_to_currency(this)" placeholder="Salary"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary"
                                    data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button class="btn btn-primary ml-1" type="button" id="pay_salary_btn">
                                <span class="d-none spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                               Pay
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
    }
}