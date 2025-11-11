<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Prices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2174";//Edit
}
else{
	$auth->roleid="2172";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

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
	$prices=new Prices();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$prices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$prices=$prices->setObject($obj);
		if($prices->add($prices)){
			$error=SUCCESS;
			redirect("addprices_proc.php?id=".$prices->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$prices=new Prices();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$prices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$prices=$prices->setObject($obj);
		if($prices->edit($prices)){
			$error=UPDATESUCCESS;
			redirect("addprices_proc.php?id=".$prices->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$prices=new Prices();
	$where=" where id=$id ";
	$fields="pos_prices.id, pos_prices.name, pos_prices.remarks, pos_prices.ipaddress, pos_prices.createdby, pos_prices.createdon, pos_prices.lasteditedby, pos_prices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$prices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$prices->fetchObject;

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
	
	
$page_title="Prices ";
include "addprices.php";
?>