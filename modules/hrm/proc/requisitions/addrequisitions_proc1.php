<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Requisitions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projects/Projects_class.php");
require_once("../requisitiondetails/Requisitiondetails_class.php");
require_once("../../proc/requisitions/Requisitions_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../pm/notifications/Notifications_class.php");
require_once("../../pm/notificationrecipients/Notificationrecipients_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../wf/routedetails/Routedetails_class.php");
require_once("../../inv/departments/Departments_class.php");
require_once("../../proc/config/Config_class.php");
require_once("../../proc/purchaseorderdetails/Purchaseorderdetails_class.php");
require_once("../../proc/purchaseorders/Purchaseorders_class.php");
require_once("../../proc/deliverynotedetails/Deliverynotedetails_class.php");
require_once("../../inv/unitofmeasures/Unitofmeasures_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8073";//Edit
}
else{
	$auth->roleid="8071";//Add
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

$config = new Config();
$fields=" * ";
$join="  ";
$where="";
$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);

while($con=mysql_fetch_object($config->result)){
	$_SESSION[$con->name]=$con->value;
}

if(!empty($ob->departmentid)){
  $obj->departmentid=$ob->departmentid;
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

if($obj->action=="First"){
  $requisitions = new Requisitions();
  $fields=" min(documentno) documentno ";
  $join="";
  $groupby="";
  $having="";
  $where=" ";
  $requisitions->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $requisitions=$requisitions->fetchObject;
  
  $obj->invoiceno=$requisitions->documentno;
  $obj->action="Filter";
  
}

if($obj->action=="Next"){
  $obj->invoiceno=($obj->documentno+1);
  $obj->action="Filter";
}

if($obj->action=="Previous"){
  $obj->invoiceno=($obj->documentno-1);
  $obj->action="Filter";
}

if($obj->action=="Last"){
  $requisitions = new Requisitions();
  $fields=" max(documentno) documentno ";
  $join="";
  $groupby="";
  $having="";
  $where=" ";
  $requisitions->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $requisitions=$requisitions->fetchObject;
  
  $obj->invoiceno=$requisitions->documentno;
  $obj->action="Filter";
  
}
		
if($obj->action=="Save"){
	$requisitions=new Requisitions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shprequisitions=$_SESSION['shprequisitions'];
	$error=$requisitions->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shprequisitions)){
		$error="No items in the sale list!";
	}
	else if(empty($obj->unitofmeasureid)){
			$error="Unit of measure must be provided";
		}
	else if(empty($obj->description)){
			$error="Req Description should be provided";
		}
	else{
		$requisitions=$requisitions->setObject($obj);
		if($requisitions->add($requisitions,$shprequisitions)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$requisitions=new Requisitions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$requisitions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$requisitions=$requisitions->setObject($obj);
		$shprequisitions=$_SESSION['shprequisitions'];
		if($requisitions->edit($requisitions,"",$shprequisitions)){
			$error=UPDATESUCCESS;
			$saved="Yes";
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->itemid)){
		$error=" Item must be provided";
	}
	elseif(empty($obj->quantity)){
		$error=" Qauntity must be provided";
	}
	elseif(empty($obj->requiredon)){
		$error=" Due Date must be provided";
	}
// 	elseif(addDate(date("Y-m-d"),$_SESSION['PROCUREMENT_DUR'])>=$obj->requiredon){
// 		$error=" Due Date must be beyond ".$_SESSION['PROCUREMENT_DUR']." days";
// 	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shprequisitions=$_SESSION['shprequisitions'];

	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;
	
	$unitofmeasures = new Unitofmeasures();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->unitofmeasureid'";
	$unitofmeasures->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$unitofmeasures=$unitofmeasures->fetchObject;

	;
	$shprequisitions[$it]=array('employeeid'=>"$obj->employeeid",'remarks'=>"$obj->remarks", 'itemid'=>"$obj->itemid", 'unitofmeasureid'=>"$obj->unitofmeasureid",'unitofmeasurename'=>"$unitofmeasures->name", 'itemname'=>"$items->name", 'memo'=>"$obj->memo", 'costprice'=>"$obj->costprice", 'quantity'=>"$obj->quantity", 'requiredon'=>"$obj->requiredon", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shprequisitions']=$shprequisitions;

	$obj->remarks="";
 	$obj->itemid="";
 	$obj->itemname="";
 	$obj->costprice="";
 	$obj->quantity="";
 	$obj->requiredon="";
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

}

if(!empty($id)){
	$requisitions=new Requisitions();
	$where=" where id=$id ";
	$fields="proc_requisitions.id, proc_requisitions.documentno,proc_requisitions.description, proc_requisitions.type, proc_requisitions.projectid, proc_requisitions.requisitiondate, proc_requisitions.remarks, proc_requisitions.status, proc_requisitions.file, proc_requisitions.ipaddress, proc_requisitions.createdby, proc_requisitions.createdon, proc_requisitions.lasteditedby, proc_requisitions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$requisitions->fetchObject;

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
}
if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$requisitions = new Requisitions();
		$fields="proc_requisitiondetails.id, proc_requisitiondetails.requisitionid, proc_requisitiondetails.unitofmeasureid, inv_unitofmeasures.name unitofmeasurename, proc_requisitions.departmentid, proc_requisitions.documentno,proc_requisitions.description, inv_items.id as itemid,inv_items.name itemname, proc_requisitiondetails.quantity, proc_requisitiondetails.costprice, proc_requisitiondetails.total, proc_requisitiondetails.memo, proc_requisitions.requisitiondate, proc_requisitions.remarks, proc_requisitions.status, proc_requisitions.ipaddress, proc_requisitions.createdby, proc_requisitiondetails.requiredon, proc_requisitions.createdon, proc_requisitions.lasteditedby, proc_requisitions.lasteditedon,proc_requisitions.employeeid";
		$join=" left join proc_requisitiondetails on proc_requisitiondetails.requisitionid=proc_requisitions.id left join inv_items on proc_requisitiondetails.itemid=inv_items.id left join inv_unitofmeasures on inv_unitofmeasures.id=proc_requisitiondetails.unitofmeasureid  "; echo $sql;
		$having="";
		$groupby="";
		$orderby="";
		$where=" where proc_requisitions.documentno='$obj->invoiceno'";
		$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$requisitions->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$purchaseorderdetails = new Purchaseorderdetails();
			$fields="sum(proc_purchaseorderdetails.quantity) ordered, group_concat(proc_purchaseorders.documentno) lpono";
			$join=" left join proc_purchaseorders on proc_purchaseorders.id=proc_purchaseorderdetails.purchaseorderid ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where proc_purchaseorders.requisitionno='$obj->invoiceno' and itemid='$row->itemid' ";
			$purchaseorderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $purchaseorderdetails->sql;
			$purchaseorderdetails=$purchaseorderdetails->fetchObject;
			
			$deliverynotedetails = new Deliverynotedetails();
			$fields="sum(proc_deliverynotedetails.quantity) delivered";
			$join=" left join proc_deliverynotes on proc_deliverynotes.id=proc_deliverynotedetails.deliverynoteid ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where proc_deliverynotes.lpono='$purchaseorderdetails->documentno' and itemid='$row->itemid' ";
			$deliverynotedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$deliverynotedetails=$deliverynotedetails->fetchObject;
			
			$ob=$row;
			$row->total=$row->quantity*$row->costprice;
			$shprequisitions[$it]=array('id'=>"$row->id",'remarks'=>"$row->remarks", 'unitofmeasureid'=>"$row->unitofmeasureid",'unitofmeasurename'=>"$row->unitofmeasurename", 'itemid'=>"$row->itemid",'requiredon'=>"$row->requiredon", 'itemname'=>"$row->itemname", 'costprice'=>"$row->costprice", 'quantity'=>"$row->quantity", 'total'=>"$row->total",'ordered'=>"$purchaseorderdetails->ordered",'lpono'=>"$purchaseorderdetails->lpono",'delivered'=>"$deliverynotedetails->delivered");

			$it++;
		}

		//for autocompletes
		$suppliers = new Suppliers();
		$fields=" * ";
		$where=" where id='$ob->supplierid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$auto=$suppliers->fetchObject;
		$auto->suppliername=$auto->name;
		
		$employees = new Employees();
		$fields=" concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name ";
		$where=" where id='$ob->employeeid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$auto3=$employees->fetchObject;
		$auto3->employeename=$auto3->name;
		
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
		$obj = (object) array_merge((array) $obj, (array) $auto3);
		
		$obj->remarks="";
		$obj->itemid="";
		$obj->itemname="";
		$obj->costprice="";
		$obj->quantity="";
		$obj->requiredon="";
		 
		 
		$obj->iterator=$it;
		
		$obj->action="Update";
		$_SESSION['shprequisitions']="";
		$_SESSION['obj']=$obj;
		$_SESSION['shprequisitions']=$shprequisitions;
	}
}

if($obj->action=="Raise LPO"){
  $shprequisitions=$_SESSION['shprequisitions'];
  
  $num = count($shprequisitions);
  $i=0;
  $k=0;
  while($i<$num){
  
      $ob->projectid = $obj->projectid;
      $ob->projectname = $obj->projectname;
      $ob->requisitionno = $obj->documentno;
      $_SESSION['ob']=$ob;
      
    if(isset($_POST[$shprequisitions[$i]['id']])){
      $shppurchaseorders[$k]=$shprequisitions[$i];
      $k++;
    }
    $i++;
  }
  
  $_SESSION['shppurchaseorders']=$shppurchaseorders;
  $_SESSION['shprequisitions']="";
  
  redirect("../purchaseorders/addpurchaseorders_proc.php?raise=1");
}

if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
      if(empty($obj->action) and empty($obj->action2)){
	$_SESSION['shprequisitions']="";
			  
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from proc_requisitions"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->requisitiondate=date("Y-m-d");	
	
      }
      $obj->action="Save";
  } 
  else{
    $obj=$_SESSION['obj'];
  }
  
}
else{  
    $obj->action="Update";
}
	
	
$page_title="Requisitions ";
include "addrequisitions.php";
?>