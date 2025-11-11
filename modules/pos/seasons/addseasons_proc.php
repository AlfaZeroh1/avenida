<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Seasons_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8677";//Edit
}
else{
	$auth->roleid="8675";//Add
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
	$seasons=new Seasons();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$seasons->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$seasons=$seasons->setObject($obj);
		if($seasons->add($seasons)){
			$error=SUCCESS;
			redirect("addseasons_proc.php?id=".$seasons->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$seasons=new Seasons();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$seasons->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$seasons=$seasons->setObject($obj);
		if($seasons->edit($seasons)){
			$error=UPDATESUCCESS;
			redirect("addseasons_proc.php?id=".$seasons->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$seasons=new Seasons();
	$where=" where id=$id ";
	$fields="pos_seasons.id, pos_seasons.name, pos_seasons.start, pos_seasons.end, pos_seasons.remarks, pos_seasons.ipaddress, pos_seasons.createdby, pos_seasons.createdon, pos_seasons.lasteditedby, pos_seasons.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$seasons->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$seasons->fetchObject;

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
	
	
$page_title="Seasons ";
include "addseasons.php";
?>