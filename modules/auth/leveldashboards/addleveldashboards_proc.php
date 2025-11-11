<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Leveldashboards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../auth/levels/Levels_class.php");
require_once("../../sys/dashboards/Dashboards_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11763";//Edit
}
else{
	$auth->roleid="11761";//Add
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
	$leveldashboards=new Leveldashboards();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$leveldashboards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leveldashboards=$leveldashboards->setObject($obj);
		if($leveldashboards->add($leveldashboards)){
			$error=SUCCESS;
			redirect("addleveldashboards_proc.php?id=".$leveldashboards->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$leveldashboards=new Leveldashboards();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$leveldashboards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leveldashboards=$leveldashboards->setObject($obj);
		if($leveldashboards->edit($leveldashboards)){
			$error=UPDATESUCCESS;
			redirect("addleveldashboards_proc.php?id=".$leveldashboards->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$levels= new Levels();
	$fields="auth_levels.id, auth_levels.name, auth_levels.createdby, auth_levels.createdon, auth_levels.lasteditedby, auth_levels.lasteditedon, auth_levels.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$dashboards= new Dashboards();
	$fields="sys_dashboards.id, sys_dashboards.name, sys_dashboards.type, sys_dashboards.query, sys_dashboards.status, sys_dashboards.remarks, sys_dashboards.ipaddress, sys_dashboards.createdby, sys_dashboards.createdon, sys_dashboards.lasteditedby, sys_dashboards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$dashboards->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$leveldashboards=new Leveldashboards();
	$where=" where id=$id ";
	$fields="auth_leveldashboards.id, auth_leveldashboards.levelid, auth_leveldashboards.dashboardid, auth_leveldashboards.status, auth_leveldashboards.ipaddress, auth_leveldashboards.createdby, auth_leveldashboards.createdon, auth_leveldashboards.lasteditedby, auth_leveldashboards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leveldashboards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$leveldashboards->fetchObject;

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
$where=" where name='auth_leveldashboards' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addleveldashboards.php";
?>