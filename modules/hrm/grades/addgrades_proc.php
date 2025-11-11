<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Grades_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4267";//Edit
}
else{
	$auth->roleid="4265";//Add
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
	$grades=new Grades();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$grades->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$grades=$grades->setObject($obj);
		if($grades->add($grades)){
			$error=SUCCESS;
			redirect("addgrades_proc.php?id=".$grades->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$grades=new Grades();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$grades->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$grades=$grades->setObject($obj);
		if($grades->edit($grades)){
			$error=UPDATESUCCESS;
			redirect("addgrades_proc.php?id=".$grades->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$grades=new Grades();
	$where=" where id=$id ";
	$fields="hrm_grades.id, hrm_grades.name, hrm_grades.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$grades->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$grades->fetchObject;

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
	
	
$page_title="Grades ";
include "addgrades.php";
?>