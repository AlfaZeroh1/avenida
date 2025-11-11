<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Routedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/assignments/Assignments_class.php");
require_once("../../wf/routes/Routes_class.php");
require_once("../../wf/systemtasks/Systemtasks_class.php");
require_once("../../hrm/levels/Levels_class.php");
require_once("../../hrm/departments/Departments_class.php");
require_once("../../con/projects/Projects_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7452";//Edit
}
else{
	$auth->roleid="7450";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);

//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->routeid))
  $obj->routeid=$ob->routeid;

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
	$routedetails=new Routedetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$routedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$routedetails=$routedetails->setObject($obj);
		if($routedetails->add($routedetails)){
			$error=SUCCESS;
			//redirect("addroutedetails_proc.php?id=".$routedetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$routedetails=new Routedetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$routedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$routedetails=$routedetails->setObject($obj);
		if($routedetails->edit($routedetails)){
			$error=UPDATESUCCESS;
			redirect("addroutedetails_proc.php?id=".$routedetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$assignments= new Assignments();
	$fields="hrm_assignments.id, hrm_assignments.code, hrm_assignments.name, hrm_assignments.departmentid, hrm_assignments.levelid, hrm_assignments.remarks, hrm_assignments.createdby, hrm_assignments.createdon, hrm_assignments.lasteditedby, hrm_assignments.lasteditedon, hrm_assignments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$routes= new Routes();
	$fields="wf_routes.id, wf_routes.name, wf_routes.moduleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$systemtasks= new Systemtasks();
	$fields="wf_systemtasks.id, wf_systemtasks.name, wf_systemtasks.action, wf_systemtasks.remarks, wf_systemtasks.ipaddress, wf_systemtasks.createdby, wf_systemtasks.createdon, wf_systemtasks.lasteditedby, wf_systemtasks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$systemtasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$routedetails=new Routedetails();
	$where=" where wf_routedetails.id=$id ";
	$fields="wf_routedetails.*, hrm_assignments.departmentid";
	$join="left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid ";
	$having="";
	$groupby="";
	$orderby="";
	$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$routedetails->fetchObject;
	

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		
		$obj->approval="Yes";
		
		$routedetails = new Routedetails();
		$where=" where routeid=$obj->routeid ";
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby=" order by id desc";
		$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$routedetails = $routedetails->fetchObject;
		$obj->follows=$routedetails->id;
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Routedetails ";
if(empty($obj->tp))
  include "addroutedetails.php";
else
  include "../routes/route.php?routeid=".$obj->routeid;
?>