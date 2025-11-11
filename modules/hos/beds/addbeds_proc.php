<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Beds_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/wards/Wards_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1260";//Edit
}
else{
	$auth->roleid="1258";//Add
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
	$beds=new Beds();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$beds->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$beds=$beds->setObject($obj);
		if($beds->add($beds)){
			$error=SUCCESS;
			redirect("addbeds_proc.php?id=".$beds->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$beds=new Beds();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$beds->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$beds=$beds->setObject($obj);
		if($beds->edit($beds)){
			$error=UPDATESUCCESS;
			redirect("addbeds_proc.php?id=".$beds->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$wards= new Wards();
	$fields="hos_wards.id, hos_wards.name, hos_wards.departmentid, hos_wards.remarks, hos_wards.firstroom, hos_wards.lastroom, hos_wards.roomprefix, hos_wards.status, hos_wards.createdby, hos_wards.createdon, hos_wards.lasteditedby, hos_wards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$wards->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$beds=new Beds();
	$where=" where id=$id ";
	$fields="hos_beds.id, hos_beds.wardid, hos_beds.roomno, hos_beds.name, hos_beds.status, hos_beds.createdby, hos_beds.createdon, hos_beds.lasteditedby, hos_beds.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$beds->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$beds->fetchObject;

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
	
	
$page_title="Beds ";
include "addbeds.php";
?>