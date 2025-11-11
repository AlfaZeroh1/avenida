<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Foods_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4495";//Edit
}
else{
	$auth->roleid="4495";//Add
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
	
	
if($obj->action=="Save"){
	$foods=new Foods();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$foods->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$foods=$foods->setObject($obj);
		if($foods->add($foods)){
			$error=SUCCESS;
			redirect("addfoods_proc.php?id=".$foods->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$foods=new Foods();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$foods->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$foods=$foods->setObject($obj);
		if($foods->edit($foods)){
			$error=UPDATESUCCESS;
			redirect("addfoods_proc.php?id=".$foods->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$foods=new Foods();
	$where=" where id=$id ";
	$fields="hos_foods.id, hos_foods.name, hos_foods.price, hos_foods.remarks, hos_foods.createdby, hos_foods.createdon, hos_foods.lasteditedby, hos_foods.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$foods->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$foods->fetchObject;

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
	
	
$page_title="Foods ";
include "addfoods.php";
?>