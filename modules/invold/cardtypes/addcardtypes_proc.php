<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Cardtypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4743";//Edit
}
else{
	$auth->roleid="4741";//Add
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
	$cardtypes=new Cardtypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$cardtypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$cardtypes=$cardtypes->setObject($obj);
		if($cardtypes->add($cardtypes)){
			$error=SUCCESS;
			redirect("addcardtypes_proc.php?id=".$cardtypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$cardtypes=new Cardtypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$cardtypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$cardtypes=$cardtypes->setObject($obj);
		if($cardtypes->edit($cardtypes)){
			$error=UPDATESUCCESS;
			redirect("addcardtypes_proc.php?id=".$cardtypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$cardtypes=new Cardtypes();
	$where=" where id=$id ";
	$fields="inv_cardtypes.id, inv_cardtypes.name, inv_cardtypes.discount, inv_cardtypes.remarks, inv_cardtypes.createdby, inv_cardtypes.createdon, inv_cardtypes.lasteditedby, inv_cardtypes.lasteditedon, inv_cardtypes.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$cardtypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$cardtypes->fetchObject;

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
	
	
$page_title="Cardtypes ";
include "addcardtypes.php";
?>