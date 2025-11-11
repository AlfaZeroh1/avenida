<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Qualitychecks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/checkitems/Checkitems_class.php");
require_once("../../prod/breederdeliverydetails/Breederdeliverydetails_class.php");
require_once("../../prod/breeders/Breeders_class.php");
require_once("../../prod/varietys/Varietys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8629";//Edit
}
else{
	$auth->roleid="8627";//Add
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
	$qualitychecks=new Qualitychecks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpqualitychecks=$_SESSION['shpqualitychecks'];
	$error=$qualitychecks->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpqualitychecks)){
		$error="No items in the sale list!";
	}
	else{
		$qualitychecks=$qualitychecks->setObject($obj);
		if($qualitychecks->add($qualitychecks,$shpqualitychecks)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$qualitychecks=new Qualitychecks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$qualitychecks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$qualitychecks=$qualitychecks->setObject($obj);
		$shpqualitychecks=$_SESSION['shpqualitychecks'];
		if($qualitychecks->edit($qualitychecks,$shpqualitychecks)){
			$error=UPDATESUCCESS;
			redirect("addqualitychecks_proc.php?id=".$qualitychecks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->checkitemid)){
		$error="Check Item must be provided";
	}
	elseif(empty($obj->varietyid)){
		$error="Variety must be provided";
	}
	elseif(empty($obj->findings)){
		$error="Findings must be provided";
	}
	elseif(empty($obj->remarks)){
		$error="Remarks must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpqualitychecks=$_SESSION['shpqualitychecks'];

	$checkitems = new Checkitems();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->checkitemid'";
	$checkitems->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$checkitems=$checkitems->fetchObject;
	$varietys = new Varietys();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->varietyid'";
	$varietys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$varietys=$varietys->fetchObject;
	$shpqualitychecks[$it]=array('checkitemid'=>"$obj->checkitemid",'breederdeliverydetailid'=>"$obj->breederdeliverydetailid", 'checkitemname'=>"$checkitems->name", 'varietyid'=>"$obj->varietyid", 'varietyname'=>"$varietys->name", 'findings'=>"$obj->findings", 'remarks'=>"$obj->remarks");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpqualitychecks']=$shpqualitychecks;

	$obj->checkitemname="";
 	$obj->checkitemid="";
 	$obj->varietyname="";
 	$obj->varietyid="";
 	$obj->findings="";
 	$obj->remarks="";
 }
}

if(empty($obj->action)){

	$checkitems= new Checkitems();
	$fields="prod_checkitems.id, prod_checkitems.name, prod_checkitems.remarks, prod_checkitems.ipaddress, prod_checkitems.createdby, prod_checkitems.createdon, prod_checkitems.lasteditedby, prod_checkitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checkitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$breederdeliverydetails= new Breederdeliverydetails();
	$fields="prod_breederdeliverydetails.id, prod_breederdeliverydetails.breederdeliveryid, prod_breederdeliverydetails.varietyid, prod_breederdeliverydetails.quantity, prod_breederdeliverydetails.memo, prod_breederdeliverydetails.ipaddress, prod_breederdeliverydetails.createdby, prod_breederdeliverydetails.createdon, prod_breederdeliverydetails.lasteditedby, prod_breederdeliverydetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breederdeliverydetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$breeders= new Breeders();
	$fields="prod_breeders.id, prod_breeders.code, prod_breeders.name, prod_breeders.contact, prod_breeders.physicaladdress, prod_breeders.tel, prod_breeders.fax, prod_breeders.email, prod_breeders.cellphone, prod_breeders.status, prod_breeders.createdby, prod_breeders.createdon, prod_breeders.lasteditedby, prod_breeders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breeders->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$varietys= new Varietys();
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$qualitychecks=new Qualitychecks();
	$where=" where id=$id ";
	$fields="prod_qualitychecks.id, prod_qualitychecks.checkitemid, prod_qualitychecks.breederdeliverydetailid, prod_qualitychecks.breederid, prod_qualitychecks.varietyid, prod_qualitychecks.checkedon, prod_qualitychecks.findings, prod_qualitychecks.remarks, prod_qualitychecks.ipaddress, prod_qualitychecks.createdby, prod_qualitychecks.createdon, prod_qualitychecks.lasteditedby, prod_qualitychecks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$qualitychecks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$qualitychecks->fetchObject;

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
	
	
$page_title="Qualitychecks ";
include "addqualitychecks.php";
?>