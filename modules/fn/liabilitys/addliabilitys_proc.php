<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Liabilitys_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9066";//Edit
}
else{
	$auth->roleid="9064";//Add
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
	$liabilitys=new Liabilitys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$liabilitys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$liabilitys=$liabilitys->setObject($obj);
		if($liabilitys->add($liabilitys)){
			
			$error=SUCCESS;
			redirect("addliabilitys_proc.php?id=".$liabilitys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$liabilitys=new Liabilitys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$liabilitys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$liabilitys=$liabilitys->setObject($obj);
		if($liabilitys->edit($liabilitys)){
			$error=UPDATESUCCESS;
// 			redirect("addliabilitys_proc.php?id=".$liabilitys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(!empty($id)){
	$liabilitys=new Liabilitys();
	$where=" where id=$id ";
	$fields="fn_liabilitys.id, fn_liabilitys.name,  fn_liabilitys.remarks, fn_liabilitys.ipaddress, fn_liabilitys.createdby, fn_liabilitys.createdon, fn_liabilitys.lasteditedby, fn_liabilitys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$liabilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$liabilitys->fetchObject;

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
	
	
$page_title="Liabilitys ";
include "addliabilitys.php";
?>