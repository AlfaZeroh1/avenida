<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Compositeitems_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9946";//Edit
}
else{
	$auth->roleid="9946";//Add
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
	$compositeitems=new Compositeitems();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$compositeitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$compositeitems=$compositeitems->setObject($obj);
		if($compositeitems->add($compositeitems)){
			$error=SUCCESS;
			redirect("addcompositeitems_proc.php?itemid=".$obj->itemid."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$compositeitems=new Compositeitems();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$compositeitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$compositeitems=$compositeitems->setObject($obj);
		if($compositeitems->edit($compositeitems)){
			$error=UPDATESUCCESS;
			redirect("addcompositeitems_proc.php?itemid=".$obj->itemid."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$items= new Items();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($ob->itemid)){

	$items= new Items();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where inv_items.id='$ob->itemid' ";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$items = $items->fetchObject;
	
	$obj->itemname=$items->name;
	$obj->itemid=$items->id;

}

if(!empty($id)){
	$compositeitems=new Compositeitems();
	$where=" where inv_compositeitems.id=$id ";
	$fields="inv_compositeitems.id, inv_items.name itemname, inv_compositeitems.itemid, inv_compositeitems.itemid2, inv_compositeitems.quantity, inv_compositeitems.remarks, inv_compositeitems.ipaddress, inv_compositeitems.createdby, inv_compositeitems.createdon, inv_compositeitems.lasteditedby, inv_compositeitems.lasteditedon";
	$join=" left join inv_items on inv_items.id=inv_compositeitems.itemid ";
	$having="";
	$groupby="";
	$orderby="";
	$compositeitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$compositeitems->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$obj->quantity=1;
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='inv_compositeitems' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addcompositeitems.php";
?>