<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Teams_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/shifts/Shifts_class.php");
require_once("../../sys/branches/Branches_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11927";//Edit
}
else{
	$auth->roleid="11927";//Add
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
	$teams=new Teams();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$teams->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teams=$teams->setObject($obj);
		if($teams->add($teams)){
			$error=SUCCESS;
			redirect("addteams_proc.php?id=".$teams->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$teams=new Teams();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$teams->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teams=$teams->setObject($obj);
		if($teams->edit($teams)){
			$error=UPDATESUCCESS;
			redirect("addteams_proc.php?id=".$teams->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$shifts= new Shifts();
	$fields="pos_shifts.id, pos_shifts.name, pos_shifts.starttime, pos_shifts.enddate, pos_shifts.remarks, pos_shifts.ipaddress, pos_shifts.createdby, pos_shifts.createdon, pos_shifts.lasteditedby, pos_shifts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$shifts->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$branches= new Branches();
	$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.type, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$teams=new Teams();
	$where=" where id=$id ";
	$fields="pos_teams.id, pos_teams.brancheid, pos_teams.shiftid, pos_teams.startedon, pos_teams.endedon, pos_teams.teamedon, pos_teams.remarks, pos_teams.ipaddress, pos_teams.createdby, pos_teams.createdon, pos_teams.lasteditedby, pos_teams.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$teams->fetchObject;

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
$where=" where name='pos_teams' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addteams.php";
?>