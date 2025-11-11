<?php
session_start();
require_once("../../../lib.php");

$shop = $_SESSION['shpgeneraljournal'];
$it = count($shop);
$obj = (object)$_POST;

if($obj->action=="Add"){
  $shop[$obj->id]=$obj->debit-$obj->amount;
}
elseif($obj->action=="Remove"){
  
  unset($shop[$obj->id]);  
  
}

$_SESSION['shpgeneraljournal']=$shop;
logging(json_encode($shop));
?>