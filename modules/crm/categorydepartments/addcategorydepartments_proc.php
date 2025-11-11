<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Categorydepartments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/departments/Departments_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4782";//Edit
}
else{
	$auth->roleid="4782";//Add
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
	
	
if($obj->action=="Save"){
	$categorydepartments=new Categorydepartments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$categorydepartments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$categorydepartments=$categorydepartments->setObject($obj);
		if($categorydepartments->add($categorydepartments)){
			$error=SUCCESS;
			redirect("addcategorydepartments_proc.php?id=".$categorydepartments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$categorydepartments=new Categorydepartments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$categorydepartments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$categorydepartments=$categorydepartments->setObject($obj);
		if($categorydepartments->edit($categorydepartments)){
			$error=UPDATESUCCESS;
			redirect("addcategorydepartments_proc.php?id=".$categorydepartments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$departments= new Departments();
	$fields="crm_departments.id, crm_departments.name, crm_departments.remarks, crm_departments.createdby, crm_departments.createdon, crm_departments.lasteditedby, crm_departments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$categorydepartments=new Categorydepartments();
	$where=" where id=$id ";
	$fields="crm_categorydepartments.id, crm_categorydepartments.name, crm_categorydepartments.departmentid, crm_categorydepartments.remarks, crm_categorydepartments.createdby, crm_categorydepartments.createdon, crm_categorydepartments.lasteditedby, crm_categorydepartments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorydepartments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$categorydepartments->fetchObject;

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
	
	
$page_title="Categorydepartments ";
include "addcategorydepartments.php";
?>