<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectsubcontractors_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../con/projects/Projects_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8431";//Edit
}
else{
	$auth->roleid="8431";//Add
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
	$projectsubcontractors=new Projectsubcontractors();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectsubcontractors->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectsubcontractors=$projectsubcontractors->setObject($obj);
		if($projectsubcontractors->add($projectsubcontractors)){
			$error=SUCCESS;
			redirect("addprojectsubcontractors_proc.php?id=".$projectsubcontractors->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectsubcontractors=new Projectsubcontractors();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectsubcontractors->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectsubcontractors=$projectsubcontractors->setObject($obj);
		if($projectsubcontractors->edit($projectsubcontractors)){
			$error=UPDATESUCCESS;
			redirect("addprojectsubcontractors_proc.php?id=".$projectsubcontractors->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$projects= new Projects();
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projectsubcontractors=new Projectsubcontractors();
	$where=" where id=$id ";
	$fields="con_projectsubcontractors.id, con_projectsubcontractors.supplierid, con_projectsubcontractors.projectid, con_projectsubcontractors.contractno, con_projectsubcontractors.physicaladdress, con_projectsubcontractors.scope, con_projectsubcontractors.value, con_projectsubcontractors.dateawarded, con_projectsubcontractors.acceptanceletterdate, con_projectsubcontractors.contractsignedon, con_projectsubcontractors.orderdatetocommence, con_projectsubcontractors.startdate, con_projectsubcontractors.expectedenddate, con_projectsubcontractors.actualenddate, con_projectsubcontractors.liabilityperiodtype, con_projectsubcontractors.liabilityperiod, con_projectsubcontractors.remarks, con_projectsubcontractors.statusid, con_projectsubcontractors.ipaddress, con_projectsubcontractors.createdby, con_projectsubcontractors.createdon, con_projectsubcontractors.lasteditedby, con_projectsubcontractors.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectsubcontractors->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectsubcontractors->fetchObject;

	//for autocompletes
	$projects = new Projects();
	$fields=" * ";
	$where=" where id='$obj->projectid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$projects->fetchObject;

	$obj->projectname=$auto->name;
	$suppliers = new Suppliers();
	$fields=" * ";
	$where=" where id='$obj->supplierid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$suppliers->fetchObject;

	$obj->suppliername=$auto->name;
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
	
	
$page_title="Projectsubcontractors ";
include "addprojectsubcontractors.php";
?>