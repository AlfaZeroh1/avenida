<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Requisitions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../inv/transfers/Transfers_class.php");
require_once("../../inv/itemdetails/Itemdetails_class.php");
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../auth/roles/Roles_class.php");
require_once("../../wf/routes/Routes_class.php");
require_once("../../inv/issuance/Issuance_class.php");
require_once("../../inv/branchstocks/Branchstocks_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7504";//Edit
}
else{
	$auth->roleid="7502";//Add
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
	
if(!empty($ob->documentno)){
	$obj->retrieve=1;
	$obj->invoiceno=$ob->documentno;
	$obj->action="Filter";
}

if(!empty($ob->approve))
  $obj->approve=$ob->approve;
	
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
	else{
		$requisitions=$requisitions->setObject($obj);
		if($requisitions->add($requisitions,$shprequisitions)){
			$error=SUCCESS;
			redirect("addrequisitions_proc.php?retrieve=1&documentno=".$obj->documentno."&error=".$error);
			$saved="Yes";
			unset($_SESSION['shprequisitions']);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update" or $obj->action=="Approve"){
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
		$requisitions->action=$obj->action;
		if($requisitions->edit($requisitions,"",$shprequisitions)){
			$error=UPDATESUCCESS;
			
// 			redirect("addrequisitions_proc.php?id=".$requisitions->id."&error=".$error);
			$saved="Yes";
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if($obj->action=="Submit for Approval"){
  mysql_query("update inv_requisitions set status=1 where documentno='$obj->documentno'");
  
  require_once("../../pm/tasks/Tasks_class.php");
			$obj->module="inv";
			$obj->role="requisitions";
			
			
			$tasks = new Tasks();
			$tasks->workflow($obj);
			
			$error=UPDATESUCCESS;
			$saved="Yes";
			
}
if($obj->action2=="Add"){

	if(empty($obj->itemid)){
		$error="Item must be provided";
	}
	elseif(empty($obj->quantity)){
		$error="Quantity must be provided";
	}
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

	$shprequisitions[$it]=array('itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'quantity'=>"$obj->quantity", 'aquantity'=>"$obj->aquantity", 'reorderlevel'=>"$obj->reorderlevel",'maxreorderlevel'=>"$obj->maxreorderlevel",'stock'=>"$obj->stock", 'memo'=>"$obj->memo", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shprequisitions']=$shprequisitions;

	$obj->itemname="";
 	$obj->itemid="";
 	$obj->quantity="";
 	$obj->aquantity="";
 	$obj->memo="";
 }
}

if(empty($obj->action)){

	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.type, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$branches= new Branches();
	$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.type, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.brancheid, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if($obj->action=="Filter"){
  if(!empty($obj->invoiceno)){
	$requisitions=new Requisitions();
	$where=" where inv_requisitions.documentno='$obj->invoiceno' ";
	$fields="inv_requisitions.id, inv_requisitions.brancheid, inv_requisitions.employeeid, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeename, inv_requisitions.documentno, inv_requisitions.itemid, inv_items.name itemname, inv_requisitions.quantity, inv_requisitions.aquantity, inv_requisitions.memo, inv_requisitions.requisitiondate, inv_requisitions.remarks,inv_requisitions.reorderlevel,inv_requisitions.maxreorderlevel,inv_requisitions.stock, inv_requisitions.status, inv_requisitions.ipaddress, inv_requisitions.createdby, inv_requisitions.createdon, inv_requisitions.lasteditedby, inv_requisitions.lasteditedon";
	$join=" left join inv_items on inv_items.id=inv_requisitions.itemid left join hrm_employees on hrm_employees.id=inv_requisitions.employeeid ";
	$having="";
	$groupby="";
	$orderby="";
	$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	
	$invoiceno = $obj->invoiceno;
	
	$it=0;
	$_SESSION['shprequisitions']="";
	while($row=mysql_fetch_object($requisitions->result)){
	  
	  $transfers = new Transfers();
	  $fields=" sum(inv_transferdetails.quantity) quantity ";
	  $where=" where inv_transfers.requisitionno='$invoiceno' and inv_transferdetails.itemid='$row->itemid'";
	  $join=" left join inv_transferdetails on inv_transferdetails.transferid=inv_transfers.id ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $transfers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $transfers=$transfers->fetchObject;
	  
	  $aquantity=$row->quantity-$transfers->quantity;
	  $dquantity=$row->quantity-$transfers->quantity;
	  
	  //get stock
// 	  $query="select * from inv_branchstocks where itemid='$row->itemid' and brancheid='25'";//echo $query."<br/>";
// 	  $r = mysql_fetch_object(mysql_query($query));
// 	  
// 	  if(empty($r->quantity))
// 	    $r->quantity=0;
	  
	  $shprequisitions[$it]=array('id'=>"$row->id",'itemid'=>"$row->itemid", 'itemname'=>"$row->itemname", 'quantity'=>"$row->quantity", 'aquantity'=>"$row->quantity", 'tquantity'=>"$aquantity", 'dquantity'=>"$dquantity" , 'reorderlevel'=>"$row->reorderlevel",'maxreorderlevel'=>"$row->maxreorderlevel",'stock'=>"$r->quantity",'memo'=>"$row->memo", 'total'=>"$row->total");
	  
	  $it++;
	  $obj = $row;
	}
	
	$branches = new Branches();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->brancheid'";
	$branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$branches=$branches->fetchObject;
	$ob->branchename=$branches->name;
	
	$obj->itemname="";
 	$obj->itemid="";
 	$obj->quantity="";
	
	$obj = (object) array_merge((array) $obj, (array) $ob);
	
	$obj->retrieve=1;
	$obj->iterator=$it;
	$obj->action="Update";
	$_SESSION['shprequisitions']=$shprequisitions;
  }
}

if($obj->action=="Dispatch"){
  
  $shop=$_SESSION['shprequisitions'];
  
  $obj->tobrancheid=$obj->brancheid;
  $obj->requisitionno=$obj->documentno;
  
  $num = count($shop);
  $v=0;
  $x=0;
  $shptransfers = array();
  while($v<$num){
    
    if(isset($_POST[$shop[$v]['id']])){
    
    $items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='".$shop[$v]['itemid']."'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;
	
	$quantity=$shop[$v]['dquantity'];

 	if($items->serialno=="Yes"){
	
	  $itemdetails = new Branchstocks();
	  $fields="*";
	  $where=" where itemid='$items->id' and brancheid='".$_SESSION['brancheid']."' ";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby=" order by id asc limit ".$quantity;
	  $itemdetails->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  
	  if($itemdetails->affectedRows==0)
	    $error.=" ".$items->name." not available in Stock!</br>";
	    
	  while($rw=mysql_fetch_object($itemdetails->result)){	 
	    $q=0;

	    if($items->type=="Standard")
	      $type=1;
	    else
	      $type=2;
	    
	      $total = $items->costprice*$quantity;
	      
	      $shptransfers[$x]=array('itemid'=>"$items->id",'itemdetailid'=>"$rw->id", 'costprice'=>"$items->costprice",'total'=>"$total", 'serialno'=>"$rw->serialno", 'itemname'=>"$items->name", 'quantity'=>"1", 'code'=>"$obj->code",'instalcode'=>"$rw->instalcode", 'version'=>"$rw->version", 'memo'=>"$obj->memo", 'installationcode'=>"$items->installationcode",'type'=>"$type");
	      $x++;
	      $q++;

	  }
	}else{
	
        $itemdetails = new Branchstocks();
        $fields="*";
        $where=" where itemid='$items->id' and brancheid='25' ";
        $join="";
        $having="";
        $groupby="";
        $orderby=" ";
        $itemdetails->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $itemdetails->sql;
        $itemdetails = $itemdetails->fetchObject;
        
        if($itemdetails->quantity<$quantity)
            $error.=" Only ($itemdetails->quantity) of ".$items->name." available in Stock!</br>";
	
	
	  $total = $items->costprice*$quantity;
	  
	  $shptransfers[$x]=array('itemid'=>"$items->id",'itemdetailid'=>"$rw->id", 'costprice'=>"$items->costprice",'total'=>"$total", 'serialno'=>"$rw->serialno", 'itemname'=>"$items->name", 'quantity'=>"$quantity", 'code'=>"$obj->code",'instalcode'=>"$rw->instalcode", 'memo'=>"$obj->memo", 'installationcode'=>"$items->installationcode",'type'=>"$type");
	  $x++;
	}
	
  }
  $v++;
		
  }
  $_SESSION['ob']=$obj;
  $_SESSION['shptransfers']=$shptransfers;
//   print_r($shptransfers);

 if(empty($error)){
    $obj->iterator=$x;
    redirect("../transfers/addtransfers_proc.php?dispatch=1&requisitionno=$obj->documentno&error=".$error);
  }
}

if($obj->action=="ISSUE"){
  $shprequisitions=$_SESSION['shprequisitions'];
  
      $ob->projectid = $obj->projectid;
      $ob->projectname = $obj->projectname;
      $ob->requisitionno = $obj->documentno;
      $ob->departmentid=$obj->departmentid;
      $ob->employeeid=$obj->employeeid;
      $ob->employeename=$obj->employeename;     
      $_SESSION['ob']=$ob;
  
  $num = count($shprequisitions);
  
  
    $i=0;
    $k=0;
    while($i<$num){      
      
      if(isset($_POST[$shprequisitions[$i]['id']])){ 
      
	//retrieve item to determine value
	$items = mysql_fetch_object(mysql_query("select * from inv_items where id='".$shprequisitions[$i]['itemid']."'"));
	
	$shpissuance[$k]=$shprequisitions[$i]; 
	$shpissuance[$k]['costprice']=$items->value;
	$shpissuance[$k]['quantity']=$shprequisitions[$i]['dquantity'];
	$shpissuance[$k]['total']=$shpissuance[$k]['quantity']*$shpissuance[$k]['costprice'];
	$k++;
      }
      $i++;
    }
  
  if($k==0){
      $error="No Items are selected!";
    }else{
    $_SESSION['shpissuance']=$shpissuance; //print_r($shpissuance);
    $_SESSION['shprequisitions']="";
    
    redirect("../issuance/addissuance_proc.php?raise=1");
   }
}

if(!empty($id)){
	$requisitions=new Requisitions();
	$where=" where id=$id ";
	$fields="inv_requisitions.id, inv_requisitions.brancheid, inv_requisitions.employeeid, inv_requisitions.documentno, inv_requisitions.itemid, inv_requisitions.quantity, inv_requisitions.aquantity, inv_requisitions.memo, inv_requisitions.requisitiondate, inv_requisitions.remarks, inv_requisitions.status, inv_requisitions.ipaddress, inv_requisitions.createdby, inv_requisitions.createdon, inv_requisitions.lasteditedby, inv_requisitions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$requisitions->fetchObject;

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
		
		if(empty($obj->action2) and empty($ob->raise)){
		  unset($_SESSION['shprequisitions']);
		}else{
		  
		  $obj = $_SESSION['ob'];
		  $obj->iterator=count($_SESSION['shprequisitions']);
		  
		}
		$obj->action="Save";
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from inv_requisitions"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;

		$obj->requisitiondate=date('Y-m-d');
		
		$branches = new Branches();
		$fields="*";
		$where=" where id='".$_SESSION['tobrancheid']."'";
		$join="";
		$groupby="";
		$having="";
		$branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$branches = $branches->fetchObject;
		
		$obj->brancheid=$branches->id;
		$obj->branchename=$branches->code." ".$branches->name;
		
		$employees = new Employees();
		$fields=" hrm_employees.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) name ";
		$where=" where id='".$_SESSION['employeeid']."'";
		$join="";
		$groupby="";
		$having="";
		$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$employees = $employees->fetchObject;
		
		$obj->employeeid=$employees->id;
		$obj->employeename=$employees->name;
		
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}

if(!empty($ob->approve)){
  $obj->approve=$ob->approve;
}

if(!empty($ob->dispatch)){
  $obj->action="Dispatch";
}

	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='inv_requisitions' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addrequisitions.php";
?>
