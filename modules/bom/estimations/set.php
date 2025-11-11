<?php
session_start();

$obj = (object)$_POST;

$shop = $_SESSION[$obj->type];

if($obj->checked=='true'){
  
  $i = searchForId($obj->id,$shop);
  $shop[$i]['estimationid']=$obj->estimationid;
  $shop[$i]['quantity']=$obj->quantity;
  
}else{
  
  $key = searchForId($obj->id,$shop); 
  $shop1=array_slice($shop,0,$key);
  $shop2=array_slice($shop,$key+1);
  
  $shop = array_merge($shop1,$shop2);
  
}

$_SESSION[$obj->type] = $shop;

function searchForId($id, $array) {
   
   foreach ($array as $key => $val) {
       if ($val['estimationid'] === $id) {
           return $key;
       }
   }
   return count($array);
   
}

?>
