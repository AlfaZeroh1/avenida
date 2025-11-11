<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teamroles_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8637";//Edit
}
else{
	$auth->roleid="8635";//Add
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
	$teamroles=new Teamroles();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$teamroles->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teamroles=$teamroles->setObject($obj);
		if($teamroles->add($teamroles)){
			$error=SUCCESS;
			redirect("addteamroles_proc.php?id=".$teamroles->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$teamroles=new Teamroles();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$teamroles->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teamroles=$teamroles->setObject($obj);
		if($teamroles->edit($teamroles)){
			$error=UPDATESUCCESS;
			redirect("addteamroles_proc.php?id=".$teamroles->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$teamroles=new Teamroles();
	$where=" where id=$id ";
	$fields="post_teamroles.id, post_teamroles.name, post_teamroles.remarks, post_teamroles.ipaddress, post_teamroles.createdby, post_teamroles.createdon, post_teamroles.lasteditedby, post_teamroles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teamroles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$teamroles->fetchObject;

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
	
	
$page_title="Teamroles ";
include "addteamroles.php";
?>