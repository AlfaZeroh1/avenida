<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rejects_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/rejecttypes/Rejecttypes_class.php");
require_once("../../prod/sizes/Sizes_class.php");
require_once("../../prod/varietystocks/Varietystocks_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");
require_once("../../prod/varietys/Varietys_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8625";//Edit
}
else{
	$auth->roleid="8623";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->reduce)){
  $obj->reduce=$ob->reduce;
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
	$rejects=new Rejects();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$rejects->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$rejects=$rejects->setObject($obj);
		$shprejects=$_SESSION['shprejects'];//print_r($shprejects);
		if($rejects->add($rejects, $shprejects)){
			$error=SUCCESS;
			$saved="Yes";
			//redirect("addrejects_proc.php?readon=".$obj->readon."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$rejects=new Rejects();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$rejects->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$rejects=$rejects->setObject($obj);
		$rejects->reduce=$obj->reduce;
		$shprejects=$_SESSION['shprejects'];
		if($rejects->edit($rejects,$shprejects)){
			$error=UPDATESUCCESS;
			//redirect("addrejects_proc.php?id=".$rejects->id."&error=".$error);
			$saved="Yes";
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if($obj->action2=="Add"){
  if(empty($obj->rejecttypeid)){
	  $error="Reject Type should be provided";
  }
// 		else if(empty($obj->sizeid)){
// 			$error="Size should be provided";
// 		}
  else if(empty($obj->varietyid)){
	  $error="Variety should be provided";
  }
  else if(empty($obj->quantity)){
	  $error="Quantity should be provided";
  }else{
    $_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shprejects=$_SESSION['shprejects'];
	$sizes = new Sizes();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->sizeid'";
	$sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$sizes=$sizes->fetchObject;
	
	$varietys = new Varietys();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->varietyid'";
	$varietys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$varietys=$varietys->fetchObject;
	
	$rejecttypes = new Rejecttypes();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->rejecttypeid'";
	$rejecttypes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$rejecttypes=$rejecttypes->fetchObject;
	
	$employees = new Employees();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->employeeid'";
	$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$employees=$employees->fetchObject;
	$shprejects[$it]=array('sizeid'=>"$obj->sizeid", 'sizename'=>"$sizes->name", 'varietyid'=>"$obj->varietyid", 'greenhouseid'=>"$obj->greenhouseid", 'varietyname'=>"$varietys->name", 'quantity'=>"$obj->quantity", 'employeeid'=>"$obj->employeeid", 'employeename'=>"$employees->name",'rejecttypeid'=>"$obj->rejecttypeid",'rejecttypename'=>"$rejecttypes->name",'remarks'=>"$obj->remarks");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shprejects']=$shprejects;
 	
 	
 	
 	$obj->varietyid="";
 	$obj->sizeid="";
 	$obj->quantity="";
 	$obj->employeeid="";
 	$obj->employeename;
 	$obj->remarks="";
  }
  
}

if(empty($obj->action)){

	$rejecttypes= new Rejecttypes();
	$fields="prod_rejecttypes.id, prod_rejecttypes.name, prod_rejecttypes.remarks, prod_rejecttypes.ipaddress, prod_rejecttypes.createdby, prod_rejecttypes.createdon, prod_rejecttypes.lasteditedby, prod_rejecttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$sizes= new Sizes();
	$fields="prod_sizes.id, prod_sizes.name, prod_sizes.remarks, prod_sizes.ipaddress, prod_sizes.createdby, prod_sizes.createdon, prod_sizes.lasteditedby, prod_sizes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	
	$greenhouses= new Greenhouses();
	$fields="prod_greenhouses.id, prod_greenhouses.name, prod_greenhouses.sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$varietys= new Varietys();
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.stems,    prod_varietys.remarks, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon, prod_varietys.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$rejects=new Rejects();
	$where=" where id=$id ";
	$fields="prod_rejects.id, prod_rejects.rejecttypeid, prod_rejects.varietyid, prod_rejects.sizeid, prod_rejects.plantingdetailid, prod_rejects.greenhouseid, prod_rejects.quantity, prod_rejects.employeeid, prod_rejects.barcode, prod_rejects.harvestedon, prod_rejects.reportedon, prod_rejects.remarks, prod_rejects.status, prod_rejects.ipaddress, prod_rejects.createdby, prod_rejects.createdon, prod_rejects.lasteditedby, prod_rejects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rejects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$rejects->fetchObject;

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
// 		$_SESSION['shprejects']="";
		
		$obj->reportedon=date("Y-m-d");
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	//print_r($shprejects);
$page_title="Rejects ";
include "addrejects.php";
?>