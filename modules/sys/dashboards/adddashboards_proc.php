<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Dashboards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11768";//Edit
}
else{
	$auth->roleid="11766";//Add
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
	$dashboards=new Dashboards();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$dashboards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$dashboards=$dashboards->setObject($obj);
		if($dashboards->add($dashboards)){
			$error=SUCCESS;
			redirect("adddashboards_proc.php?id=".$dashboards->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$dashboards=new Dashboards();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$dashboards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$dashboards=$dashboards->setObject($obj);
		if($dashboards->edit($dashboards)){
			$error=UPDATESUCCESS;
			redirect("adddashboards_proc.php?id=".$dashboards->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$dashboards=new Dashboards();
	$where=" where id=$id ";
	$fields="sys_dashboards.id, sys_dashboards.name, sys_dashboards.type, sys_dashboards.query, sys_dashboards.cssclass, sys_dashboards.status, sys_dashboards.remarks, sys_dashboards.ipaddress, sys_dashboards.createdby, sys_dashboards.createdon, sys_dashboards.lasteditedby, sys_dashboards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$dashboards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$dashboards->fetchObject;

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
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='sys_dashboards' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "adddashboards.php";
?>