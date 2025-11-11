<?php
session_start();
require_once("../../../DB.php");

$db = new DB();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shpinwards'];
if($obj->field=="discount"){
  $shop[$i]['discount']=$obj->val;
  $shop[$i]['discountamount']=$shop[$i]['quantity']*$shop[$i]['costprice']*($obj->val/100);
}else{
  $shop[$i]['memo']=$obj->val;
}
$_SESSION['shpinwards']=$shop;print_r($shop);

?>