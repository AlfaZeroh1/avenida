<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotpaymentdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/paymentmodes/Paymentmodes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4133";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4131";//Add
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
	$plotpaymentdetails=new Plotpaymentdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$plotpaymentdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotpaymentdetails=$plotpaymentdetails->setObject($obj);
		if($plotpaymentdetails->add($plotpaymentdetails)){
			$error=SUCCESS;
			redirect("addplotpaymentdetails_proc.php?id=".$plotpaymentdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$plotpaymentdetails=new Plotpaymentdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$plotpaymentdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotpaymentdetails=$plotpaymentdetails->setObject($obj);
		if($plotpaymentdetails->edit($plotpaymentdetails)){
			$error=UPDATESUCCESS;
			redirect("addplotpaymentdetails_proc.php?id=".$plotpaymentdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$paymentmodes= new Paymentmodes();
	$fields="sys_paymentmodes.id, sys_paymentmodes.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$plotpaymentdetails=new Plotpaymentdetails();
	$where=" where id=$id ";
	$fields="em_plotpaymentdetails.id, em_plotpaymentdetails.plotid, em_plotpaymentdetails.bank, em_plotpaymentdetails.accntno, em_plotpaymentdetails.paidon, em_plotpaymentdetails.paymentmodeid, em_plotpaymentdetails.vatno, em_plotpaymentdetails.pin, em_plotpaymentdetails.chequesto";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plotpaymentdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$plotpaymentdetails->fetchObject;

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
	
	
$page_title="Plotpaymentdetails ";
include "addplotpaymentdetails.php";
?>