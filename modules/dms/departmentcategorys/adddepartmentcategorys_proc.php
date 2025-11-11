<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Departmentcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../dms/departments/Departments_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7556";//Edit
}
else{
	$auth->roleid="7554";//Add
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
	$departmentcategorys=new Departmentcategorys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$departmentcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$departmentcategorys=$departmentcategorys->setObject($obj);
		if($departmentcategorys->add($departmentcategorys)){
			$error=SUCCESS;
			redirect("adddepartmentcategorys_proc.php?id=".$departmentcategorys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$departmentcategorys=new Departmentcategorys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$departmentcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$departmentcategorys=$departmentcategorys->setObject($obj);
		if($departmentcategorys->edit($departmentcategorys)){
			$error=UPDATESUCCESS;
			redirect("adddepartmentcategorys_proc.php?id=".$departmentcategorys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$departments= new Departments();
	$fields="dms_departments.id, dms_departments.name, dms_departments.remarks, dms_departments.ipaddress, dms_departments.createdby, dms_departments.createdon, dms_departments.lasteditedby, dms_departments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$departmentcategorys=new Departmentcategorys();
	$where=" where id=$id ";
	$fields="dms_departmentcategorys.id, dms_departmentcategorys.name, dms_departmentcategorys.departmentid, dms_departmentcategorys.remarks, dms_departmentcategorys.ipaddress, dms_departmentcategorys.createdby, dms_departmentcategorys.createdon, dms_departmentcategorys.lasteditedby, dms_departmentcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departmentcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$departmentcategorys->fetchObject;

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
	
	
$page_title="Departmentcategorys ";
include "adddepartmentcategorys.php";
?>