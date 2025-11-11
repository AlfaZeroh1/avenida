<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Expensetypes_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../sys/acctypes/Acctypes_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="749";//Edit
}
else{
	$auth->roleid="747";//Add
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
	$expensetypes=new Expensetypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$expensetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$expensetypes=$expensetypes->setObject($obj);
		if($expensetypes->add($expensetypes)){
			$error=SUCCESS;
			redirect("addexpensetypes_proc.php?id=".$expensetypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$expensetypes=new Expensetypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$expensetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$expensetypes=$expensetypes->setObject($obj);
		$expensetypes->oldacctypeid=$obj->oldacctypeid;
		if($expensetypes->edit($expensetypes)){
			$error=UPDATESUCCESS;
			redirect("addexpensetypes_proc.php?id=".$expensetypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$expensetypes=new Expensetypes();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expensetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$expensetypes->fetchObject;
	
	$obj->oldacctypeid=$obj->acctypeid;

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
	
	
$page_title="Expensetypes ";
include "addexpensetypes.php";
?>