<?php
session_start();
require_once("../../../DB.php");

$db = new DB();

//get sales

$array = array();

$array[0]['id']=1;
$array[0]['title']="Sales";
$array[0]['amount']=20000;
$array[0]['link']="1";
$array[0]['color']="#5cb85c;";

$array[1]['id']=1;
$array[1]['title']="Purchases";
$array[1]['amount']=5700;
$array[1]['link']="2";
$array[1]['color']="#bce8f1;";

echo json_encode($array);

?>
