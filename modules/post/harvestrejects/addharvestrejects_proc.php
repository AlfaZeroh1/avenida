<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Harvestrejects_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/rejecttypes/Rejecttypes_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../pos/itemstocks/Itemstocks_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../prod/blocks/Blocks_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");
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

if(empty($obj->action)){
	$defs=mysql_fetch_object(mysql_query("select max(documentno)+1 documentno from post_harvestrejects "));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

// 	$obj->soldon=date('Y-m-d');

}
	
	
if($obj->action=="Save"){
	$harvestrejects=new Harvestrejects();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$harvestrejects->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$harvestrejects=$harvestrejects->setObject($obj);
		$shprejects=$_SESSION['shprejects'];
		if($harvestrejects->add($harvestrejects, $shprejects)){
			$error=SUCCESS;
			
// 			unset($_SESSION['harvestrejects']);
			unset($_SESSION['shprejects']);
			$saved="Yes";
			//redirect("addharvestrejects_proc.php?readon=".$obj->readon."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$harvestrejects=new Harvestrejects();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$harvestrejects->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$harvestrejects=$harvestrejects->setObject($obj);
		$harvestrejects->reduce=$obj->reduce;
		$shprejects=$_SESSION['shprejects'];
		if($harvestrejects->edit($harvestrejects,$shprejects)){
			$error=UPDATESUCCESS;
			unset($_SESSION['$harvestrejects']);
			unset($_SESSION['$shprejects']);
			//redirect("addharvestrejects_proc.php?id=".$harvestrejects->id."&error=".$error);
			$saved="Yes";
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

// if($obj->action2=="Add"){
// 
// 	if(empty($obj->sizeid)){
// 		$error="Size must be provided";
// 	}
// 	elseif(empty($obj->itemid)){
// 		$error="Item must be provided";
// 	}
// 	elseif(empty($obj->quantity)){
// 		$error="Quantity must be provided";
// 	}
// 	else{
// 	$_SESSION['obj']=$obj;
// 	if(empty($obj->iterator))
// 		$it=0;
// 	else
// 		$it=$obj->iterator;
// 	$shprejects=$_SESSION['shprejects'];
// 
// 	$sizes = new Sizes();
// 	$fields=" * ";
// 	$join="";
// 	$groupby="";
// 	$having="";
// 	$where=" where id='$obj->sizeid'";
// 	$sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 	$sizes=$sizes->fetchObject;
// 	
// 	$items = new Items();
// 	$fields=" * ";
// 	$join="";
// 	$groupby="";
// 	$having="";
// 	$where=" where id='$obj->itemid'";
// 	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 	$items=$items->fetchObject;
// 	
// 	$employees = new Employees();
// 	$fields=" * ";
// 	$join="";
// 	$groupby="";
// 	$having="";
// 	$where=" where id='$obj->employeeid'";
// 	$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 	$employees=$employees->fetchObject;
// 	$shprejects[$it]=array('sizeid'=>"$obj->sizeid", 'sizename'=>"$sizes->name", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'quantity'=>"$obj->quantity", 'employeeid'=>"$obj->employeeid", 'employeename'=>"$employees->name",'downsize'=>"$obj->downsize",'barcode'=>"$obj->barcode=$obj->barcode2");
// 
//  	$it++;
// 		$obj->iterator=$it;
//  	$_SESSION['shprejects']=$shprejects;
// 
//  	$obj->barcode="";
//  	$obj->barcode2="";
// 	$obj->sizename="";
//  	$obj->sizeid="";
//  	$obj->itemname="";
//  	$obj->itemid="";
//  	$obj->quantity="";
//  	$obj->employeename="";
//  	$obj->employeeid="";
//  	$obj->total=0;
// }
// }

if($obj->action2=="Add"){
  if(empty($obj->rejecttypeid)){
	  $error="Reject Type should be provided";
  }
// 		else if(empty($obj->sizeid)){
// 			$error="Size should be provided";
// 		}
  else if(empty($obj->itemid)){
	  $error="Product should be provided";
  }
  else if(empty($obj->quantity)){
	  $error="Quantity should be provided";
  }
  elseif(empty($obj->barcode2) and $obj->reduce=="reduce"){
	  $error=" Employee barcode must be Scanned!";
  }  
  elseif(empty($obj->datecode) and $obj->reduce=="reduce"){
	  $error=" Employee barcode must be Scanned!";
  } 
  else{
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
	
// 	
	
	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;
	
	$rejecttypes = new Rejecttypes();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->rejecttypeid'";
	$rejecttypes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$rejecttypes=$rejecttypes->fetchObject;
	
	$blocks = new Blocks();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->blockid'";
	$blocks->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$blocks=$blocks->fetchObject;
	
	$employees = new Employees();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->employeeid'";
	$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$employees=$employees->fetchObject;
	$shprejects[$it]=array('sizeid'=>"$obj->sizeid", 'sizename'=>"$sizes->name", 'blockid'=>"$obj->blockid", 'blockname'=>"$blocks->name",'itemid'=>"$obj->itemid", 'documentno'=>"$obj->documentno", 'itemname'=>"$items->name", 'quantity'=>"$obj->quantity", 'employeeid'=>"$obj->employeeid", 'employeename'=>"$employees->name",'rejecttypeid'=>"$obj->rejecttypeid",'rejecttypename'=>"$rejecttypes->name",'datecode'=>"$obj->datecode",'barcode'=>"$obj->barcode=$obj->barcode2",'remarks'=>"$obj->remarks");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shprejects']=$shprejects;
 	
 	$obj->itemid="";
 	$obj->datecode="";
 	$obj->sizeid="";
 	$obj->quantity="";
 	$obj->employeeid="";
 	$obj->employeename;
 	$obj->remarks="";
 	$obj->blockid="";
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


	$items= new Items();
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.sizeid, pos_items.price, pos_items.tax, pos_items.stock, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$harvestrejects=new Harvestrejects();
	$where=" where id=$id ";
	$fields="post_harvestrejects.id,post_harvestrejects.documentno, post_harvestrejects.rejecttypeid, post_harvestrejects.sizeid, post_harvestrejects.itemid, post_harvestrejects.quantity, post_harvestrejects.gradedon, post_harvestrejects.reportedon, post_harvestrejects.employeeid, post_harvestrejects.barcode, post_harvestrejects.remarks, post_harvestrejects.status, post_harvestrejects.ipaddress, post_harvestrejects.createdby,post_harvestrejects.blockid, post_harvestrejects.createdon, post_harvestrejects.lasteditedby, post_harvestrejects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$harvestrejects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$harvestrejects->fetchObject;

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
// 		unset($_SESSION['shprejects']);
		$obj->reportedon=date("Y-m-d");
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Harvestrejects ";
include "addharvestrejects.php";
?>