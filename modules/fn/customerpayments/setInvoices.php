<?php
session_start();

$obj = (object)$_GET;//print_r($obj);
$shop = $_SESSION['shpinvoices'];

$i = count($shop);

if($obj->checked=="true"){

  $diff = ($obj->invrate-$obj->rate)*$obj->amount;;
  
  $shop[$i]['invoiceno']=$obj->invoiceno;
  $shop[$i]['amount']=$obj->amount;
  $shop[$i]['diff']=$diff;
  $shop[$i]['rate']=$obj->invrate;
  $shop[$i]['id']=$obj->id;
}
else{
  $key = searchForId($obj->invoiceno,$shop,true); 
  $shop1=array_slice($shop,0,$key);
  $shop2=array_slice($shop,$key+1);
  $shop = array_merge($shop1,$shop2);
}

function searchForId($id, $array,$bool=false) {
   foreach ($array as $key => $val) {
       if ($val['id'] === $id) {
           return $key;
       }
   }
   if($bool)
    return count($array);
   else
    return -1;
}

$_SESSION['shpinvoices']=$shop;

?>