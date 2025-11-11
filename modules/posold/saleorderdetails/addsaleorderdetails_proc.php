<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Saleorderdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/saleorders/Saleorders_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8337";//Edit
}
else{
	$auth->roleid="8335";//Add
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
	$saleorderdetails=new Saleorderdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$saleorderdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$saleorderdetails=$saleorderdetails->setObject($obj);
		if($saleorderdetails->add($saleorderdetails)){
			$error=SUCCESS;
			redirect("addsaleorderdetails_proc.php?id=".$saleorderdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$saleorderdetails=new Saleorderdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$saleorderdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$saleorderdetails=$saleorderdetails->setObject($obj);
		if($saleorderdetails->edit($saleorderdetails)){
			$error=UPDATESUCCESS;
			redirect("addsaleorderdetails_proc.php?id=".$saleorderdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$saleorders= new Saleorders();
	$fields="pos_saleorders.id, pos_saleorders.documentno, pos_saleorders.customerid, pos_saleorders.agentid, pos_saleorders.employeeid, pos_saleorders.remarks, pos_saleorders.soldon, pos_saleorders.expirydate, pos_saleorders.memo, pos_saleorders.createdby, pos_saleorders.createdon, pos_saleorders.lasteditedby, pos_saleorders.lasteditedon, pos_saleorders.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$saleorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$saleorderdetails=new Saleorderdetails();
	$where=" where id=$id ";
	$fields="pos_saleorderdetails.id, pos_saleorderdetails.saleorderid, pos_saleorderdetails.itemid, pos_saleorderdetails.quantity, pos_saleorderdetails.costprice, pos_saleorderdetails.tradeprice, pos_saleorderdetails.discount, pos_saleorderdetails.tax, pos_saleorderdetails.bonus, pos_saleorderdetails.profit, pos_saleorderdetails.total, pos_saleorderdetails.ipaddress, pos_saleorderdetails.createdby, pos_saleorderdetails.createdon, pos_saleorderdetails.lasteditedby, pos_saleorderdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$saleorderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$saleorderdetails->fetchObject;

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
	
	
$page_title="Saleorderdetails ";
include "addsaleorderdetails.php";
?>