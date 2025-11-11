<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Productionbudgets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/greenhousevarietys/Greenhousevarietys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9293";//Edit
}
else{
	$auth->roleid="9293";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->greenhousevarietyid)){
  $obj->greenhousevarietyid=$ob->greenhousevarietyid;
}

if(empty($obj->action)){
  $obj->year=date("Y");
}

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
	$productionbudgets=new Productionbudgets();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$productionbudgets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$productionbudgets=$productionbudgets->setObject($obj);
		if($productionbudgets->add($productionbudgets)){
			$error=SUCCESS;
			redirect("addproductionbudgets_proc.php?id=".$productionbudgets->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$productionbudgets=new Productionbudgets();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$productionbudgets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$productionbudgets=$productionbudgets->setObject($obj);
		if($productionbudgets->edit($productionbudgets)){
			$error=UPDATESUCCESS;
			redirect("addproductionbudgets_proc.php?id=".$productionbudgets->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$greenhousevarietys= new Greenhousevarietys();
	$fields="prod_greenhousevarietys.id, prod_greenhousevarietys.greenhouseid, prod_greenhousevarietys.varietyid, prod_greenhousevarietys.employeeid, prod_greenhousevarietys.breederid, prod_greenhousevarietys.area, prod_greenhousevarietys.plants, prod_greenhousevarietys.plantedon, prod_greenhousevarietys.noofbeds, prod_greenhousevarietys.remarks, prod_greenhousevarietys.ipaddress, prod_greenhousevarietys.createdby, prod_greenhousevarietys.createdon, prod_greenhousevarietys.lasteditedby, prod_greenhousevarietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$greenhousevarietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$productionbudgets=new Productionbudgets();
	$where=" where id=$id ";
	$fields="prod_productionbudgets.id, prod_productionbudgets.greenhousevarietyid, prod_productionbudgets.month, prod_productionbudgets.year, prod_productionbudgets.budgetedon, prod_productionbudgets.quantity, prod_productionbudgets.ipaddress, prod_productionbudgets.createdby, prod_productionbudgets.createdon, prod_productionbudgets.lasteditedby, prod_productionbudgets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$productionbudgets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$productionbudgets->fetchObject;

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
	
	
$page_title="Productionbudgets ";
include "addproductionbudgets.php";
?>