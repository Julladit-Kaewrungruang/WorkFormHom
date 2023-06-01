<!DOCTYPE html>
<html lang="en">
<?php
ob_start();
session_start();

use Steampixel\Route;

require('./include/php/function-index.php');


isset($_COOKIE['emp']) ?  $_SESSION["emp"] = $_COOKIE['emp'] : null;
isset($_COOKIE['emp_token']) ?  $_SESSION["emp_token"] = $_COOKIE['emp_token'] : null;
isset($_COOKIE['emp_wfm_token']) ?  $_SESSION["emp_wfm_token"] = $_COOKIE['emp_wfm_token'] : null;
isset($_COOKIE['emp_fname']) ?  $_SESSION["emp_fname"] = $_COOKIE['emp_fname'] : null;
isset($_COOKIE['emp_email']) ?  $_SESSION["emp_email"] = $_COOKIE['emp_email'] : null;

isset($_SESSION["emp_token"]) ? setcookie('emp_token', $_SESSION["emp_token"], time() + (86400 * 30), "/") : null;
isset($_SESSION["emp_fname"]) ? setcookie('emp_fname', $_SESSION["emp_fname"], time() + (86400 * 30), "/") : null;
isset($_SESSION["emp_email"]) ? setcookie('emp_email', $_SESSION["emp_email"], time() + (86400 * 30), "/") : null;
isset($_SESSION["emp_wfm_token"]) ? setcookie('emp_wfm_token', $_SESSION["emp_wfm_token"], time() + (86400 * 30), "/") : null;




$datalogin = checklogin();
include 'include/Steampixel/Route.php';
date_default_timezone_set("Asia/Bangkok");
define('BASEPATH', '/');



// print_r($_SESSION);

?>


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1,
      shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Productive Anywhere</title>

    <!-- Custom fonts for this template-->
    <!-- <link
      href="vendor/fontawesome-free/css/all.min.css"
      rel="stylesheet"
      type="text/css"
    /> -->
    <link href="<?= BASEPATH ?>include/css/semantic.css" rel="stylesheet" />

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js?v=1.3"></script>
    <script src="https://kit.fontawesome.com/64d58efce2.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.js"></script>





    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />


    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> -->

    <!-- Latest compiled and minified JavaScript -->

    <script type="text/javascript" src="<?= BASEPATH ?>include/bootstrap-select-1.13.15/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="<?= BASEPATH ?>include/bootstrap-select-1.13.15/js/i18n/defaults-th_TH.min.js"></script>
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script> -->


    <script src="<?= BASEPATH ?>include/js/config.js"></script>
    <script type="text/javascript" src="<?= BASEPATH ?>include/js/apexcharts.js"></script>
    <script type="text/javascript" src="<?= BASEPATH ?>include/js/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="<?= BASEPATH ?>include/js/moment-timezone.js"></script>
    <script type="text/javascript" src="<?= BASEPATH ?>include/js/main_.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> -->
    <script src='fullcalendar/dist/index.global.js'></script>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />




    <!-- Custom styles for this template-->
    <link href="<?= BASEPATH ?>include/css/sb-admin-2.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?= BASEPATH ?>include/css/style.css" />
    <link rel="stylesheet" href="<?= BASEPATH ?>include/bootstrap-select-1.13.15/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="<?= BASEPATH ?>include/css/custom.css" />
    <link rel="stylesheet" href="<?= BASEPATH ?>include/css/datepicker.css" />
    <script type="text/javascript" src="<?= BASEPATH ?>include/js/custom.js"></script>

    <!-- Updated tui.Calendar CSS -->
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />

    <!-- Updated tui.Calendar JavaScript -->
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.ie11.min.js"></script>
    <script type="text/javascript">
    $(window).ready(() => {
        // getdataHeadDetailReq()
       

        setPathURL_T('<?= BASEPATH ?>')
      
    });

</script>
</head>

<body id="page-top">




    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include_once('include/page/menu.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php

                include_once('include/page/navbar.php');

                Route::add('/', function () {
                    include('include/page/home/main.php');
                });
                Route::add('/home', function () {
                    include('include/page/home/main.php');
                    // include('include/page/home/main.php');
                });
                Route::add('/home/todo', function () {
                    include('include/page/home/main.php');
                    // include('include/page/home/main.php');
                });


                Route::add('/addwork', function () {
                    include('include/page/addwork/main.php');
                    // include('include/page/addwork/main.php');
                });

                Route::add('/Calendar', function () {
                    include('include/page/calendar/main.php');
                    // include('include/page/Request/main.php');
                });

                Route::add('/RequestWFH', function () {
                    include('include/page/Request/main.php');

                    // include('include/page/Request/main.php');
                });

                Route::add('/HistoryRequest', function () {
                    include('include/page/HistoryRequest/main.php');
                    // include('include/page/home/main.php');
                });

                Route::add('/HistoryRequest2/(.*)', function ($token) {
                    include('include/page/HistoryRequest/main2.php');
                    // include('include/page/home/main.php');
                });

                Route::add('/EmployeeRequest', function () {
                    include('include/page/EmployeeRequest/main.php');
                    // include('include/page/home/main.php');
                });
                Route::add('/Myteam', function () {
                    include('include/page/Myteam/main.php');
                    // include('include/page/home/main.php');
                });
                Route::add('/EmployeeHr', function () {
                    include('include/page/Employee/main.php');
                    // include('include/page/home/main.php');
                });
                Route::add('/Myteam2', function () {
                    include('include/page/Myteam/main2.php');
                    // include('include/page/home/main.php');
                });
                Route::add('/Approve/(.*)', function ($token) {
                    include('include/page/EmployeeRequest/main2.php');
                    // include('include/page/home/main.php');
                });

                // Route::add('/EmployeeRequest1/(.*)/(.*)', function ($action,$token) {
                 
                //     include('include/page/EmployeeRequest/main2.php');
                //     // include('include/page/home/main.php');
                // });

                Route::add('/EmployeeRequest1/(.*)/(.*)', function($token,$customer) {
                    // include_once("include/page/survey.php");
                    include('include/page/EmployeeRequest/main2.php');
                });

                Route::add('/EmployeeRequest2/(.*)', function ($token) {
                    $action1 = '';
                    include('include/page/EmployeeRequest/main2.php');
                    // include('include/page/home/main.php');
                });


                Route::pathNotFound(function ($path) {
                    include('include/page/error404.php');
                });

                Route::methodNotAllowed(function ($path, $method) {
                    echo 'Error 405 :-(<br>';
                    echo 'The requested path "' . $path . '" exists. But the request method "' . $method . '" is not allowed on this path!';
                });

                Route::run(BASEPATH);
                ?>


            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <script src="<?= BASEPATH ?>include/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= BASEPATH ?>include/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= BASEPATH ?>include/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <!-- <script src="<?= BASEPATH ?>include/chart.js/Chart.min.js"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="<?= BASEPATH ?>include/js/demo/chart-area-demo.js"></script> -->

</body>

</html>