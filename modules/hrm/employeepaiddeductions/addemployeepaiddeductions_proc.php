<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepaiddeductions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/deductions/Deductions_class.php");
require_once("../../hrm/loans/Loans_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1146";//Edit
}
else{
	$auth->roleid="1144";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->reducing)){
  $obj->reducing=$ob->reducing;
}

if(!empty($ob->loanid)){
  $obj=$ob;
  
  $obj->deductionid=4;
  
  $employees= new Employees();
  $fields="hrm_employees.id, hrm_employees.pfnum, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as name, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='$obj->employeeid'";
  $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $employees = $employees->fetchObject;
  
  $obj->employeename=$employees->name;
}

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
	$employeepaiddeductions=new Employeepaiddeductions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$employeepaiddeductions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepaiddeductions=$employeepaiddeductions->setObject($obj);
		if($employeepaiddeductions->add($employeepaiddeductions)){
			$error=SUCCESS;
			
			if(!empty($obj->loanid)){
			  $sql="update hrm_employeeloans set principal=principal-$obj->amount where id='$obj->employeeloanid'";
			  mysql_query($sql);
			}
			redirect("addemployeepaiddeductions_proc.php?id=".$employeepaiddeductions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeepaiddeductions=new Employeepaiddeductions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeepaiddeductions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepaiddeductions=$employeepaiddeductions->setObject($obj);
		if($employeepaiddeductions->edit($employeepaiddeductions)){
			$error=UPDATESUCCESS;
			redirect("addemployeepaiddeductions_proc.php?id=".$employeepaiddeductions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$deductions= new Deductions();
	$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductions.deductiontypeid, hrm_deductions.duedate, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.amount, hrm_deductions.overall, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon, hrm_deductions.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$loans= new Loans();
	$fields="hrm_loans.id, hrm_loans.name, hrm_loans.method, hrm_loans.description, hrm_loans.createdby, hrm_loans.createdon, hrm_loans.lasteditedby, hrm_loans.lasteditedon, hrm_loans.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeepaiddeductions=new Employeepaiddeductions();
	$where=" where hrm_employeepaiddeductions.id=$id ";
	$fields="hrm_employeepaiddeductions.id, hrm_employeepaiddeductions.employeepaymentid, hrm_employeepaiddeductions.deductionid, hrm_employeepaiddeductions.loanid, hrm_employeepaiddeductions.employeeid,concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) as employeename, hrm_employeepaiddeductions.amount, hrm_employeepaiddeductions.month, hrm_employeepaiddeductions.year, hrm_employeepaiddeductions.paidon, hrm_employeepaiddeductions.createdby, hrm_employeepaiddeductions.createdon, hrm_employeepaiddeductions.lasteditedby, hrm_employeepaiddeductions.lasteditedon, hrm_employeepaiddeductions.ipaddress, hrm_employeepaiddeductions.reducing";
	$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
	$having="";
	$groupby="";
	$orderby="";
	$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	$obj=$employeepaiddeductions->fetchObject;

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
	
	
$page_title="Employeepaiddeductions ";
include "addemployeepaiddeductions.php";
?>
