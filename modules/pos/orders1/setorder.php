<?php
session_start();

require_once("../../../lib.php");

$obj=(object)$_POST;

if(empty($obj->action)){
if(empty($obj->type)){
  $shpordernos=$_SESSION['shpordernos'];

  $num = count($shpordernos);

  if($obj->checked){
    $shpordernos[$num]=$obj->orderno;
  }

  $_SESSION['shpordernos']=$shpordernos;
}else{
  $shporders = $_SESSION['shporders'];
  if(empty($obj->warmth))
    $obj->warmth="";
    
  $it = searchForId($obj->itemid,$shporders,"itemid",$obj->warmth);
  
  //get old totals
  $olditemtotal = $shporders[$it]['quantity']*$shporders[$it]['price'];
  $newtotal = $obj->quantity*$shporders[$it]['price'];
  
  $shporders[$it]['quantity']=$obj->quantity;
  
  echo $olditemtotal."|".$newtotal;
  
  
}
}else{
  $i = $obj->itemid;
  
  $shporders = $_SESSION['shporders'];
  if(empty($obj->warmth))
    $obj->warmth="";
  
  $i = searchForId($obj->itemid,$shporders,"itemid",$obj->warmth);
//   logging("ID# ".$i);
//   logging(serialize($shporders));
  
  $olditemtotal = $shporders[$i]['quantity']*$shporders[$i]['price'];
  $newtotal = 0;
  
  $shporders1=array_slice($shporders,0,$i-1);
  $shporders2=array_slice($shporders,$i);
  $shporders=array_merge($shporders1,$shporders2);
  
  echo $olditemtotal."|".$newtotal;

}

$_SESSION['shporders']=$shporders;


?>
