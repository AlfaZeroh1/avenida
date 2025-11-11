<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetserviceitems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8969";//Edit
}
else{
	$auth->roleid="8969";//Add
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
	$fleetserviceitems=new Fleetserviceitems();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetserviceitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetserviceitems=$fleetserviceitems->setObject($obj);
		if($fleetserviceitems->add($fleetserviceitems)){
			$error=SUCCESS;
			redirect("addfleetserviceitems_proc.php?id=".$fleetserviceitems->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleetserviceitems=new Fleetserviceitems();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleetserviceitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetserviceitems=$fleetserviceitems->setObject($obj);
		if($fleetserviceitems->edit($fleetserviceitems)){
			$error=UPDATESUCCESS;
			redirect("addfleetserviceitems_proc.php?id=".$fleetserviceitems->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$fleetserviceitems=new Fleetserviceitems();
	$where=" where id=$id ";
	$fields="assets_fleetserviceitems.id, assets_fleetserviceitems.name, assets_fleetserviceitems.remarks, assets_fleetserviceitems.ipaddress, assets_fleetserviceitems.createdby, assets_fleetserviceitems.createdon, assets_fleetserviceitems.lasteditedby, assets_fleetserviceitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetserviceitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleetserviceitems->fetchObject;

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
	
	
$page_title="Fleetserviceitems ";
include "addfleetserviceitems.php";
?>