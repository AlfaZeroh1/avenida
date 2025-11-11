<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetservicedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/fleetservices/Fleetservices_class.php");
require_once("../../assets/fleetserviceitems/Fleetserviceitems_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8965";//Edit
}
else{
	$auth->roleid="8965";//Add
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
	$fleetservicedetails=new Fleetservicedetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetservicedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetservicedetails=$fleetservicedetails->setObject($obj);
		if($fleetservicedetails->add($fleetservicedetails)){
			$error=SUCCESS;
			redirect("addfleetservicedetails_proc.php?id=".$fleetservicedetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleetservicedetails=new Fleetservicedetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleetservicedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetservicedetails=$fleetservicedetails->setObject($obj);
		if($fleetservicedetails->edit($fleetservicedetails)){
			$error=UPDATESUCCESS;
			redirect("addfleetservicedetails_proc.php?id=".$fleetservicedetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$fleetservices= new Fleetservices();
	$fields="assets_fleetservices.id, assets_fleetservices.fleetid, assets_fleetservices.description, assets_fleetservices.supplierid, assets_fleetservices.cost, assets_fleetservices.odometer, assets_fleetservices.remarks, assets_fleetservices.ipaddress, assets_fleetservices.createdby, assets_fleetservices.createdon, assets_fleetservices.lasteditedby, assets_fleetservices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$fleetserviceitems= new Fleetserviceitems();
	$fields="assets_fleetserviceitems.id, assets_fleetserviceitems.name, assets_fleetserviceitems.remarks, assets_fleetserviceitems.ipaddress, assets_fleetserviceitems.createdby, assets_fleetserviceitems.createdon, assets_fleetserviceitems.lasteditedby, assets_fleetserviceitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetserviceitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$fleetservicedetails=new Fleetservicedetails();
	$where=" where id=$id ";
	$fields="assets_fleetservicedetails.id, assets_fleetservicedetails.fleetserviceid, assets_fleetservicedetails.fleetserviceitemid, assets_fleetservicedetails.replaced, assets_fleetservicedetails.remarks, assets_fleetservicedetails.ipaddress, assets_fleetservicedetails.createdby, assets_fleetservicedetails.createdon, assets_fleetservicedetails.lasteditedby, assets_fleetservicedetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetservicedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleetservicedetails->fetchObject;

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
	
	
$page_title="Fleetservicedetails ";
include "addfleetservicedetails.php";
?>