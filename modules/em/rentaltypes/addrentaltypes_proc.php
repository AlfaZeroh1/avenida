<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rentaltypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4153";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4151";//Add
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
	$rentaltypes=new Rentaltypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$rentaltypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$rentaltypes=$rentaltypes->setObject($obj);
		if($rentaltypes->add($rentaltypes)){
			$error=SUCCESS;
			redirect("addrentaltypes_proc.php?id=".$rentaltypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$rentaltypes=new Rentaltypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$rentaltypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$rentaltypes=$rentaltypes->setObject($obj);
		if($rentaltypes->edit($rentaltypes)){
			$error=UPDATESUCCESS;
			redirect("addrentaltypes_proc.php?id=".$rentaltypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$rentaltypes=new Rentaltypes();
	$where=" where id=$id ";
	$fields="em_rentaltypes.id, em_rentaltypes.name, em_rentaltypes.months, em_rentaltypes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rentaltypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$rentaltypes->fetchObject;

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
	
	
$page_title="Rentaltypes ";
include "addrentaltypes.php";
?>