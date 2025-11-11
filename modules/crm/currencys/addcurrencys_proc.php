<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Currencys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8833";//Edit
}
else{
	$auth->roleid="8833";//Add
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
	$currencys=new Currencys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$currencys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$currencys=$currencys->setObject($obj);
		if($currencys->add($currencys)){
			$error=SUCCESS;
			redirect("addcurrencys_proc.php?id=".$currencys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$currencys=new Currencys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$currencys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$currencys=$currencys->setObject($obj);
		if($currencys->edit($currencys)){
			$error=UPDATESUCCESS;
			redirect("addcurrencys_proc.php?id=".$currencys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$currencys=new Currencys();
	$where=" where id=$id ";
	$fields="crm_currencys.id, crm_currencys.name, crm_currencys.rate, crm_currencys.remarks, crm_currencys.ipaddress, crm_currencys.createdby, crm_currencys.createdon, crm_currencys.lasteditedby, crm_currencys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$currencys->fetchObject;

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
	
	
$page_title="Currencys ";
include "addcurrencys.php";
?>