<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Landlordemergencycontacts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/landlords/Landlords_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8113";//Edit
}
else{
	$auth->roleid="8111";//Add
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
	$landlordemergencycontacts=new Landlordemergencycontacts();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$landlordemergencycontacts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$landlordemergencycontacts=$landlordemergencycontacts->setObject($obj);
		if($landlordemergencycontacts->add($landlordemergencycontacts)){
			$error=SUCCESS;
			redirect("addlandlordemergencycontacts_proc.php?id=".$landlordemergencycontacts->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$landlordemergencycontacts=new Landlordemergencycontacts();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$landlordemergencycontacts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$landlordemergencycontacts=$landlordemergencycontacts->setObject($obj);
		if($landlordemergencycontacts->edit($landlordemergencycontacts)){
			$error=UPDATESUCCESS;
			redirect("addlandlordemergencycontacts_proc.php?id=".$landlordemergencycontacts->id."&error=".$error);
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
	$landlordemergencycontacts=new Landlordemergencycontacts();
	$where=" where id=$id ";
	$fields="em_landlordemergencycontacts.id, em_landlordemergencycontacts.landlordid, em_landlordemergencycontacts.name, em_landlordemergencycontacts.relation, em_landlordemergencycontacts.tel, em_landlordemergencycontacts.email, em_landlordemergencycontacts.address, em_landlordemergencycontacts.physicaladdress, em_landlordemergencycontacts.remarks, em_landlordemergencycontacts.ipaddress, em_landlordemergencycontacts.createdby, em_landlordemergencycontacts.createdon, em_landlordemergencycontacts.lasteditedby, em_landlordemergencycontacts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$landlordemergencycontacts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$landlordemergencycontacts->fetchObject;

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
	
	
$page_title="Landlordemergencycontacts ";
include "addlandlordemergencycontacts.php";
?>