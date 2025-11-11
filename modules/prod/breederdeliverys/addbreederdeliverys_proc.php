<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Breederdeliverys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/breeders/Breeders_class.php");
require_once("../../prod/breederdeliverydetails/Breederdeliverydetails_class.php");
require_once("../../prod/varietys/Varietys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8565";//Edit
}
else{
	$auth->roleid="8563";//Add
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
	
if(empty($obj->action)){
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from prod_breederdeliverys"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->deliveredon=date('Y-m-d');

}

if($obj->action=="Save"){
	$breederdeliverys=new Breederdeliverys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpbreederdeliverys=$_SESSION['shpbreederdeliverys'];
	$error=$breederdeliverys->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpbreederdeliverys)){
		$error="No items in the sale list!";
	}
	else{
		$breederdeliverys=$breederdeliverys->setObject($obj);
		if($breederdeliverys->add($breederdeliverys,$shpbreederdeliverys)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$breederdeliverys=new Breederdeliverys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$breederdeliverys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$breederdeliverys=$breederdeliverys->setObject($obj);
		$shpbreederdeliverys=$_SESSION['shpbreederdeliverys'];
		if($breederdeliverys->edit($breederdeliverys,$shpbreederdeliverys)){
			$error=UPDATESUCCESS;
			redirect("addbreederdeliverys_proc.php?id=".$breederdeliverys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->varietyid)){
		$error=" must be provided";
	}
	elseif(empty($obj->quantity)){
		$error=" must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpbreederdeliverys=$_SESSION['shpbreederdeliverys'];

	$varietys = new Varietys();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->varietyid'";
	$varietys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$varietys=$varietys->fetchObject;
	$shpbreederdeliverys[$it]=array('varietyid'=>"$obj->varietyid", 'varietyname'=>"$varietys->name", 'quantity'=>"$obj->quantity", 'memo'=>"$obj->memo");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpbreederdeliverys']=$shpbreederdeliverys;

	$obj->varietyid="";
 	$obj->quantity="";
 	$obj->memo="";
 }
}

if(empty($obj->action)){

	$breeders= new Breeders();
	$fields="prod_breeders.id, prod_breeders.code, prod_breeders.name, prod_breeders.contact, prod_breeders.physicaladdress, prod_breeders.tel, prod_breeders.fax, prod_breeders.email, prod_breeders.cellphone, prod_breeders.status, prod_breeders.createdby, prod_breeders.createdon, prod_breeders.lasteditedby, prod_breeders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breeders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$breederdeliverys=new Breederdeliverys();
	$where=" where id=$id ";
	$fields="prod_breederdeliverys.id, prod_breederdeliverys.documentno, prod_breederdeliverys.breederid, prod_breederdeliverys.deliveredon, prod_breederdeliverys.week, prod_breederdeliverys.remarks, prod_breederdeliverys.ipaddress, prod_breederdeliverys.createdby, prod_breederdeliverys.createdon, prod_breederdeliverys.lasteditedby, prod_breederdeliverys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breederdeliverys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$breederdeliverys->fetchObject;

	//for autocompletes
	$breeders = new Breeders();
	$fields=" * ";
	$where=" where id='$obj->breederid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breeders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$breeders->fetchObject;

	$obj->breedername=$auto->name;
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
	
	
$page_title="Breederdeliverys ";
include "addbreederdeliverys.php";
?>