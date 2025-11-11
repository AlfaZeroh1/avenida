<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Types_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4161";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4159";//Add
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
	$types=new Types();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$types->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$types=$types->setObject($obj);
		if($types->add($types)){
			$error=SUCCESS;
			redirect("addtypes_proc.php?id=".$types->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$types=new Types();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$types->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$types=$types->setObject($obj);
		if($types->edit($types)){
			$error=UPDATESUCCESS;
			redirect("addtypes_proc.php?id=".$types->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$types=new Types();
	$where=" where id=$id ";
	$fields="em_types.id, em_types.name, em_types.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$types->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$types->fetchObject;

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
	
	
$page_title="Types ";
include "addtypes.php";
?>