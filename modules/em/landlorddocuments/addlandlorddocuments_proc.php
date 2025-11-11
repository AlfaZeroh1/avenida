<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Landlorddocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/landlords/Landlords_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8109";//Edit
}
else{
	$auth->roleid="8107";//Add
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
	$landlorddocuments=new Landlorddocuments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$landlorddocuments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$landlorddocuments=$landlorddocuments->setObject($obj);
		if($landlorddocuments->add($landlorddocuments)){
			$error=SUCCESS;
			redirect("addlandlorddocuments_proc.php?id=".$landlorddocuments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$landlorddocuments=new Landlorddocuments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$landlorddocuments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$landlorddocuments=$landlorddocuments->setObject($obj);
		if($landlorddocuments->edit($landlorddocuments)){
			$error=UPDATESUCCESS;
			redirect("addlandlorddocuments_proc.php?id=".$landlorddocuments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$landlords= new Landlords();
	$fields="em_landlords.id, em_landlords.llcode, em_landlords.firstname, em_landlords.middlename, em_landlords.lastname, em_landlords.tel, em_landlords.email, em_landlords.registeredon, em_landlords.fax, em_landlords.mobile, em_landlords.idno, em_landlords.passportno, em_landlords.postaladdress, em_landlords.address, em_landlords.deductcommission, em_landlords.status, em_landlords.ipaddress, em_landlords.createdby, em_landlords.createdon, em_landlords.lasteditedby, em_landlords.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$landlords->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$landlorddocuments=new Landlorddocuments();
	$where=" where id=$id ";
	$fields="em_landlorddocuments.id, em_landlorddocuments.landlordid, em_landlorddocuments.documenttypeid, em_landlorddocuments.name, em_landlorddocuments.document, em_landlorddocuments.remarks, em_landlorddocuments.ipaddress, em_landlorddocuments.createdby, em_landlorddocuments.createdon, em_landlorddocuments.lasteditedby, em_landlorddocuments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$landlorddocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$landlorddocuments->fetchObject;

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
	
	
$page_title="Landlorddocuments ";
include "addlandlorddocuments.php";
?>