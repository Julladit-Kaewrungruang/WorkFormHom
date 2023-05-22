<!DOCTYPE html>
<html lang="en">
<?php 

use Steampixel\Route;

include 'include/Steampixel/Route.php';
date_default_timezone_set("Asia/Bangkok");
// require_once('include/php/connect.php');
// require_once('include/php/function_main.php');
// print_r($_SESSION);
define('BASEPATH', '/admin_page/');

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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?= BASEPATH ?>include/css/sb-admin-2.css" />
    <link rel="stylesheet" href="<?= BASEPATH ?>include/css/sb-admin-2.css" />
 

    <script>
        $(window).ready(()=> {
            setPathURL_T('<?=BASEPATH?>');
        });
    </script>
</head>


<body>


    <?php
    include("include/page/sidebar.php");
    include("include/page/navbar.php");
    ?>


    <?php
    Route::add('/home', function () {
        include("include/page/home/main.php");
    });
    Route::add('/report', function () {
        include("include/page/home/main.php");
    });

    Route::pathNotFound(function ($path) {
        echo 'Error 404 :-(<br>';
    });

    Route::methodNotAllowed(function ($path, $method) {
        echo 'Error 405 :-(<br>';
        echo 'The requested path "' . $path . '" exists. But the request method "' . $method . '" is not allowed on this path!';
    });


    Route::run(BASEPATH);


    ?>



    <script src="<?= BASEPATH ?>include/js/script.js"></script>
</body>

</html>