<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documenttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/modules/Modules_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7568";//Edit
}
else{
	$auth->roleid="7566";//Add
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
	$documenttypes=new Documenttypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$documenttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$documenttypes=$documenttypes->setObject($obj);
		if($documenttypes->add($documenttypes)){
			$error=SUCCESS;
			redirect("adddocumenttypes_proc.php?id=".$documenttypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$documenttypes=new Documenttypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$documenttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$documenttypes=$documenttypes->setObject($obj);
		if($documenttypes->edit($documenttypes)){
			$error=UPDATESUCCESS;
			redirect("adddocumenttypes_proc.php?id=".$documenttypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$modules= new Modules();
	$fields="sys_modules.id, sys_modules.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$modules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$documenttypes=new Documenttypes();
	$where=" where id=$id ";
	$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$documenttypes->fetchObject;

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
	
	
$page_title="Documenttypes ";
include "adddocumenttypes.php";
?>