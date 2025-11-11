<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectquantities_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projects/Projects_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../con/materialcategorys/Materialcategorys_class.php");
require_once("../../con/materialsubcategorys/Materialsubcategorys_class.php");
require_once("../../con/projectboqdetails/Projectboqdetails_class.php");
require_once("../../con/labours/Labours_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7572";//Edit
}
else{
	$auth->roleid="7570";//Add
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
	$projectquantities=new Projectquantities();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectquantities->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectquantities=$projectquantities->setObject($obj);
		if($projectquantities->add($projectquantities)){
			$error=SUCCESS;
			redirect("addprojectquantities_proc.php?id=".$projectquantities->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectquantities=new Projectquantities();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectquantities->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectquantities=$projectquantities->setObject($obj);
		if($projectquantities->edit($projectquantities)){
			$error=UPDATESUCCESS;
			redirect("addprojectquantities_proc.php?id=".$projectquantities->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$projects= new Projects();
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$materialcategorys= new Materialcategorys();
	$fields="con_materialcategorys.id, con_materialcategorys.name, con_materialcategorys.remarks, con_materialcategorys.ipaddress, con_materialcategorys.createdby, con_materialcategorys.createdon, con_materialcategorys.lasteditedby, con_materialcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$materialcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$materialsubcategorys= new Materialsubcategorys();
	$fields="con_materialsubcategorys.id, con_materialsubcategorys.name, con_materialsubcategorys.categoryid, con_materialsubcategorys.remarks, con_materialsubcategorys.ipaddress, con_materialsubcategorys.createdby, con_materialsubcategorys.createdon, con_materialsubcategorys.lasteditedby, con_materialsubcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$materialsubcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$projectboqdetails= new Projectboqdetails();
	$fields="con_projectboqdetails.id, con_projectboqdetails.projectboqid, con_projectboqdetails.materialcategoryid, con_projectboqdetails.materialsubcategoryid, con_projectboqdetails.estimationmanualid, con_projectboqdetails.unitofmeasureid, con_projectboqdetails.quantity, con_projectboqdetails.rate, con_projectboqdetails.total, con_projectboqdetails.remarks, con_projectboqdetails.ipaddress, con_projectboqdetails.createdby, con_projectboqdetails.createdon, con_projectboqdetails.lasteditedby, con_projectboqdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectboqdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$labours= new Labours();
	$fields="con_labours.id, con_labours.name, con_labours.rate, con_labours.remarks, con_labours.ipaddress, con_labours.createdby, con_labours.createdon, con_labours.lasteditedby, con_labours.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$labours->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projectquantities=new Projectquantities();
	$where=" where id=$id ";
	$fields="con_projectquantities.id, con_projectquantities.projectid, con_projectquantities.projectboqdetailid, con_projectquantities.itemid, con_projectquantities.labourid, con_projectquantities.categoryid, con_projectquantities.subcategoryid, con_projectquantities.quantity, con_projectquantities.rate, con_projectquantities.remarks, con_projectquantities.projectweek, con_projectquantities.week, con_projectquantities.year, con_projectquantities.ipaddress, con_projectquantities.createdby, con_projectquantities.createdon, con_projectquantities.lasteditedby, con_projectquantities.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectquantities->fetchObject;

	//for autocompletes
	$items = new Items();
	$fields=" * ";
	$where=" where id='$obj->itemid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$items->fetchObject;

	$obj->itemname=$auto->name;
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
	
	
$page_title="Projectquantities ";
include "addprojectquantities.php";
?>