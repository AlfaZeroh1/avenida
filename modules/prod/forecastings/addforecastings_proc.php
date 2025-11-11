<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Forecastings_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/varietys/Varietys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8697";//Edit
}
else{
	$auth->roleid="8695";//Add
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
	$forecastings=new Forecastings();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$forecastings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$forecastings=$forecastings->setObject($obj);
		if($forecastings->add($forecastings)){
			$error=SUCCESS;
			//redirect("addforecastings_proc.php?id=".$forecastings->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$forecastings=new Forecastings();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$forecastings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$forecastings=$forecastings->setObject($obj);
		if($forecastings->edit($forecastings)){
			$error=UPDATESUCCESS;
			redirect("addforecastings_proc.php?id=".$forecastings->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$varietys= new Varietys();
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$forecastings=new Forecastings();
	$where=" where id=$id ";
	$fields="prod_forecastings.id, prod_forecastings.varietyid, prod_forecastings.week,prod_forecastings.year, prod_forecastings.quantity, prod_forecastings.remarks, prod_forecastings.ipaddress, prod_forecastings.createdby, prod_forecastings.createdon, prod_forecastings.lasteditedby, prod_forecastings.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$forecastings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$forecastings->fetchObject;

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
	
	
$page_title="Forecastings ";
include "addforecastings.php";
?>