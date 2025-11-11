<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Assignments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/departments/Departments_class.php");
require_once("../../hrm/leavesections/Leavesections_class.php");;
require_once("../../hrm/levels/Levels_class.php");
require_once("../../hrm/sections/Sections_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1105";//Edit
}
else{
	$auth->roleid="1103";//Add
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
	$assignments=new Assignments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$assignments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assignments=$assignments->setObject($obj);
		if($assignments->add($assignments)){
			$error=SUCCESS;
			redirect("addassignments_proc.php?id=".$assignments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$assignments=new Assignments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$assignments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assignments=$assignments->setObject($obj);
		if($assignments->edit($assignments)){
			$error=UPDATESUCCESS;
			redirect("addassignments_proc.php?id=".$assignments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$departments= new Departments();
	$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$levels= new Levels();
	$fields="hrm_levels.id, hrm_levels.name, hrm_levels.overallno, hrm_levels.deptno, hrm_levels.follows, hrm_levels.remarks, hrm_levels.ipaddress, hrm_levels.createdby, hrm_levels.createdon, hrm_levels.lasteditedby, hrm_levels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	
	$sections= new Sections();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$assignments=new Assignments();
	$where=" where id=$id ";
	$fields="hrm_assignments.id, hrm_assignments.code, hrm_assignments.name, hrm_assignments.departmentid, hrm_assignments.levelid, hrm_assignments.leavesectionid, hrm_assignments.sectionid, hrm_assignments.remarks, hrm_assignments.createdby, hrm_assignments.createdon, hrm_assignments.lasteditedby, hrm_assignments.lasteditedon, hrm_assignments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$assignments->fetchObject;

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
$where=" where name='hrm_assignments' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addassignments.php";
?>