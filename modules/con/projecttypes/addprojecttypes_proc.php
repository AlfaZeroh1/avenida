<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projecttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7588";//Edit
}
else{
	$auth->roleid="7586";//Add
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
	$projecttypes=new Projecttypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projecttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projecttypes=$projecttypes->setObject($obj);
		if($projecttypes->add($projecttypes)){
			$error=SUCCESS;
			redirect("addprojecttypes_proc.php?id=".$projecttypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projecttypes=new Projecttypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projecttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projecttypes=$projecttypes->setObject($obj);
		if($projecttypes->edit($projecttypes)){
			$error=UPDATESUCCESS;
			redirect("addprojecttypes_proc.php?id=".$projecttypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$projecttypes=new Projecttypes();
	$where=" where id=$id ";
	$fields="con_projecttypes.id, con_projecttypes.name, con_projecttypes.remarks, con_projecttypes.ipaddress, con_projecttypes.createdby, con_projecttypes.createdon, con_projecttypes.lasteditedby, con_projecttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projecttypes->fetchObject;

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
	
	
$page_title="Projecttypes ";
include "addprojecttypes.php";
?>