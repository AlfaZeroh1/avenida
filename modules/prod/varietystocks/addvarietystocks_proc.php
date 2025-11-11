<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Varietystocks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/varietys/Varietys_class.php");
require_once("../../prod/areas/Areas_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8687";//Edit
}
else{
	$auth->roleid="8687";//Add
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
	$varietystocks=new Varietystocks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$varietystocks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$varietystocks=$varietystocks->setObject($obj);
		if($varietystocks->add($varietystocks)){
			$error=SUCCESS;
			redirect("addvarietystocks_proc.php?id=".$varietystocks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$varietystocks=new Varietystocks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$varietystocks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$varietystocks=$varietystocks->setObject($obj);
		if($varietystocks->edit($varietystocks)){
			$error=UPDATESUCCESS;
			redirect("addvarietystocks_proc.php?id=".$varietystocks->id."&error=".$error);
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


	$areas= new Areas();
	$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.blockid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$varietystocks=new Varietystocks();
	$where=" where id=$id ";
	$fields="prod_varietystocks.id, prod_varietystocks.documentno, prod_varietystocks.varietyid, prod_varietystocks.areaid, prod_varietystocks.transaction, prod_varietystocks.quantity, prod_varietystocks.remain, prod_varietystocks.recordedon, prod_varietystocks.actedon, prod_varietystocks.ipaddress, prod_varietystocks.createdby, prod_varietystocks.createdon, prod_varietystocks.lasteditedby, prod_varietystocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietystocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$varietystocks->fetchObject;

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
	
	
$page_title="Varietystocks ";
include "addvarietystocks.php";
?>