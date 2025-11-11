<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Areas_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4778";//Edit
}
else{
	$auth->roleid="4778";//Add
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
	
	
if($obj->action=="Save"){
	$areas=new Areas();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$areas->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$areas=$areas->setObject($obj);
		if($areas->add($areas)){
			$error=SUCCESS;
			redirect("addareas_proc.php?id=".$areas->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$areas=new Areas();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$areas->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$areas=$areas->setObject($obj);
		if($areas->edit($areas)){
			$error=UPDATESUCCESS;
			redirect("addareas_proc.php?id=".$areas->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$areas=new Areas();
	$where=" where id=$id ";
	$fields="crm_areas.id, crm_areas.name, crm_areas.remarks, crm_areas.createdby, crm_areas.createdon, crm_areas.lasteditedby, crm_areas.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$areas->fetchObject;

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
	
	
$page_title="Areas ";
include "addareas.php";
?>