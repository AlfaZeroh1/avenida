<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Cards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/cardtypes/Cardtypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4739";//Edit
}
else{
	$auth->roleid="4737";//Add
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
	$cards=new Cards();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$cards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$cards=$cards->setObject($obj);
		if($cards->add($cards)){
			$error=SUCCESS;
			redirect("addcards_proc.php?id=".$cards->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$cards=new Cards();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$cards->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$cards=$cards->setObject($obj);
		if($cards->edit($cards)){
			$error=UPDATESUCCESS;
			redirect("addcards_proc.php?id=".$cards->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$cardtypes= new Cardtypes();
	$fields="inv_cardtypes.id, inv_cardtypes.name, inv_cardtypes.discount, inv_cardtypes.remarks, inv_cardtypes.createdby, inv_cardtypes.createdon, inv_cardtypes.lasteditedby, inv_cardtypes.lasteditedon, inv_cardtypes.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$cardtypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$cards=new Cards();
	$where=" where id=$id ";
	$fields="inv_cards.id, inv_cards.cardno, inv_cards.cardtypeid, inv_cards.remarks, inv_cards.createdby, inv_cards.createdon, inv_cards.lasteditedby, inv_cards.lasteditedon, inv_cards.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$cards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$cards->fetchObject;

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
	
	
$page_title="Cards ";
include "addcards.php";
?>