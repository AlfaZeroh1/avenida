<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../creditcodes/Creditcodes_class.php");

$db = new DB();

$shop = $_SESSION['codes'];
$shptransfers=$_SESSION['shptransfers'];

$obj = (object)$_GET;

$i=0;
$err="";

$n=count($shptransfers);
while($i<$n)
{  
  if($shptransfers[$i]['instalcode']==$obj->id)
  {
    $err=1;
    break;
  }
  $i++;
}

if(empty($err))
{
  $shptransfers[$obj->i]['instalcode']=$obj->id;
  //get first credit codes
  $query="select * from inv_creditcodedetails where creditcodeid='$obj->id' and codeno=1";
  $row=mysql_fetch_object(mysql_query($query));
  $err=$row->code;
}

$_SESSION['codes']=$shop;
$_SESSION['shptransfers']=$shptransfers;
//unset($_SESSION['codes']);
//unset($_SESSION['shptransfers']);
//print_r($_SESSION['shptransfers']);
echo $err;
?>