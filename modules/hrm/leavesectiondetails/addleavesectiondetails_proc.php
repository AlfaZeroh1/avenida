<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Leavesectiondetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/leaves/Leaves_class.php");
require_once("../../hrm/leavesections/Leavesections_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9980";//Edit
}
else{
	$auth->roleid="9978";//Add
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
	$leavesectiondetails=new Leavesectiondetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$leavesectiondetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leavesectiondetails=$leavesectiondetails->setObject($obj);
		if($leavesectiondetails->add($leavesectiondetails)){
			$error=SUCCESS;
			redirect("addleavesectiondetails_proc.php?id=".$leavesectiondetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$leavesectiondetails=new Leavesectiondetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$leavesectiondetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leavesectiondetails=$leavesectiondetails->setObject($obj);
		if($leavesectiondetails->edit($leavesectiondetails)){
			$error=UPDATESUCCESS;
			redirect("addleavesectiondetails_proc.php?id=".$leavesectiondetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$leaves= new Leaves();
	$fields="hrm_leaves.id, hrm_leaves.name, hrm_leaves.days, hrm_leaves.remarks, hrm_leaves.ipaddress, hrm_leaves.createdby, hrm_leaves.createdon, hrm_leaves.lasteditedby, hrm_leaves.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$leavesections= new Leavesections();
	$fields="hrm_leavesections.id, hrm_leavesections.name, hrm_leavesections.remarks, hrm_leavesections.ipaddress, hrm_leavesections.createdby, hrm_leavesections.createdon, hrm_leavesections.lasteditedby, hrm_leavesections.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leavesections->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$leavesectiondetails=new Leavesectiondetails();
	$where=" where id=$id ";
	$fields="hrm_leavesectiondetails.id, hrm_leavesectiondetails.leaveid, hrm_leavesectiondetails.leavesectionid, hrm_leavesectiondetails.days, hrm_leavesectiondetails.duration, hrm_leavesectiondetails.remarks, hrm_leavesectiondetails.ipaddress, hrm_leavesectiondetails.createdby, hrm_leavesectiondetails.createdon, hrm_leavesectiondetails.lasteditedby, hrm_leavesectiondetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leavesectiondetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$leavesectiondetails->fetchObject;

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
$where=" where name='hrm_leavesectiondetails' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addleavesectiondetails.php";
?>