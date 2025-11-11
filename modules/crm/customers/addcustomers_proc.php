<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/agents/Agents_class.php");
require_once("../../crm/statuss/Statuss_class.php");
require_once("../../crm/departments/Departments_class.php");
require_once("../../crm/continents/Continents_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../crm/countrys/Countrys_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../pos/saletypes/Saletypes_class.php");
require_once("../../pos/freights/Freights_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4792";//Edit
}
else{
	$auth->roleid="4790";//Add
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
	$customers=new Customers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$customers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customers=$customers->setObject($obj);
		if($customers->add($customers)){

			if(!empty($obj->customerid) and !is_null($obj->customerid) and $obj->customerid!="NULL"){
			  $gna = new Generaljournalaccounts();
			  $fields="*";
			  $join="";
			  $having="";
			  $groupby="";
			  $where=" where refid='$obj->customerid' and acctypeid=29";
			  $orderby="";
			  $gna->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  $gna = $gna->fetchObject;
			  
			  $obj->categoryid=$gna->id;
			  
			}else{
			  $gna = new Generaljournalaccounts();
			  $fields="*";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $where=" where (refid='' or refid is null) and acctypeid=29 and currencyid='$obj->currencyid'";
			  $gna->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $gna->sql;
			  $gna = $gna->fetchObject;
			  
			  $obj->categoryid=$gna->id;
			}
			
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name;
			$obj->id="";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$customers->id;
			$obj->acctypeid=29;			
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);

			$error=SUCCESS;
			redirect("addcustomers_proc.php?id=".$customers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$customers=new Customers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$customers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customers=$customers->setObject($obj);
		if($customers->edit($customers)){

			if(!empty($obj->customerid) and !is_null($obj->customerid) and $obj->customerid!="NULL"){
			  $gna = new Generaljournalaccounts();
			  $fields="*";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $where=" where refid='$obj->customerid' and acctypeid=29";
			  $gna->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  $gna = $gna->fetchObject;
			  
			  $obj->categoryid=$gna->id;
			  
			}else{
			  $gna = new Generaljournalaccounts();
			  $fields="*";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $where=" where (refid='' or refid is null) and acctypeid=29 and currencyid='$obj->currencyid'";
			  $gna->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $gna->sql;
			  $gna = $gna->fetchObject;
			  
			  $obj->categoryid=$gna->id;
			}
			
			$gna2 = new Generaljournalaccounts();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where refid='$obj->id' and acctypeid=29";
			$gna2->retrieve($fields,$join,$where,$having,$groupby,$orderby);
						
			//updating corresponding general journal account
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$customers->id;
			$obj->acctypeid=29;
			$obj->id="";
			if($gna2->affectedRows>0){
			  $gna2 = $gna2->fetchObject;
			  $obj->id=$gna2->id;
			  $generaljournalaccounts = $generaljournalaccounts->setObject($obj);
			  $generaljournalaccounts->edit($generaljournalaccounts);
			}else{			  
			  
			  $generaljournalaccounts = $generaljournalaccounts->setObject($obj);
			  $generaljournalaccounts->add($generaljournalaccounts);
			}
			

			$error=UPDATESUCCESS;
			redirect("addcustomers_proc.php?id=".$customers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$agents= new Agents();
	$fields="crm_agents.id, crm_agents.name, crm_agents.address, crm_agents.tel, crm_agents.fax, crm_agents.email, crm_agents.statusid, crm_agents.remarks, crm_agents.createdby, crm_agents.createdon, crm_agents.lasteditedby, crm_agents.lasteditedon, crm_agents.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$statuss= new Statuss();
	$fields="crm_statuss.id, crm_statuss.name, crm_statuss.ipaddress, crm_statuss.createdby, crm_statuss.createdon, crm_statuss.lasteditedby, crm_statuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$departments= new Departments();
	$fields="crm_departments.id, crm_departments.name, crm_departments.remarks, crm_departments.createdby, crm_departments.createdon, crm_departments.lasteditedby, crm_departments.lasteditedon, crm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	


	$currencys= new Currencys();
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$customers=new Customers();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$customers->fetchObject;

	//for autocompletes
	$employees = new Employees();
	$fields=" * ";
	$where=" where id='$obj->employeeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$employees->fetchObject;

	$obj->employeename=$auto->name;
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$obj->statusid=1;
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Customers ";
include "addcustomers.php";
?>