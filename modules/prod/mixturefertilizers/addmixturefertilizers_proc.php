<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Mixturefertilizers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/irrigationmixtures/Irrigationmixtures_class.php");
require_once("../../prod/fetilizers/Fetilizers_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9229";//Edit
}
else{
	$auth->roleid="9229";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->mixtureid))
  $obj->mixtureid=$ob->mixtureid;

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
	$mixturefertilizers=new Mixturefertilizers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$mixturefertilizers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$mixturefertilizers=$mixturefertilizers->setObject($obj);
		if($mixturefertilizers->add($mixturefertilizers)){
			$error=SUCCESS;
			redirect("addmixturefertilizers_proc.php?id=".$mixturefertilizers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$mixturefertilizers=new Mixturefertilizers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$mixturefertilizers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$mixturefertilizers=$mixturefertilizers->setObject($obj);
		if($mixturefertilizers->edit($mixturefertilizers)){
			$error=UPDATESUCCESS;
			redirect("addmixturefertilizers_proc.php?id=".$mixturefertilizers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$irrigationmixtures= new Irrigationmixtures();
	$fields="prod_irrigationmixtures.id, prod_irrigationmixtures.irrigationid, prod_irrigationmixtures.tankid, prod_irrigationmixtures.water, prod_irrigationmixtures.ec, prod_irrigationmixtures.ph, prod_irrigationmixtures.remarks, prod_irrigationmixtures.ipaddress, prod_irrigationmixtures.createdby, prod_irrigationmixtures.createdon, prod_irrigationmixtures.lasteditedby, prod_irrigationmixtures.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigationmixtures->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$fertilizers= new Fetilizers();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fertilizers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$mixturefertilizers=new Mixturefertilizers();
	$where=" where id=$id ";
	$fields="prod_mixturefertilizers.id, prod_mixturefertilizers.mixtureid, prod_mixturefertilizers.fertilizerid, prod_mixturefertilizers.quantity, prod_mixturefertilizers.remarks, prod_mixturefertilizers.ipaddress, prod_mixturefertilizers.createdby, prod_mixturefertilizers.createdon, prod_mixturefertilizers.lasteditedby, prod_mixturefertilizers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$mixturefertilizers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$mixturefertilizers->fetchObject;

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
	
	
$page_title="Mixturefertilizers ";
include "addmixturefertilizers.php";
?>