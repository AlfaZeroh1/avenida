<?php
session_start();
require_once("../../../lib.php");
require_once("../../../DB.php");

$db = new DB();

$shop = $_SESSION['estimations'];
$ob = (object)$_POST;

$id = searchForId2($ob->estimationid,$shop,"estimationid");echo $id;

$shop[$id]['estimationid']=$ob->estimationid;
$shop[$id]['quantity']=$ob->quantity;

$_SESSION['estimations']=$shop;
print_r($shop);
?>
