<?php
session_start();
ob_start();
require_once('vendor/autoload.php');
require_once('../_PHPMailer/src/Exception.php');
require_once('../_PHPMailer/src/PHPMailer.php');
require_once('../_PHPMailer/src/SMTP.php');
require_once('function_main.php');
// require_once('user.php');
// require_once('function.php');
require_once('function_custom.php');
require_once('converttime.php');







// require_once '../../include/PHPMailer/src/Exception.php';
// require_once '../../include/PHPMailer/src/PHPMailer.php';
// require_once '../../include/PHPMailer/src/SMTP.php';


// use \Slim\App;
// $app = new App();
// \Slim\Slim::registerAutoloader();
// $app = new \Slim\Slim();
$app = new \Slim\Slim();



$app->get("/", function () {
  echo "API WEB PLANNEDPRO CREATIVE SOLUTIONS";
});
$app->post("/", function () {
  echo "API WEB PLANNEDPRO CREATIVE SOLUTIONS";
});

$app->notFound(function () use ($app) {
  echo "NOT FOUND 404";
});

$app->group('/company', function () use ($app) {
  $app->get('/add', function () {
    echo "add";
  });
  $app->get('/create', function ($request, $response) {
    echo "create";
  });
});


$app->group('/get', function () use ($app) {
  $app->post("/dashboard", function () use ($app) {
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json, true);
    $type = checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI = checkTextSQLv2($data["data"]);
    $result = getDashboard($type, $dataAPI, $dataoption);
    echo json_encode($result);
  });

  $app->post("/formrequest", function () use ($app) {
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json, true);
    $type = checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI = checkTextSQLv2($data["data"]);
    $result = getformrequest($type, $dataAPI, $dataoption);
    echo json_encode($result);
  });
  $app->post("/employee", function () use ($app) {
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json, true);
    $type = checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI = checkTextSQLv2($data["data"]);
    $result = getemployee($type, $dataAPI, $dataoption);
    echo json_encode($result);
  });
  $app->post("/work", function () use ($app) {
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json, true);
    $type = checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI = checkTextSQLv2($data["data"]);
    $result = GetWork($type, $dataAPI, $dataoption);
    echo json_encode($result);
  });
  $app->post("/Test", function () use ($app) {
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json, true);
    $type = checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI = checkTextSQLv2($data["data"]);
    $result = GetTest($type, $dataAPI, $dataoption);
    echo json_encode($result);
  });
  $app->post("/EmployeeRequest", function () use ($app) {
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json, true);
    $type = checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI = checkTextSQLv2($data["data"]);
    $result = GetEmployeeRequest($type, $dataAPI, $dataoption);
    echo json_encode($result);
  });
  $app->post("/BtnApp_Rej", function () use ($app) {
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json, true);
    $type = checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI = checkTextSQLv2($data["data"]);
    $result = GetBtnApp_Rej($type, $dataAPI, $dataoption);
    echo json_encode($result);
  });
  $app->post("/DetailRequest", function () use ($app) {
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json, true);
    $type = checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI = checkTextSQLv2($data["data"]);
    $result = GetDetailRequest($type, $dataAPI, $dataoption);
    echo json_encode($result);
  });
});

















$app->run();





function checkTextSQL($data)
{
  // $data = str_replace("'","",$data);
  // $data = str_replace("?","",$data);
  // $data = str_replace("=","",$data);
  // $data = str_replace("%","",$data);
  // $data = str_replace("'","",$data);
  // $data = str_replace("?","",$data);
  // $data = str_replace("=","",$data);
  // $data = str_replace("%","",$data);
  return $data;
}
function checkTextSQLv2($data)
{
  // $data = str_replace("'","",$data);
  // $data = str_replace("?","",$data);
  // $data = str_replace("=","",$data);
  // $data = str_replace("%","",$data);
  // $data = str_replace("'","",$data);
  // $data = str_replace("?","",$data);
  // $data = str_replace("=","",$data);
  // $data = str_replace("%","",$data);
  return $data;
}

function checkTextSQLv3($data)
{
  $data = str_replace("'", "", $data);
  $data = str_replace("?", "", $data);
  $data = str_replace(";", "", $data);
  $data = str_replace("%", "", $data);
  $data = str_replace("</", "<\/", $data);


  return $data;
}
