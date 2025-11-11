<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

$db = new DB();

$shop = $_SESSION['shptransfers'];

$obj = (object)$_GET;

if($obj->type=="codes"){
  $shop[$obj->id]["'".$obj->code."'"]=$obj->value;
  
}

if($obj->type=="serialno"){
  $query="select * from inv_itemdetails where id='$obj->itemdetailid'";
  $res=mysql_query($query);
  $itm = mysql_fetch_object($res);
  
  if($itm->version==2){
    $ver = mysql_fetch_object(mysql_query("select inv_creditcodes.id,inv_creditcodes.code,inv_creditcodedetails.code as creditcode from inv_creditcodes left join inv_creditcodedetails on inv_creditcodes.id=inv_creditcodedetails.creditcodeid where (inv_creditcodes.status='unused' or inv_creditcodes.id='$itm->instalcode') and inv_creditcodedetails.codeno=1"));
  }
  $shop[$obj->id]['itemdetailid']=$obj->itemdetailid;
  $shop[$obj->id]['serialno']=$obj->serialno;
  $shop[$obj->id]['version']=$itm->version;
  $shop[$obj->id]['instalcode']=$itm->instalcode;
  
  if($itm->version==1)
    echo $itm->version."-".$itm->instalcode;
  else
    echo $itm->version."-".$ver->code.'=>'.$ver->creditcode;
}

$_SESSION['shptransfers']=$shop;

?>

