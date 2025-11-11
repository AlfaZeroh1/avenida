<?php
session_start();
require_once("../../../lib.php");

$shop = $_SESSION['shppurchaseorder'];
$it = count($shop);logging($it);
$obj = (object)$_POST;

if($obj->action=="Add"){
  array_push($shop, $obj->documentno);
}
elseif($obj->action=="Remove"){
  
 $key=array_search($obj->documentno, $shop);
 unset($shop[$key]);
  
}


$_SESSION['shppurchaseorder']=$shop;

?>