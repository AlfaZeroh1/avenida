<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Disciplinarytypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4822";//Edit
}
else{
	$auth->roleid="4822";//Add
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
	$disciplinarytypes=new Disciplinarytypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$disciplinarytypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$disciplinarytypes=$disciplinarytypes->setObject($obj);
		if($disciplinarytypes->add($disciplinarytypes)){
			$error=SUCCESS;
			redirect("adddisciplinarytypes_proc.php?id=".$disciplinarytypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$disciplinarytypes=new Disciplinarytypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$disciplinarytypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$disciplinarytypes=$disciplinarytypes->setObject($obj);
		if($disciplinarytypes->edit($disciplinarytypes)){
			$error=UPDATESUCCESS;
			redirect("adddisciplinarytypes_proc.php?id=".$disciplinarytypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$disciplinarytypes=new Disciplinarytypes();
	$where=" where id=$id ";
	$fields="hrm_disciplinarytypes.id, hrm_disciplinarytypes.name, hrm_disciplinarytypes.remarks, hrm_disciplinarytypes.createdby, hrm_disciplinarytypes.createdon, hrm_disciplinarytypes.lasteditedby, hrm_disciplinarytypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$disciplinarytypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$disciplinarytypes->fetchObject;

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
	
	
$page_title="Disciplinarytypes ";
include "adddisciplinarytypes.php";
?>