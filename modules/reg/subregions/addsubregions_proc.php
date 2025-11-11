<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Subregions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../reg/regions/Regions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8425";//Edit
}
else{
	$auth->roleid="8423";//Add
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
	$subregions=new Subregions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$subregions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$subregions=$subregions->setObject($obj);
		if($subregions->add($subregions)){
			$error=SUCCESS;
			redirect("addsubregions_proc.php?id=".$subregions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$subregions=new Subregions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$subregions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$subregions=$subregions->setObject($obj);
		if($subregions->edit($subregions)){
			$error=UPDATESUCCESS;
			redirect("addsubregions_proc.php?id=".$subregions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$regions= new Regions();
	$fields="reg_regions.id, reg_regions.name, reg_regions.remarks, reg_regions.ipaddress, reg_regions.createdby, reg_regions.createdon, reg_regions.lasteditedby, reg_regions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$regions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$subregions=new Subregions();
	$where=" where id=$id ";
	$fields="reg_subregions.id, reg_subregions.name, reg_subregions.regionid, reg_subregions.remarks, reg_subregions.ipaddress, reg_subregions.createdby, reg_subregions.createdon, reg_subregions.lasteditedby, reg_subregions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$subregions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$subregions->fetchObject;

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
	
	
$page_title="Subregions ";
include "addsubregions.php";
?>