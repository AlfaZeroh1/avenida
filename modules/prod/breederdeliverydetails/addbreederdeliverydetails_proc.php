<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Breederdeliverydetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/breederdeliverys/Breederdeliverys_class.php");
require_once("../../prod/varietys/Varietys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8561";//Edit
}
else{
	$auth->roleid="8559";//Add
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
	$breederdeliverydetails=new Breederdeliverydetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$breederdeliverydetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$breederdeliverydetails=$breederdeliverydetails->setObject($obj);
		if($breederdeliverydetails->add($breederdeliverydetails)){
			$error=SUCCESS;
			redirect("addbreederdeliverydetails_proc.php?id=".$breederdeliverydetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$breederdeliverydetails=new Breederdeliverydetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$breederdeliverydetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$breederdeliverydetails=$breederdeliverydetails->setObject($obj);
		if($breederdeliverydetails->edit($breederdeliverydetails)){
			$error=UPDATESUCCESS;
			redirect("addbreederdeliverydetails_proc.php?id=".$breederdeliverydetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$breederdeliverys= new Breederdeliverys();
	$fields="prod_breederdeliverys.id, prod_breederdeliverys.documentno, prod_breederdeliverys.breederid, prod_breederdeliverys.deliveredon, prod_breederdeliverys.week, prod_breederdeliverys.remarks, prod_breederdeliverys.ipaddress, prod_breederdeliverys.createdby, prod_breederdeliverys.createdon, prod_breederdeliverys.lasteditedby, prod_breederdeliverys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breederdeliverys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$varietys= new Varietys();
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$breederdeliverydetails=new Breederdeliverydetails();
	$where=" where id=$id ";
	$fields="prod_breederdeliverydetails.id, prod_breederdeliverydetails.breederdeliveryid, prod_breederdeliverydetails.varietyid, prod_breederdeliverydetails.quantity, prod_breederdeliverydetails.memo, prod_breederdeliverydetails.ipaddress, prod_breederdeliverydetails.createdby, prod_breederdeliverydetails.createdon, prod_breederdeliverydetails.lasteditedby, prod_breederdeliverydetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breederdeliverydetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$breederdeliverydetails->fetchObject;

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
	
	
$page_title="Breederdeliverydetails ";
include "addbreederdeliverydetails.php";
?>