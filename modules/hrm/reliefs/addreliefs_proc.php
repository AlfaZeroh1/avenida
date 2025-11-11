<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Reliefs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1183";//Edit
}
else{
	$auth->roleid="1181";//Add
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
	$reliefs=new Reliefs();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$reliefs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$reliefs=$reliefs->setObject($obj);
		if($reliefs->add($reliefs)){
			$error=SUCCESS;
			redirect("addreliefs_proc.php?id=".$reliefs->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$reliefs=new Reliefs();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$reliefs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$reliefs=$reliefs->setObject($obj);
		if($reliefs->edit($reliefs)){
			$error=UPDATESUCCESS;
			redirect("addreliefs_proc.php?id=".$reliefs->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$reliefs=new Reliefs();
	$where=" where id=$id ";
	$fields="hrm_reliefs.id, hrm_reliefs.name, hrm_reliefs.amount, hrm_reliefs.overall, hrm_reliefs.createdby, hrm_reliefs.createdon, hrm_reliefs.lasteditedby, hrm_reliefs.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$reliefs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$reliefs->fetchObject;

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
	
	
$page_title="Reliefs ";
include "addreliefs.php";
?>