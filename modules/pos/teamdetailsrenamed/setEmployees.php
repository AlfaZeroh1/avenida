<?php
session_start();
$shop = $_SESSION['shpemployees'];

$obj = (object)$_POST;
if($obj->checked=="true"){
  $i = searchForId($obj->id,$shop);
  $shop[$i]['employeeid']=$obj->id;
  $shop[$i]['teamdetailid']=$obj->teamdetailid;
  $shop[$i]['amount']=$obj->amount;
}else{
  $key = searchForId($obj->id,$shop); 
  $shop1=array_slice($shop,0,$key);
  $shop2=array_slice($shop,$key+1);
  
  $shop = array_merge($shop1,$shop2);
}

$_SESSION['shpemployees']=$shop;

function searchForId($id, $array) {
   foreach ($array as $key => $val) {
       if ($val['employeeid'] === $id) {
           return $key;
       }
   }
   return count($array);
}
?>