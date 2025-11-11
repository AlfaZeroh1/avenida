<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Levelleavedays_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/leaves/Leaves_class.php");
require_once("../../hrm/levels/Levels_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9298";//Edit
}
else{
	$auth->roleid="9298";//Add
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
	$levelleavedays=new Levelleavedays();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$levelleavedays->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$levelleavedays=$levelleavedays->setObject($obj);
		if($levelleavedays->add($levelleavedays)){
			$error=SUCCESS;
			redirect("addlevelleavedays_proc.php?id=".$levelleavedays->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$levelleavedays=new Levelleavedays();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$levelleavedays->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$levelleavedays=$levelleavedays->setObject($obj);
		if($levelleavedays->edit($levelleavedays)){
			$error=UPDATESUCCESS;
			redirect("addlevelleavedays_proc.php?id=".$levelleavedays->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$leaves= new Leaves();
	$fields="hrm_leaves.id, hrm_leaves.name, hrm_leaves.days, hrm_leaves.remarks, hrm_leaves.createdby, hrm_leaves.createdon, hrm_leaves.lasteditedby, hrm_leaves.lasteditedon, hrm_leaves.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$levels= new Levels();
	$fields="hrm_levels.id, hrm_levels.name, hrm_levels.overallno, hrm_levels.deptno, hrm_levels.follows, hrm_levels.remarks, hrm_levels.ipaddress, hrm_levels.createdby, hrm_levels.createdon, hrm_levels.lasteditedby, hrm_levels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$levelleavedays=new Levelleavedays();
	$where=" where id=$id ";
	$fields="hrm_levelleavedays.id, hrm_levelleavedays.leaveid, hrm_levelleavedays.levelid, hrm_levelleavedays.leavedays, hrm_levelleavedays.remarks, hrm_levelleavedays.ipaddress, hrm_levelleavedays.createdby, hrm_levelleavedays.createdon, hrm_levelleavedays.lasteditedby, hrm_levelleavedays.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levelleavedays->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$levelleavedays->fetchObject;

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
	
	
$page_title="Levelleavedays ";
include "addlevelleavedays.php";
?>