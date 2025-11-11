<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Subareas_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/areas/Areas_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4802";//Edit
}
else{
	$auth->roleid="4802";//Add
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
	$subareas=new Subareas();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$subareas->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$subareas=$subareas->setObject($obj);
		if($subareas->add($subareas)){
			$error=SUCCESS;
			redirect("addsubareas_proc.php?id=".$subareas->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$subareas=new Subareas();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$subareas->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$subareas=$subareas->setObject($obj);
		if($subareas->edit($subareas)){
			$error=UPDATESUCCESS;
			redirect("addsubareas_proc.php?id=".$subareas->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$areas= new Areas();
	$fields="crm_areas.id, crm_areas.name, crm_areas.remarks, crm_areas.createdby, crm_areas.createdon, crm_areas.lasteditedby, crm_areas.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$subareas=new Subareas();
	$where=" where id=$id ";
	$fields="crm_subareas.id, crm_subareas.name, crm_subareas.areaid, crm_subareas.remarks, crm_subareas.createdby, crm_subareas.createdon, crm_subareas.lasteditedby, crm_subareas.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$subareas->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$subareas->fetchObject;

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
	
	
$page_title="Subareas ";
include "addsubareas.php";
?>