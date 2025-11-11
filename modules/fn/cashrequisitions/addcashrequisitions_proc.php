<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Cashrequisitions_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/expenses/Expenses_class.php");
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../fn/cashrequisitiondetails/Cashrequisitiondetails_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projects/Projects_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8141";//Edit
}
else{
	$auth->roleid="8139";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->documentno)){
  $obj->invoiceno=$ob->documentno;
  $obj->action="Filter";
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

$status=$_GET['status'];
if(empty($obj->status)){
  $obj->status='pending';
}

	
	
if($obj->action=="Save"){
	$cashrequisitions=new Cashrequisitions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpcashrequisitions=$_SESSION['shpcashrequisitions'];
	$error=$cashrequisitions->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpcashrequisitions)){
		$error="No items in the sale list!";
	}
	else{
		$cashrequisitions=$cashrequisitions->setObject($obj);
		if($cashrequisitions->add($cashrequisitions,$shpcashrequisitions)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$cashrequisitions=new Cashrequisitions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$cashrequisitions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$cashrequisitions=$cashrequisitions->setObject($obj);
		$shpcashrequisitions=$_SESSION['shpcashrequisitions'];
		if($cashrequisitions->edit($cashrequisitions,'',$shpcashrequisitions)){
			$error=UPDATESUCCESS;
			$saved="Yes";
 			redirect("addcashrequisitions_proc.php?id=".$cashrequisitions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->expenseid)){
		$error=" must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpcashrequisitions=$_SESSION['shpcashrequisitions'];

	$expenses = new Expenses();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->expenseid'";
	$expenses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$expenses=$expenses->fetchObject;

	;
	$shpcashrequisitions[$it]=array('expenseid'=>"$obj->expenseid", 'expensename'=>"$expenses->name", 'quantity'=>"$obj->quantity", 'amount'=>"$obj->amount", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpcashrequisitions']=$shpcashrequisitions;

	$obj->expenseid="";
 	$obj->quantity="";
 	$obj->amount="";
 }
}

if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
	
		$cashrequisitions = new Cashrequisitions();
		$fields="fn_cashrequisitiondetails.expenseid, fn_cashrequisitions.documentno, fn_expenses.name expensename, fn_cashrequisitions.projectid, fn_cashrequisitions.employeeid, fn_cashrequisitions.description, fn_cashrequisitiondetails.quantity, fn_cashrequisitiondetails.amount, fn_cashrequisitiondetails.total, fn_cashrequisitions.status";
		$join=" left join fn_cashrequisitiondetails on fn_cashrequisitiondetails.cashrequisitionid=fn_cashrequisitions.id left join fn_expenses on fn_expenses.id=fn_cashrequisitiondetails.expenseid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_cashrequisitions.documentno='$obj->invoiceno'";
		$cashrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$cashrequisitions->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			//$row->total=$row->quantity*$row->costprice;
			$shpcashrequisitions[$it]=array('expenseid'=>"$ob->expenseid", 'expensename'=>"$ob->expensename", 'quantity'=>"$ob->quantity", 'amount'=>"$ob->amount", 'total'=>"$ob->total");

			$it++;
		}

		//for autocompletes
		$employees = new Employees();
		$fields=" concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name ";
		$where=" where id='$ob->employeeid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$auto=$employees->fetchObject;
		$auto->employeename=$auto->name;
		
		$projects = new Projects();
		$fields=" * ";
		$where=" where id='$ob->projectid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$auto2=$projects->fetchObject;
		$auto2->projectname=$auto2->name;

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);	
		$obj = (object) array_merge((array) $obj, (array) $auto2);		
			
		$obj->iterator=$it;
		
		$obj->action="Update";
		
		$_SESSION['obj']=$obj;
		$_SESSION['shpcashrequisitions']=$shpcashrequisitions;
	}
	$obj->remarks="";
 	$obj->itemid="";
 	$obj->itemname="";
 	$obj->costprice="";
 	$obj->quantity="";
 	$obj->amount="";
 	$obj->expenseid="";
 	$obj->total="";
 	$obj->requiredon="";
}

if(empty($obj->action)){

	$projects= new Projects();
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$cashrequisitions=new Cashrequisitions();
	$where=" where id=$id ";
	$fields="fn_cashrequisitions.id, fn_cashrequisitions.documentno, fn_cashrequisitions.projectid, fn_cashrequisitions.employeeid, fn_cashrequisitions.description, fn_cashrequisitions.status, fn_cashrequisitions.remarks, fn_cashrequisitions.ipaddress, fn_cashrequisitions.createdby, fn_cashrequisitions.createdon, fn_cashrequisitions.lasteditedby, fn_cashrequisitions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$cashrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$cashrequisitions->fetchObject;

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
	
	
}

if($obj->action=="Give Imprest"){
  $ob->amount=$obj->ttotal;
  
    //get employee that requested
    $cashrequisitions = new Cashrequisitions();
    $fields=" fn_cashrequisitions.employeeid, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeename ";
    $join=" left join hrm_employees on hrm_employees.id=fn_cashrequisitions.employeeid ";
    $having="";
    $groupby="";
    $orderby="";
    $where=" where fn_cashrequisitions.documentno in($obj->documentno) ";
    $cashrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $cashrequisitions->sql;
    $cashrequisitions = $cashrequisitions->fetchObject;
  
  $ob->employeeid=$cashrequisitions->employeeid;
  $ob->employeename=$cashrequisitions->employeename;
  $ob->memo=" Cash Requisitions #".$obj->documentno;
  $ob->paymentmodeid=1;
  
  $_SESSION['ob']=$ob;
  
  redirect("../../fn/imprests/addimprests_proc.php?raise=1");
}
if($obj->action=="Enter Expense"){
  $ob->amount=$obj->ttotal;
  
    //get employee that requested
    $cashrequisitions = new Cashrequisitions();
    $fields=" fn_cashrequisitions.employeeid, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeename ";
    $join=" left join hrm_employees on hrm_employees.id=fn_cashrequisitions.employeeid ";
    $having="";
    $groupby="";
    $orderby="";
    $where=" where fn_cashrequisitions.documentno in($obj->documentno) ";
    $cashrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $cashrequisitions->sql;
    $cashrequisitions = $cashrequisitions->fetchObject;
  
  $ob->employeeid=$cashrequisitions->employeeid;
  $ob->typeid=2;
  $ob->employeename=$cashrequisitions->employeename;
  $ob->documentno=$obj->documentno;
  $ob->paymentmodeid=1;  
  $ob->employeeid=$cashrequisitions->employeeid;
  
  $_SESSION['ob']=$ob;//print_r($_SESSION['ob']);
    
  redirect("../../fn/exptransactions/addexptransactions_proc.php?raise=1&documentno=$obj->documentno");
}
if(empty($obj->retrieve)){ 
  if(empty($_GET['edit'])){  
      if(empty($obj->action) and empty($obj->action2)){ 
		
		$projects= new Projects();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='".$_SESSION['projectid']."'";
		$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$projects = $projects->fetchObject;
		
		$obj->projectid=$projects->id;
		$obj->projectname=$projects->name;
		
		
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from fn_cashrequisitions"));
		if($defs->documentno == null){
		$defs->documentno=1;
	        }else{
	        $obj->documentno=$defs->documentno;
	        }
	}
	$obj->action="Save";
	
	
	$employees = new Employees();
	$fields=" hrm_employees.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) name ";
	$where=" where auth_users.id='".$_SESSION['userid']."'";
	$join=" left join auth_users on auth_users.employeeid=hrm_employees.id ";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto3=$employees->fetchObject;
	$obj->employeename=$auto3->name;
	$obj->employeeid=$auto3->id;
	
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
else{
	$obj->action="Update";
}
	
	
$page_title="Cashrequisitions ";
include "addcashrequisitions.php";
?>