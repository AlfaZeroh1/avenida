<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectequipments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/equipments/Equipments_class.php");
require_once("../../con/projectworkschedules/Projectworkschedules_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8449";//Edit
}
else{
	$auth->roleid="8447";//Add
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
	$projectequipments=new Projectequipments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectequipments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectequipments=$projectequipments->setObject($obj);
		if($projectequipments->add($projectequipments)){
			$error=SUCCESS;
			redirect("addprojectequipments_proc.php?id=".$projectequipments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectequipments=new Projectequipments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectequipments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectequipments=$projectequipments->setObject($obj);
		if($projectequipments->edit($projectequipments)){
			$error=UPDATESUCCESS;
			redirect("addprojectequipments_proc.php?id=".$projectequipments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$equipments= new Equipments();
	$fields="con_equipments.id, con_equipments.name, con_equipments.hirecost, con_equipments.purchasecost, con_equipments.remarks, con_equipments.ipaddress, con_equipments.createdby, con_equipments.createdon, con_equipments.lasteditedby, con_equipments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$equipments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$projectworkschedules= new Projectworkschedules();
	$fields="con_projectworkschedules.id, con_projectworkschedules.projectboqid, con_projectworkschedules.employeeid, con_projectworkschedules.projectweek, con_projectworkschedules.week, con_projectworkschedules.year, con_projectworkschedules.priority, con_projectworkschedules.tracktime, con_projectworkschedules.reqduration, con_projectworkschedules.reqdurationtype, con_projectworkschedules.deadline, con_projectworkschedules.startdate, con_projectworkschedules.starttime, con_projectworkschedules.enddate, con_projectworkschedules.endtime, con_projectworkschedules.duration, con_projectworkschedules.durationtype, con_projectworkschedules.remind, con_projectworkschedules.remarks, con_projectworkschedules.ipaddress, con_projectworkschedules.createdby, con_projectworkschedules.createdon, con_projectworkschedules.lasteditedby, con_projectworkschedules.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectworkschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projectequipments=new Projectequipments();
	$where=" where id=$id ";
	$fields="con_projectequipments.id, con_projectequipments.equipmentid, con_projectequipments.projectworkscheduleid, con_projectequipments.projectweek, con_projectequipments.week, con_projectequipments.month, con_projectequipments.year, con_projectequipments.type, con_projectequipments.rate, con_projectequipments.remarks, con_projectequipments.ipaddress, con_projectequipments.createdby, con_projectequipments.createdon, con_projectequipments.lasteditedby, con_projectequipments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectequipments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectequipments->fetchObject;

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
	
	
$page_title="Projectequipments ";
include "addprojectequipments.php";
?>