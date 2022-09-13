<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
$uriData = explode("/",$_SERVER["REQUEST_URI"]);
$http =  $_SERVER['REQUEST_METHOD'];
$data= file_get_contents('php://input');
require __DIR__ . '/Controller/App.php';
use controller\route\App;
$arr=json_decode($data,true);
$app = App::getInstance($uriData,$http,$data);
$app->run();
