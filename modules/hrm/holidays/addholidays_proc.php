<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Holidays_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="10588";//Edit
}
else{
	$auth->roleid="10588";//Add
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
	$holidays=new Holidays();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$holidays->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$holidays=$holidays->setObject($obj);
		if($holidays->add($holidays)){
			$error=SUCCESS;
			redirect("addholidays_proc.php?id=".$holidays->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$holidays=new Holidays();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$holidays->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$holidays=$holidays->setObject($obj);
		if($holidays->edit($holidays)){
			$error=UPDATESUCCESS;
			redirect("addholidays_proc.php?id=".$holidays->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$holidays=new Holidays();
	$where=" where id=$id ";
	$fields="hrm_holidays.id, hrm_holidays.name, hrm_holidays.date, hrm_holidays.recurse, hrm_holidays.remarks, hrm_holidays.ipaddress, hrm_holidays.createdby, hrm_holidays.createdon, hrm_holidays.lasteditedby, hrm_holidays.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$holidays->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$holidays->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->recurse="No";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='hrm_holidays' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addholidays.php";
?>