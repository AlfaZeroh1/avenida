<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Checklists_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../tender/tenders/Tenders_class.php");
require_once("../../tender/checklistcategorys/Checklistcategorys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7753";//Edit
}
else{
	$auth->roleid="7751";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);
require_once("../../tender/checklistdocuments/Checklistdocuments_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");
require_once("../../dms/documentss/Documentss_class.php");
require_once("../../sys/config/Config_class.php");
require_once("../../sys/modules/Modules_class.php");

//Process delete of checklistdocuments
if(!empty($_GET['checklistdocuments'])){
	$checklistdocuments = new Checklistdocuments();
	$checklistdocuments->id=$_GET['checklistdocuments'];
	$checklistdocuments->delete($checklistdocuments);
}


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
	$checklists=new Checklists();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$checklists->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checklists=$checklists->setObject($obj);
		if($checklists->add($checklists)){
			$error=SUCCESS;
			redirect("addchecklists_proc.php?id=".$checklists->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$checklists=new Checklists();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$checklists->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checklists=$checklists->setObject($obj);
		if($checklists->edit($checklists)){
			$error=UPDATESUCCESS;
			redirect("addchecklists_proc.php?id=".$checklists->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

//Process adding of checklistdocuments
if($obj->action=="Add Checklistdocument"){
	$checklistdocuments = new Checklistdocuments();

	$ob->checklistid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->title=$obj->checklistdocumentstitle;
	$ob->documenttypeid=$obj->checklistdocumentsdocumenttypeid;

		$file=$_FILES['checklistdocumentsfile']['tmp_name'];
		$filename=$_FILES['checklistdocumentsfile']['name'];
		$ob->file=$filename;

	$ob->remarks=$obj->checklistdocumentsremarks;

	$error=$checklistdocuments->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		

		//create a resource folder
			$config = new Config();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where name='DMS_RESOURCE'";
			$config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$config=$config->fetchObject;
			
			//get module name
			$module = new Modules();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id=24 ";
			$module->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$module=$module->fetchObject;
			
			$tenders = new Tenders();
			$fields=" tender_tendertypes.name, tender_tenders.proposalno ";
			$join=" left join tender_tendertypes on tender_tendertypes.id=tender_tenders.tendertypeid left join tender_checklists on tender_checklists.tenderid=tender_tenders.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where tender_checklists.id='$obj->id' ";
			$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$tenders=$tenders->fetchObject;
			
			$documenttypes=new Documenttypes();
			$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where dms_documenttypes.id ='$ob->documenttypeid' ";
			$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$documenttypes=$documenttypes->fetchObject;
			
			//@mkdir($config->value."".$module->name);
			//@mkdir($config->value."".$module->name."/".$tenders->name);
			//@mkdir($config->value."".$module->name."/".$tenders->name."/".$tenders->proposalno);
			//@mkdir($config->value."".$module->name."/".$tenders->name."/".$tenders->proposalno."/".$documenttypes->name);
			//copy($file,$config->value."".$module->name."/".$tenders->name."/".$tenders->proposalno."/".$documenttypes->name."/".$filename);
			
			$ext = explode(".",$filename);
			
			$nm=count($ext);
			
			$ob->document=$ob->title.".".$ext[$nm-1];
			$ob->file=$file;
			
			$ob->link=$module->name."/".$tenders->name."/".$tenders->proposalno."/".$documenttypes->name;
			
			
			$documents = new Documentss();
			
			$error = $documents->validate($ob);
			if(!empty($error)){
				$error=$error;
			}
			else{
			if(empty($ob->routeid))
			  $ob->routeid='NULL';
			if($documents->add($ob)){
			
			  $ob->file=$ob->document;
			  $checklistdocuments->setObject($ob);
			  
			  if($checklistdocuments->add($checklistdocuments)){
				      
				  $obj->checklistdocumentstitle="";
				  $obj->checklistdocumentsdocumenttypeid="";
				  $obj->checklistdocumentsfile="";
				  $obj->checklistdocumentsremarks="";
				  $error=SUCCESS;
				  
			  }else{
				  $error=FAILURE;
			  }
			 }
			 else{
			  $error=FAILURE;
			 }
			}
	}
	redirect("addchecklists_proc.php?id=".$obj->id."&error=".$error);
}

if(empty($obj->action)){

	$tenders= new Tenders();
	$fields="tender_tenders.id, tender_tenders.proposalno, tender_tenders.name, tender_tenders.tendertypeid, tender_tenders.datereceived, tender_tenders.actionplandate, tender_tenders.dateofreview, tender_tenders.dateofsubmission, tender_tenders.employeeid, tender_tenders.Statusid, tender_tenders.remarks, tender_tenders.ipaddress, tender_tenders.createdby, tender_tenders.createdon, tender_tenders.lasteditedby, tender_tenders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$checklistcategorys= new Checklistcategorys();
	$fields="tender_checklistcategorys.id, tender_checklistcategorys.name, tender_checklistcategorys.remarks, tender_checklistcategorys.ipaddress, tender_checklistcategorys.createdby, tender_checklistcategorys.createdon, tender_checklistcategorys.lasteditedby, tender_checklistcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checklistcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$checklists=new Checklists();
	$where=" where id=$id ";
	$fields="tender_checklists.id, tender_checklists.name, tender_checklists.checklistcategoryid, tender_checklists.tenderid, tender_checklists.description, tender_checklists.deadline, tender_checklists.status, tender_checklists.doneon, tender_checklists.completedon, tender_checklists.remarks, tender_checklists.ipaddress, tender_checklists.createdby, tender_checklists.createdon, tender_checklists.lasteditedby, tender_checklists.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checklists->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$checklists->fetchObject;

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
	
	
$page_title="Checklists ";
include "addchecklists.php";
?>