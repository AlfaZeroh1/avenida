<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenants_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/nationalitys/Nationalitys_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4157";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4155";//Add
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
	
	
if($obj->action=="Save"){
	$tenants=new Tenants();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$tenants->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tenants=$tenants->setObject($obj);
		if($tenants->add($tenants)){
			
			//adding general journal account(s)
			$name=$obj->code." ".$obj->firstname." ".$obj->middlename." ".$obj->lastname;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$tenants->id;
			$obj->acctypeid=32;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			$error=SUCCESS;
			//redirect("vacant.php?tenantid=".$tenants->id);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tenants=new Tenants();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tenants->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tenants=$tenants->setObject($obj);
		if($tenants->edit($tenants)){
			
			//updating corresponding general journal account
			$name=$obj->firstname." ".$obj->middlename." ".$obj->lastname;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$tenants->id;
			$obj->acctypeid=29;
			$generaljournalaccounts->setObject($obj);
			$upwhere=" refid='$tenants->id' and acctypeid='29' ";
			$generaljournalaccounts->edit($generaljournalaccounts,$upwhere);
			
			$error=UPDATESUCCESS;
			redirect("addtenants_proc.php?id=".$tenants->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$nationalitys= new Nationalitys();
	$fields="sys_nationalitys.id, sys_nationalitys.name, sys_nationalitys.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$nationalitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$tenants=new Tenants();
	$where=" where id=$id ";
	$fields="em_tenants.id, em_tenants.code, em_tenants.firstname, em_tenants.middlename, em_tenants.lastname, em_tenants.postaladdress, em_tenants.address, em_tenants.registeredon, em_tenants.nationalityid, em_tenants.tel, em_tenants.mobile, em_tenants.fax, em_tenants.idno, em_tenants.passportno, em_tenants.dlno, em_tenants.occupation, em_tenants.email, em_tenants.dob";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tenants->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		
		$tenants = new Tenants();
		$fields=" (max(id)+1) code ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$ob=$tenants->fetchObject;
		
		$ob->code = str_pad($ob->code, 4, 0, STR_PAD_LEFT);
		
		$obj->code="T".$ob->code;
		
		$obj->nationalityid=93;
		
		$obj->action="Save";
		
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Tenants ";
include "addtenants.php";
?>