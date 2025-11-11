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
    
    if(!checkQuantity($obj)){
    
	$error="Not enough stock under the section";
	echo "7|$error|".$shporders[$it]['quantity']."|$obj->quantity";
    
    }else{
    
      
      
      //logging("ID# ".$it."==".$obj->itemid."==".$obj->warmth);
      
      //get old totals
      $olditemtotal = $shporders[$it]['quantity']*$shporders[$it]['price'];
      $newtotal = $obj->quantity*$shporders[$it]['price'];
      
      $shporders[$it]['quantity']=$obj->quantity;
      
      echo $olditemtotal."|".$newtotal;
    
    }
  }
}else{
  $i = $obj->itemid;
//   logging("ID# ".$i);
//   logging(serialize($_SESSION['shporders']));
  $shporders = $_SESSION['shporders'];//logging(serialize($shporders));
  if(empty($obj->warmth))
    $obj->warmth="";
  
  $i = searchForId($obj->itemid,$shporders,"itemid",$obj->warmth);
  
//   $i--;
//   logging("#################################");
  
//   logging(serialize($shporders));
  
//   logging("DEL ID# ".$i."==".$obj->itemid."==".$obj->warmth."========".count($shporders));
   
  
  $olditemtotal = $shporders[$i]['quantity']*$shporders[$i]['price'];
  $newtotal = 0;
  
//   logging("#################################");
  
  
  $shporders1=array_slice($shporders,0,$i);
  $shporders2=array_slice($shporders,$i+1);
  $shporders=array_merge($shporders1,$shporders2);
//   logging(serialize($shporders));
  echo $olditemtotal."|".$newtotal;

}

$_SESSION['shporders']=$shporders;


function checkQuantity($obj){
   
   $warmth="''";
   $qnt = $obj->quantity;
   
  $query="select * from inv_items where id='$obj->itemid'";
  $r = mysql_fetch_object(mysql_query($query)); 
  
  if($obj->brancheid2!=27 and $obj->brancheid2!=28)
    return true;

  //check if the product is one of the composites
  $query="select * from inv_compositeitems where itemid='$obj->itemid' or itemid2='$obj->itemid'";//logging($query);
  $res = mysql_query($query);
  
  $quantity=0;
  $quantity1=0;
  
  $shporders = $_SESSION['shporders']; 
  
  if(mysql_affected_rows()>0){
    while($row=mysql_fetch_object($res)){

      $it = searchForId3($row->itemid,$shporders,"itemid");
  
      $quantity1+=$shporders[$it]['quantity'];
      
      $it = searchForId3($row->itemid2,$shporders,"itemid");
  
      $quantity1+=$shporders[$it]['quantity']/$row->quantity;
      
      $query="select * from inv_branchstocks where brancheid='$obj->brancheid2' and itemid='$row->itemid'";
      $r1 = mysql_fetch_object(mysql_query($query));      
    
      $query="select * from inv_branchstocks where brancheid='$obj->brancheid2' and itemid='$row->itemid2'";
      $r2 = mysql_fetch_object(mysql_query($query));
      if(($row->itemid==$obj->itemid)){
	$quantity+=$r2->quantity/$row->quantity;
	$quantity+=$r1->quantity;
      }  
      if(($row->itemid2==$obj->itemid)){
	$quantity+=$r1->quantity;
	$quantity+=$r2->quantity/$row->quantity;
	
// 	$quantity1 = $quantity1*$row->quantity;
	$qnt = $qnt/$row->quantity;
	
      }
    }
    
  }else{
  
   $it = searchForId3($obj->itemid,$shporders,"itemid");
    $quantity1+=$shporders[$it]['quantity'];
  
    $query="select * from inv_branchstocks where brancheid='$obj->brancheid2' and itemid='$obj->itemid'";
    $r = mysql_fetch_object(mysql_query($query));
    $quantity=$r->quantity;
  
 }
//  logging("QNT: ITM1: $row->itemid = ITM2:$row->itemid2 = Consumed: ".$quantity1." == Available: ".$quantity." == qnt: ".$qnt);
  if(($quantity-$quantity1)<$qnt)
    return false;
  else
    return true;

}

?>
