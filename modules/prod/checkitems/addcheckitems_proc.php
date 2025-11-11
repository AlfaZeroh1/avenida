<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Checkitems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8573";//Edit
}
else{
	$auth->roleid="8571";//Add
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
	$checkitems=new Checkitems();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$checkitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checkitems=$checkitems->setObject($obj);
		if($checkitems->add($checkitems)){
			$error=SUCCESS;
			redirect("addcheckitems_proc.php?id=".$checkitems->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$checkitems=new Checkitems();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$checkitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checkitems=$checkitems->setObject($obj);
		if($checkitems->edit($checkitems)){
			$error=UPDATESUCCESS;
			redirect("addcheckitems_proc.php?id=".$checkitems->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$checkitems=new Checkitems();
	$where=" where id=$id ";
	$fields="prod_checkitems.id, prod_checkitems.name, prod_checkitems.remarks, prod_checkitems.ipaddress, prod_checkitems.createdby, prod_checkitems.createdon, prod_checkitems.lasteditedby, prod_checkitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checkitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$checkitems->fetchObject;

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
	
	
$page_title="Checkitems ";
include "addcheckitems.php";
?>