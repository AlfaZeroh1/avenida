<?php
session_start();
require_once("../../../lib.php");

$shop = $_SESSION['shptransfers'];

$obj = (object)$_GET;

$shop[$obj->id]["'".$obj->quantityrec."'"]=$obj->value;

$_SESSION['shptransfers']=$shop;

?>
