<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sections_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/departments/Departments_class.php");
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
	$sections=new Sections();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$sections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sections=$sections->setObject($obj);
		if($sections->add($sections)){
			$error=SUCCESS;
			redirect("addsections_proc.php?id=".$sections->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$sections=new Sections();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$sections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sections=$sections->setObject($obj);
		if($sections->edit($sections)){
			$error=UPDATESUCCESS;
			redirect("addsections_proc.php?id=".$sections->id."&error=".$error);
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

}

if(!empty($id)){
	$sections=new Sections();
	$where=" where id=$id ";
	$fields="hrm_sections.id, hrm_sections.name, hrm_sections.departmentid, hrm_sections.remarks, hrm_sections.ipaddress, hrm_sections.createdby, hrm_sections.createdon, hrm_sections.lasteditedby, hrm_sections.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$sections->fetchObject;

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
	
	
$page_title="Sections ";
include "addsections.php";
?>