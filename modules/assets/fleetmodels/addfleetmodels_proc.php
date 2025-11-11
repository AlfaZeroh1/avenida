<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetmodels_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/fleetmakes/Fleetmakes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7640";//Edit
}
else{
	$auth->roleid="7638";//Add
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
	$fleetmodels=new Fleetmodels();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetmodels->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetmodels=$fleetmodels->setObject($obj);
		if($fleetmodels->add($fleetmodels)){
			$error=SUCCESS;
			redirect("addfleetmodels_proc.php?id=".$fleetmodels->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleetmodels=new Fleetmodels();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleetmodels->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetmodels=$fleetmodels->setObject($obj);
		if($fleetmodels->edit($fleetmodels)){
			$error=UPDATESUCCESS;
			redirect("addfleetmodels_proc.php?id=".$fleetmodels->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$fleetmakes= new Fleetmakes();
	$fields="assets_fleetmakes.id, assets_fleetmakes.name, assets_fleetmakes.remarks, assets_fleetmakes.ipaddress, assets_fleetmakes.createdby, assets_fleetmakes.createdon, assets_fleetmakes.lasteditedby, assets_fleetmakes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetmakes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$fleetmodels=new Fleetmodels();
	$where=" where id=$id ";
	$fields="assets_fleetmodels.id, assets_fleetmodels.name, assets_fleetmodels.fleetmakeid, assets_fleetmodels.remarks, assets_fleetmodels.ipaddress, assets_fleetmodels.createdby, assets_fleetmodels.createdon, assets_fleetmodels.lasteditedby, assets_fleetmodels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetmodels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleetmodels->fetchObject;

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
	
	
$page_title="Fleetmodels ";
include "addfleetmodels.php";
?>