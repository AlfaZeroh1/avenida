<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Pricings_class.php");
require_once("../pricingcreatedelete/Pricingcreatedelete_class.php");
require_once("../../auth/rules/Rules_class.php");

$obj=(object)$_POST;
$ob=(object)$_GET;

if(empty($ob->interface)){
  if(empty($_SESSION['userid'])){;
	  redirect("../../auth/users/login.php");
  }
}
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8295";//Edit
}
else{
	$auth->roleid="8295";//Add
}
$auth->levelid=$_SESSION['level'];
if(empty($ob->interface)){
  auth($auth);
}

//connect to db
$db=new DB();


if($ob->interface==2)
  $obj=$ob;
  
$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$pricings=new Pricings();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$pricings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$pricings=$pricings->setObject($obj);
		if($pricings->add($pricings)){
			$error=SUCCESS;
			if($obj->interface==2)
			  echo "SUCCESS";
			else
			  redirect("addpricings_proc.php?id=".$pricings->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$pricings=new Pricings();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$pricings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$pricings=$pricings->setObject($obj);
		if($pricings->edit($pricings)){
			$error=UPDATESUCCESS;
			redirect("addpricings_proc.php?id=".$pricings->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$pricings=new Pricings();
	$where=" where id=$id ";
	$fields="prices_pricings.id, prices_pricings.category, prices_pricings.item, prices_pricings.price, prices_pricings.quantity, prices_pricings.ipaddress, prices_pricings.createdby, prices_pricings.createdon, prices_pricings.lasteditedby, prices_pricings.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$pricings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$pricings->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Pricings ";

if($obj->interface!=2)
  include "addpricings.php";
?>