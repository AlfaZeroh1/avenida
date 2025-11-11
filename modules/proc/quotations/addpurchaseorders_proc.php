<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchaseorders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projects/Projects_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../purchaseorderdetails/Purchaseorderdetails_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../proc/purchaseorders/Purchaseorders_class.php");
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../pm/notifications/Notifications_class.php");
require_once("../../pm/notificationrecipients/Notificationrecipients_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../wf/routedetails/Routedetails_class.php");
require_once("../../inv/departments/Departments_class.php");
require_once("../../proc/config/Config_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../inv/unitofmeasures/Unitofmeasures_class.php");
require_once("../../proc/requisitions/Requisitions_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8069";//Edit
}
else{
	$auth->roleid="8067";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->retrieve)){
  $obj=$ob;
}

if(!empty($ob->documentno)){
  $obj->invoiceno=$obj->documentno;
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

if($obj->action=="First"){
  $purchaseorders = new Purchaseorders();
  $fields=" min(documentno) documentno ";
  $join="";
  $groupby="";
  $having="";
  $where=" where type='$obj->type' ";
  if($_POST['status']==1){
    $where.=" and status=1 ";
  }
  $purchaseorders->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $purchaseorders=$purchaseorders->fetchObject;
  
  $obj->invoiceno=$purchaseorders->documentno;
  $obj->action="Filter";
  
}

if($obj->action=="Next"){
 
  if($_POST['status']==1){
    $purchaseorders = new Purchaseorders();
    $fields=" min(documentno) documentno ";
    $join="";
    $groupby="";
    $having="";
    $where=" where type='$obj->type' and status=1 and documentno>'$obj->documentno' ";
    $purchaseorders->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    $purchaseorders=$purchaseorders->fetchObject;
    $obj->invoiceno=$purchaseorders->documentno;
  }else{
     $obj->invoiceno=($obj->documentno+1);
  }
  
  $obj->action="Filter";
}

if($obj->action=="Previous"){
   
if($_POST['status']==1){
    $purchaseorders = new Purchaseorders();
    $fields=" max(documentno) documentno ";
    $join="";
    $groupby="";
    $having="";
    $where=" where type='$obj->type' and status=1 and documentno<'$obj->documentno' ";
    $purchaseorders->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    $purchaseorders=$purchaseorders->fetchObject;
    
    $obj->invoiceno=$purchaseorders->documentno;
  }else{
    $obj->invoiceno=($obj->documentno-1);
  }
  
  $obj->action="Filter";
}

if($obj->action=="Last"){
  $purchaseorders = new Purchaseorders();
  $fields=" max(documentno) documentno ";
  $join="";
  $groupby="";
  $having="";
  $where=" ";
  $where=" where type='$obj->type' ";
  if($_POST['status']==1){
    $where.=" and status=1 ";
  }
  $purchaseorders->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $purchaseorders=$purchaseorders->fetchObject;
  
  $obj->invoiceno=$purchaseorders->documentno;
  $obj->action="Filter";
  
}
	
if($obj->action=="Save"){
	$purchaseorders=new Purchaseorders();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shppurchaseorders=$_SESSION['shppurchaseorders'];
	
	$error=$purchaseorders->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shppurchaseorders)){
		$error="No items in the sale list!";
	}
	else{
		$purchaseorders=$purchaseorders->setObject($obj);
		if($purchaseorders->add($purchaseorders,$shppurchaseorders)){		  
		        $error=SUCCESS;
			$saved="Yes";
			$_SESSION['itid']="";
			$_SESSION['cost']="";
			$_SESSION['shppurchaseorders']="";
			
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$purchaseorders=new Purchaseorders();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$purchaseorders->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchaseorders=$purchaseorders->setObject($obj);
		$shppurchaseorders=$_SESSION['shppurchaseorders'];
		if($purchaseorders->edit($purchaseorders,"",$shppurchaseorders)){
			$error=UPDATESUCCESS;
			$saved="Yes";
			$_SESSION['shppurchaseorders']="";
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->quantity)){
		$error=" Quantity must be provided";
	}
	elseif(empty($obj->itemid)){
		$error=" Product must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shppurchaseorders=$_SESSION['shppurchaseorders'];

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
	
	if(empty($obj->edit)){
	  $obj->i=$it;
	}
	  $shppurchaseorders[$obj->i]=array('quantity'=>"$obj->quantity", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'unitofmeasureid'=>"$obj->unitofmeasureid", 'unitofmeasurename'=>"$unitofmeasures->name", 'code'=>"$obj->code", 'vatclasseid'=>"$obj->vatclasseid", 'taxamount'=>"$obj->taxamount", 'tax'=>"$obj->tax", 'costprice'=>"$obj->costprice", 'tradeprice'=>"$obj->tradeprice", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");
	  //edit costprice
	  $edititem= mysql_query("UPDATE `inv_items` SET costprice ='$obj->costprice',lasteditedby ='',lasteditedon ='' WHERE id ='$obj->itemid'");

	if(empty($obj->edit)){
	  $it++;
	}
		$obj->iterator=$it;
 	$_SESSION['shppurchaseorders']=$shppurchaseorders;

	$obj->quantity="";
	$obj->costprice="";
	$obj->tradeprice="";
	$obj->total="";
	$obj->itemname="";
	$obj->code="";
 	$obj->itemid="";
 	$obj->unitofmeasureid="";
 	$obj->remarks="";
 	$obj->vatclasseid="";
 	$obj->taxamount="";
 	$obj->tax="";
 	$obj->edit="";
 }
}

if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$purchaseorders = new Purchaseorders();
		$fields="proc_purchaseorderdetails.id, proc_purchaseorders.currencyid, proc_purchaseorders.type, proc_purchaseorders.rate, proc_purchaseorders.eurorate, proc_purchaseorderdetails.unitofmeasureid, proc_purchaseorderdetails.total, proc_purchaseorderdetails.vatclasseid, proc_purchaseorderdetails.tax, proc_purchaseorderdetails.taxamount, inv_unitofmeasures.name unitofmeasurename, proc_purchaseorders.documentno, inv_items.id as itemid,inv_items.name itemname,  proc_purchaseorderdetails.quantity, proc_purchaseorderdetails.costprice, proc_purchaseorderdetails.total, proc_purchaseorderdetails.memo, proc_purchaseorders.requisitionno, proc_suppliers.id as supplierid, proc_purchaseorders.remarks, proc_purchaseorders.orderedon, proc_purchaseorders.file, proc_purchaseorders.createdby, proc_purchaseorders.createdon, proc_purchaseorders.lasteditedby, proc_purchaseorders.lasteditedon, proc_purchaseorders.ipaddress";
		$join=" left join proc_purchaseorderdetails on proc_purchaseorderdetails.purchaseorderid=proc_purchaseorders.id left join inv_items on inv_items.id=proc_purchaseorderdetails.itemid left join proc_suppliers on proc_purchaseorders.supplierid=proc_suppliers.id left join inv_unitofmeasures on inv_unitofmeasures.id=proc_purchaseorderdetails.unitofmeasureid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where proc_purchaseorders.documentno='$obj->invoiceno'";
		$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$purchaseorders->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$items = new Items();
			$fields=" * ";
			$join="";
			$groupby="";
			$having="";
			$where=" where id='$row->itemid'";
			$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$items=$items->fetchObject;
	  
			$ob=$row;
			//$row->total=$row->quantity*$row->costprice;
			$shppurchaseorders[$it]=array('id'=>"$row->id",'quantity'=>"$row->quantity", 'received'=>"$row->received", 'itemid'=>"$row->itemid", 'itemname'=>"$items->name", 'unitofmeasureid'=>"$row->unitofmeasureid", 'unitofmeasurename'=>"$row->unitofmeasurename", 'code'=>"$row->code", 'vatclasseid'=>"$row->vatclasseid", 'taxamount'=>"$row->taxamount", 'tax'=>"$row->tax", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon");

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
		$suppliers=$suppliers->fetchObject;
		$auto->suppliername=$suppliers->name;
		
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

			$obj->quantity="";
			$obj->costprice="";
			$obj->tradeprice="";
			$obj->total="";
			$obj->itemname="";
			$obj->code="";
			$obj->itemid="";
			$obj->remarks="";
		
		
		$obj->iterator=$it;
		
		$_SESSION['shppurchaseorders']=$shppurchaseorders;
	}
}

if($obj->action=="Raise GRN"){
  $shppurchaseorders=$_SESSION['shppurchaseorders'];
  
  $num = count($shppurchaseorders);
  $i=0;
  $k=0;//print_r($shppurchaseorders);
  while($i<$num){
  

      $ob = $obj;
      $ob->deliverynoteno=$ob->documentno;
      
      $_SESSION['ob']=$ob;
      
    if(isset($_POST[$shppurchaseorders[$i]['id']])){
      
      $shpinwards[$k]=$shppurchaseorders[$i];      
      
      $shpinwards[$k]['quantity']=$_POST[$i];
      $shpinwards[$k]['total']=$shpinwards[$k]['quantity']*$shpinwards[$k]['costprice'];
      $k++;
    }
    $i++;
  }
 // print_r($shpinwards);
  $_SESSION['shpinwards']=$shpinwards;
  $_SESSION['shppurchaseorders']="";
  
  //print_r($_SESSION['shpinwards']);
  redirect("../inwards/addinwards_proc.php?raise=1");
}

if($obj->action=="Raise Purchase"){
  $shppurchaseorders=$_SESSION['shppurchaseorders'];
  
  $num = count($shppurchaseorders);
  $i=0;
  $k=0;//print_r($shppurchaseorders);
  while($i<$num){
  

      $ob = $obj;
      $ob->purchasemodeid=1;
      $ob->retrieve="";
      $ob->paymentmodeid=11;
      //get employee that requested
      $requisitions = new Requisitions();
      $fields=" proc_requisitions.employeeid, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeename ";
      $join=" left join hrm_employees on hrm_employees.id=proc_requisitions.employeeid ";
      $having="";
      $groupby="";
      $orderby="";
      $where=" where proc_requisitions.documentno in($obj->requisitionno) ";
      $requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      $requisitions = $requisitions->fetchObject;
      
      $ob->employeeid = $requisitions->employeeid;
      $ob->employeename = $requisitions->employeename;
      
       //for autocompletes
	$currencys = new Currencys();
	$fields=" * ";
	$where=" where id='$ob->currencyid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$currencys=$currencys->fetchObject;
	$ob->exchangerate=$currencys->rate;
	$ob->exchangerate2=$currencys->eurorate;
      
      $ob->lpono=$ob->documentno;
      
      $_SESSION['ob']=$ob;
      
    if(isset($_POST[$shppurchaseorders[$i]['id']])){
      
      $shppurchases[$k]=$shppurchaseorders[$i];      
      
      $shpinwards[$k]['quantity']=$_POST[$i];
      $shppurchases[$k]['total']=$shppurchases[$k]['quantity']*$shppurchases[$k]['costprice'];
      $k++;
    }
    $i++;
  }
 // print_r($shpinwards);
  $_SESSION['shppurchases']=$shppurchases;
  $_SESSION['shppurchaseorders']="";
  
  //print_r($_SESSION['shpinwards']);
  redirect("../../inv/purchases/addpurchases_proc.php?raise=1&mode=cash");
}

if($obj->action=="Give Imprest"){
  $ob->amount=$obj->ttotal;
  
  if($obj->type=="cash"){
    //get employee that requested
    $requisitions = new Requisitions();
    $fields=" proc_requisitions.employeeid, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeename ";
    $join=" left join hrm_employees on hrm_employees.id=proc_requisitions.employeeid ";
    $having="";
    $groupby="";
    $orderby="";
    $where=" where proc_requisitions.documentno in($obj->requisitionno) ";
    $requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
    $requisitions = $requisitions->fetchObject;
  }
  
  $ob->employeeid=$requisitions->employeeid;
  $ob->employeename=$requisitions->employeename;
  $ob->memo=" Cash Purchases #".$obj->documentno;
  $ob->paymentmodeid=1;
  
  $_SESSION['ob']=$ob;
  
  redirect("../../fn/imprests/addimprests_proc.php?raise=1");
}


if(empty($obj->action)){

	$projects= new Projects();
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$purchaseorders=new Purchaseorders();
	$where=" where id=$id ";
	$fields="proc_purchaseorders.id, proc_purchaseorders.projectid, proc_purchaseorders.documentno, proc_purchaseorders.requisitionno, proc_purchaseorders.supplierid, proc_purchaseorders.remarks, proc_purchaseorders.orderedon, proc_purchaseorders.file, proc_purchaseorders.createdby, proc_purchaseorders.createdon, proc_purchaseorders.lasteditedby, proc_purchaseorders.lasteditedon, proc_purchaseorders.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$purchaseorders->fetchObject;

	//for autocompletes
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

if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
  
      if(empty($obj->action) and empty($obj->action2)){
      
	if(empty($_GET['raise']))
	  $_SESSION['shppurchaseorders']="";
	else{
	  
	  $obj=$_SESSION['ob'];
	  $obj->iterator=count($_SESSION['shppurchaseorders']);
	}
			  
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from proc_purchaseorders where type='$obj->type'"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->orderedon=date("Y-m-d");	
	
      }
      $obj->action="Save";
      
  } 
  else{
    $obj=$_SESSION['obj'];
    $obj->edit=$_GET['edit'];
  }
  
}
else{  
    $obj->action="Update";
}

$page_title="Purchaseorders ";
include "addpurchaseorders.php";
?>