<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Regions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8421";//Edit
}
else{
	$auth->roleid="8419";//Add
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
	$regions=new Regions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$regions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$regions=$regions->setObject($obj);
		if($regions->add($regions)){
			$error=SUCCESS;
			redirect("addregions_proc.php?id=".$regions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$regions=new Regions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$regions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$regions=$regions->setObject($obj);
		if($regions->edit($regions)){
			$error=UPDATESUCCESS;
			redirect("addregions_proc.php?id=".$regions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$regions=new Regions();
	$where=" where id=$id ";
	$fields="reg_regions.id, reg_regions.name, reg_regions.remarks, reg_regions.ipaddress, reg_regions.createdby, reg_regions.createdon, reg_regions.lasteditedby, reg_regions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$regions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$regions->fetchObject;

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
	
	
$page_title="Regions ";
include "addregions.php";
?>