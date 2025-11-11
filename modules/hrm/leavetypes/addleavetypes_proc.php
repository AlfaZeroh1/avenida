<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Leavetypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="10602";//Edit
}
else{
	$auth->roleid="10600";//Add
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
	$leavetypes=new Leavetypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$leavetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leavetypes=$leavetypes->setObject($obj);
		if($leavetypes->add($leavetypes)){
			$error=SUCCESS;
			redirect("addleavetypes_proc.php?id=".$leavetypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$leavetypes=new Leavetypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$leavetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leavetypes=$leavetypes->setObject($obj);
		if($leavetypes->edit($leavetypes)){
			$error=UPDATESUCCESS;
			redirect("addleavetypes_proc.php?id=".$leavetypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$leavetypes=new Leavetypes();
	$where=" where id=$id ";
	$fields="hrm_leavetypes.id, hrm_leavetypes.name, hrm_leavetypes.noofdays, hrm_leavetypes.type, hrm_leavetypes.maxcf, hrm_leavetypes.earningrate, hrm_leavetypes.per, hrm_leavetypes.gender, hrm_leavetypes.remarks, hrm_leavetypes.ipaddress, hrm_leavetypes.createdby, hrm_leavetypes.createdon, hrm_leavetypes.lasteditedby, hrm_leavetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leavetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$leavetypes->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->per="Month";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='hrm_leavetypes' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addleavetypes.php";
?>