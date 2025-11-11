<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houserents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/houses/Houses_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4105";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4103";//Add
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
	$houserents=new Houserents();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$houserents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houserents=$houserents->setObject($obj);
		if($houserents->add($houserents)){
			$error=SUCCESS;
			redirect("addhouserents_proc.php?id=".$houserents->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$houserents=new Houserents();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$houserents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houserents=$houserents->setObject($obj);
		if($houserents->edit($houserents)){
			$error=UPDATESUCCESS;
			redirect("addhouserents_proc.php?id=".$houserents->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$houserents=new Houserents();
	$where=" where id=$id ";
	$fields="em_houserents.id, em_houserents.houseid, em_houserents.previous, em_houserents.enddate, em_houserents.current";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houserents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$houserents->fetchObject;

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
	
	
$page_title="Houserents ";
include "addhouserents.php";
?>