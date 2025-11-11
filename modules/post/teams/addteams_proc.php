<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teams_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8641";//Edit
}
else{
	$auth->roleid="8639";//Add
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
	$teams=new Teams();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$teams->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teams=$teams->setObject($obj);
		if($teams->add($teams)){
			$error=SUCCESS;
			redirect("addteams_proc.php?id=".$teams->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$teams=new Teams();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$teams->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teams=$teams->setObject($obj);
		if($teams->edit($teams)){
			$error=UPDATESUCCESS;
			redirect("addteams_proc.php?id=".$teams->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$teams=new Teams();
	$where=" where id=$id ";
	$fields="post_teams.id, post_teams.name, post_teams.remarks, post_teams.ipaddress, post_teams.createdby, post_teams.createdon, post_teams.lasteditedby, post_teams.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$teams->fetchObject;

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
	
	
$page_title="Teams ";
include "addteams.php";
?>