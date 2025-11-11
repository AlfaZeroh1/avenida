<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Housenotices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/houses/Houses_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4864";//Edit
}
else{
	$auth->roleid="4862";//Add
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
	$housenotices=new Housenotices();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$housenotices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$housenotices=$housenotices->setObject($obj);
		if($housenotices->add($housenotices)){
			$error=SUCCESS;
			redirect("addhousenotices_proc.php?id=".$housenotices->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$housenotices=new Housenotices();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$housenotices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$housenotices=$housenotices->setObject($obj);
		if($housenotices->edit($housenotices)){
			$error=UPDATESUCCESS;
			redirect("addhousenotices_proc.php?id=".$housenotices->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.depositmgtfee, em_houses.depositmgtfeevatable, em_houses.depositmgtfeevatclasseid, em_houses.depositmgtfeeperc, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.chargeable, em_houses.penalty, em_houses.remarks, em_houses.ipaddress, em_houses.createdby, em_houses.createdon, em_houses.lasteditedby, em_houses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$housenotices=new Housenotices();
	$where=" where id=$id ";
	$fields="em_housenotices.id, em_housenotices.houseid, em_housenotices.noticedate, em_housenotices.tovacateon, em_housenotices.status, em_housenotices.remarks, em_housenotices.createdby, em_housenotices.createdon, em_housenotices.lasteditedby, em_housenotices.lasteditedon, em_housenotices.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$housenotices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$housenotices->fetchObject;

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
	
	
$page_title="Housenotices ";
include "addhousenotices.php";
?>