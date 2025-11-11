<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Categorysizes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/categorys/Categorys_class.php");
require_once("../../pos/sizes/Sizes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8816";//Edit
}
else{
	$auth->roleid="8816";//Add
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
	$categorysizes=new Categorysizes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$categorysizes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$categorysizes=$categorysizes->setObject($obj);
		if($categorysizes->add($categorysizes)){
			$error=SUCCESS;
			redirect("addcategorysizes_proc.php?id=".$categorysizes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$categorysizes=new Categorysizes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$categorysizes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$categorysizes=$categorysizes->setObject($obj);
		if($categorysizes->edit($categorysizes)){
			$error=UPDATESUCCESS;
			redirect("addcategorysizes_proc.php?id=".$categorysizes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$categorys= new Categorys();
	$fields="pos_categorys.id, pos_categorys.name, pos_categorys.remarks, pos_categorys.ipaddress, pos_categorys.createdby, pos_categorys.createdon, pos_categorys.lasteditedby, pos_categorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$sizes= new Sizes();
	$fields="pos_sizes.id, pos_sizes.name, pos_sizes.remarks, pos_sizes.ipaddress, pos_sizes.createdby, pos_sizes.createdon, pos_sizes.lasteditedby, pos_sizes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$categorysizes=new Categorysizes();
	$where=" where id=$id ";
	$fields="pos_categorysizes.id, pos_categorysizes.categoryid, pos_categorysizes.sizeid, pos_categorysizes.price, pos_categorysizes.remarks, pos_categorysizes.ipaddress, pos_categorysizes.createdby, pos_categorysizes.createdon, pos_categorysizes.lasteditedby, pos_categorysizes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorysizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$categorysizes->fetchObject;

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
	
	
$page_title="Categorysizes ";
include "addcategorysizes.php";
?>