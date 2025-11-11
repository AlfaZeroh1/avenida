<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Surchages_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../hrm/surchagetypes/Surchagetypes_class.php");
require_once("../../fn/expenses/Expenses_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1195";//Edit
}
else{
	$auth->roleid="1193";//Add
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
	$surchages=new Surchages();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$surchages->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$surchages=$surchages->setObject($obj);
		if($surchages->add($surchages)){
			$error=SUCCESS;
			redirect("addsurchages_proc.php?id=".$surchages->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$surchages=new Surchages();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$surchages->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$surchages=$surchages->setObject($obj);
		if($surchages->edit($surchages)){
			$error=UPDATESUCCESS;
			redirect("addsurchages_proc.php?id=".$surchages->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$surchages=new Surchages();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$surchages->fetchObject;

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
	
	
$page_title="Surchages ";
include "addsurchages.php";
?>