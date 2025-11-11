<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Colours_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8829";//Edit
}
else{
	$auth->roleid="8829";//Add
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
	$colours=new Colours();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$colours->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$colours=$colours->setObject($obj);
		if($colours->add($colours)){
			$error=SUCCESS;
			redirect("addcolours_proc.php?id=".$colours->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$colours=new Colours();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$colours->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$colours=$colours->setObject($obj);
		if($colours->edit($colours)){
			$error=UPDATESUCCESS;
			redirect("addcolours_proc.php?id=".$colours->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$colours=new Colours();
	$where=" where id=$id ";
	$fields="pos_colours.id, pos_colours.name, pos_colours.remarks, pos_colours.ipaddress, pos_colours.createdby, pos_colours.createdon, pos_colours.lasteditedby, pos_colours.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$colours->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$colours->fetchObject;

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
	
	
$page_title="Colours ";
include "addcolours.php";
?>