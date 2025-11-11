<?php
session_start();
require_once("../../../lib.php");

$shop = $_SESSION['shpinward'];
$it = count($shop);
$obj = (object)$_POST;

if($obj->action=="Add"){
  array_push($shop, $obj->documentno);
}
elseif($obj->action=="Remove"){
  
 $key=array_search($obj->documentno, $shop);
 unset($shop[$key]);
  
}


$_SESSION['shpinward']=$shop;

?>