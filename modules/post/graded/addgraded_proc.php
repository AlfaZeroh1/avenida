<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Graded_class.php");
require_once("../../auth/rules/Rules_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/sizes/Sizes_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../pos/itemstocks/Itemstocks_class.php");
require_once("../../sys/ipaddress/Ipaddress_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8621";//Edit
}
else{
	$auth->roleid="8619";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->status)){
  $obj->status=$ob->status;
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
	$graded=new Graded();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpgraded=$_SESSION['shpgraded'];
	$error=$graded->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpgraded)){
		$error="No items in the sale list!";
	}
	else{
		$graded=$graded->setObject($obj);
		if($graded->add($graded,$shpgraded)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$graded=new Graded();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$graded->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$graded=$graded->setObject($obj);
		$shpgraded=$_SESSION['shpgraded'];
		if($graded->edit($graded,$shpgraded)){
			$error=UPDATESUCCESS;
			redirect("addgraded_proc.php?id=".$graded->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){
       if(empty($obj->sizeid)){
		$error="Size must be provided";
	}
	elseif(empty($obj->itemid)){
		$error="Item must be provided";
	}
	elseif(empty($obj->quantity)){
		$error="Quantity must be provided";
	}
	elseif(empty($obj->employeeid)){
		$error="Employee must be provided";
	}
	elseif(empty($obj->barcode2)){
		$error="Employee barcode must be scanned!";
	}
	
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpgraded=$_SESSION['shpgraded'];

	$sizes = new Sizes();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->sizeid'";
	$sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$sizes=$sizes->fetchObject;
	
	$greenhouses = new Sizes();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->greenhouseid'";
	$greenhouses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$greenhouses=$greenhouses->fetchObject;
	
	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;
	
	$employees = new Employees();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->employeeid'";
	$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$employees=$employees->fetchObject;
	
	$shpgraded[$it]=array('sizeid'=>"$obj->sizeid", 'sizename'=>"$sizes->name", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'greenhouseid'=>"$obj->greenhouseid", 'greenhousename'=>"$greenhouses->greenhousename",'quantity'=>"$obj->quantity", 'employeeid'=>"$obj->employeeid", 'datecode'=>"$obj->datecode", 'employeename'=>"$employees->name",'downsize'=>"$obj->downsize",'barcode'=>"$obj->barcode=$obj->barcode2");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpgraded']=$shpgraded;

 	$obj->barcode="";
 	$obj->datecode="";
 	$obj->barcode2="";
	$obj->sizename="";
 	$obj->sizeid="";
 	$obj->itemname="";
 	$obj->itemid="";
 	$obj->quantity="";
 	$obj->employeename="";
 	$obj->greenhouseid="";
 	$obj->greenhousename="";
 	$obj->employeeid="";
 	$obj->total=0;
}
}

if(empty($obj->action)){

	$sizes= new Sizes();
	$fields="prod_sizes.id, prod_sizes.name, prod_sizes.remarks, prod_sizes.ipaddress, prod_sizes.createdby, prod_sizes.createdon, prod_sizes.lasteditedby, prod_sizes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$graded=new Graded();
	$where=" where id=$id ";
	$fields="post_graded.id, post_graded.sizeid, post_graded.itemid,post_graded.greenhouseid, post_graded.quantity, post_graded.gradedon, post_graded.employeeid, post_graded.downsize, post_graded.barcode, post_graded.remarks, post_graded.status, post_graded.ipaddress, post_graded.createdby, post_graded.createdon, post_graded.lasteditedby, post_graded.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$graded->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$graded->fetchObject;

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
		$obj->gradedon=date("Y-m-d");
	}
	else{
		$obj=$_SESSION['obj'];
	}
	if(empty($obj->action2)){
		$_SESSION['shpgraded']="";
		unset($_SESSION['shpgraded']);
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Graded ";
include "addgraded.php";
?>
