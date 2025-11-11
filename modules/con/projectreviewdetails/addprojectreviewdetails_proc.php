<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectreviewdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8531";//Edit
}
else{
	$auth->roleid="8531";//Add
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
	$projectreviewdetails=new Projectreviewdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectreviewdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectreviewdetails=$projectreviewdetails->setObject($obj);
		if($projectreviewdetails->add($projectreviewdetails)){
			$error=SUCCESS;
			redirect("addprojectreviewdetails_proc.php?id=".$projectreviewdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectreviewdetails=new Projectreviewdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectreviewdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectreviewdetails=$projectreviewdetails->setObject($obj);
		if($projectreviewdetails->edit($projectreviewdetails)){
			$error=UPDATESUCCESS;
			redirect("addprojectreviewdetails_proc.php?id=".$projectreviewdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$projectreviewdetails=new Projectreviewdetails();
	$where=" where id=$id ";
	$fields="con_projectreviewdetails.id, con_projectreviewdetails.reviewid, con_projectreviewdetails.status, con_projectreviewdetails.remark, con_projectreviewdetails.ipaddress, con_projectreviewdetails.createdby, con_projectreviewdetails.createdon, con_projectreviewdetails.lasteditedby, con_projectreviewdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectreviewdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectreviewdetails->fetchObject;

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
	
	
$page_title="Projectreviewdetails ";
include "addprojectreviewdetails.php";
?>