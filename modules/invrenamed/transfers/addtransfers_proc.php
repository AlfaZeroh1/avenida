<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Transfers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/branches/Branches_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../transferdetails/Transferdetails_class.php");
require_once("../../inv/transfers/Transfers_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../inv/itemdetails/Itemdetails_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../inv/branchstocks/Branchstocks_class.php");
require_once("../../inv/requisitions/Requisitions_class.php");
// require_once("../../inv/creditcodes/Creditcodes_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7496";//Edit
}
else{
	$auth->roleid="7494";//Add
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
	$obj->invoiceno=$ob->documentno;
	$obj->action="Filter";
}
	
if(empty($obj->action)){
	$obj->transferedon=date('Y-m-d');

}

if(!empty($ob->dispatch)){
  $obj->dispatch=$ob->dispatch;
}

if($ob->receive==1){
  $obj->receive=1;
  $obj->invoiceno=$ob->documentno;
  $obj->action="Filter";
}
	
if($obj->action=="Save"){
	$transfers=new Transfers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shptransfers=$_SESSION['shptransfers'];
	$error=$transfers->validates($obj);
	$shop = $_SESSION['codes'];
	$num=count($shptransfers);
	$i=0;

	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shptransfers)){
		$error="No items in the sale list!";
	}
	else{
		$transfers=$transfers->setObject($obj);
		$transfers->dispatch=$obj->dispatch;
		if($transfers->add($transfers,$shptransfers,$bool=false)){
			$error=SUCCESS;
			unset($_SESSION['codes']);
			unset($_SESSION['shptransfers']);
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Receive"){
	$transfers=new Transfers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
        $obj->receive=1;
	$error=$transfers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$transfers=$transfers->setObject($obj);
		$shptransfers=$_SESSION['shptransfers'];
		$transfers->action=$obj->action;
		$transfers->status=1;
		
		if($transfers->edit($transfers,$shptransfers)){
			$error=UPDATESUCCESS;
			unset($_SESSION['codes']);
			unset($_SESSION['shptransfers']);
		        $saved="Yes";
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if($obj->action2=="Add"){
        $shptransfers=$_SESSION['shptransfers'];
	$num=count($_SESSION['shptransfers']);
	$i=0;
// 	while($i<$num)
// 	{  	      
// 	    if($shptransfers[$i]['serialno']=="$obj->serialno")
// 	    {
// 	    $error="Serial No already selected ";
// 	    }
// 	    $i++;
// 	}
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($obj->itemid)){
		$error=" Product must be provided";
	}
	elseif(empty($obj->quantity)){
		$error=" Quantity must be provided";
	}
	elseif($obj->quantity>$obj->stock){
		$error=" Cannot transfer more than is available!";
	}
	
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	

	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;

	$x=0;
	
	$shptransfers[$it]=array('itemid'=>"$obj->itemid",'itemdetailid'=>"$obj->itemdetailid", 'serialno'=>"$obj->serialno", 'itemname'=>"$items->name", 'quantity'=>"$obj->quantity", 'code'=>"$obj->code", 'costprice'=>"$obj->costprice", 'memo'=>"$obj->memo", 'costprice'=>"$obj->costprice", 'installationcode'=>"$items->installationcode", 'instalcode'=>"$itemdetails->instalcode", 'version'=>"$obj->version");
	$it++;
	
// 	if(empty($obj->serialno)){
// 	$itemdetails = new Itemdetails();
// 	$fields="*";
// 	$where=" where itemid='$obj->itemid' and status=1 and brancheid='$obj->brancheid' ";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby=" order by id asc limit $obj->quantity ";
// 	$itemdetails->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 	while($rw=mysql_fetch_object($itemdetails->result)){
// 	  $shptransfers[$it]=array('itemid'=>"$obj->itemid",'itemdetailid'=>"$rw->id", 'serialno'=>"$rw->serialno", 'itemname'=>"$items->name", 'quantity'=>"1", 'code'=>"$obj->code", 'costprice'=>"$obj->costprice", 'memo'=>"$obj->memo", 'costprice'=>"$obj->costprice", 'installationcode'=>"$items->installationcode", 'instalcode'=>"$rw->instalcode", 'version'=>"$obj->version");
// 	  $it++;
// 	}
// 	}else{	
// 	$itemdetails = new Itemdetails();
// 	$fields="*";
// 	$where=" where id='$obj->itemdetailid' ";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby=" ";
// 	$itemdetails->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 	$itemdetails=$itemdetails->fetchObject;
// 	
// 	
// 	}
		$obj->iterator=$it;
 	$_SESSION['shptransfers']=$shptransfers;

	$obj->itemid="";
 	$obj->quantity="";
 	$obj->itemdetailid="";
 	$obj->serialno="";
 	$obj->memo="";
 	$obj->code="";
 	$obj->costprice="";
 	$obj->total="";
 }
}

if(empty($obj->action)){

	$branches= new Branches();
	$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$branches2= new Branches();
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches2->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if($obj->action=="Filter"){
//         echo $obj->invoiceno;
	if(!empty($obj->invoiceno)){
	//echo "miketheshit";
		$transfers = new Transfers();
		$fields="inv_transfers.id, inv_transfers.documentno, inv_transfers.requisitionno, inv_items.id,inv_items.name itemname,  inv_transferdetails.quantity, inv_transferdetails.quantityrec, inv_transferdetails.itemid, inv_transferdetails.memo,inv_transferdetails.costprice, inv_transferdetails.total,inv_transferdetails.status, inv_transferdetails.memo,inv_transferdetails.itemdetailid, inv_transfers.documentno, inv_transfers.remarks, inv_transfers.createdby, inv_transfers.createdon, inv_transfers.lasteditedby, inv_transfers.lasteditedon, inv_transfers.ipaddress, inv_transfers.brancheid, inv_transfers.tobrancheid";
		$join=" left join inv_transferdetails on inv_transferdetails.transferid=inv_transfers.id left join inv_items on inv_items.id=inv_transferdetails.itemid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where inv_transfers.documentno='$obj->invoiceno' ";
		$transfers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$transfers->result;
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
			$row->total=$row->quantity*$row->costprice;
			$remaining=$row->quantity-$row->quantityrec;
			
			$shptransfers[$it]=array('itemid'=>"$row->itemid",'itemdetailid'=>"$row->itemdetailid", 'status'=>"$row->status",'quantityrec'=>"$row->quantityrec",'serialno'=>"$row->serialno",'remaining'=>"$remaining", 'itemname'=>"$items->name", 'quantity'=>"$row->quantity", 'code'=>"$row->code", 'costprice'=>"$row->costprice", 'memo'=>"$row->memo",'crdcode'=>"$row->crdcode",'instalcode'=>"$row->instalcode", 'total'=>"$row->total",'crdcode'=>"$creditcodes->creditcode");
			
			
			$it++;
		}
		

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);	
		$obj = (object) array_merge((array) $obj, (array) $auto2);

		$obj->iterator=$it;
			$obj->quantity="";
			$obj->costprice="";
			$obj->tradeprice="";
			$obj->total="";
			$obj->itemname="";
			$obj->code="";
			$obj->itemid="";
			$obj->remarks="";
			$obj->serialno="";
			
		
		  $obj->action="Receive";
		  $obj->receive=1;
// 		$_SESSION['shpdeliverynotes']="";
		$_SESSION['shptransfers']=$shptransfers;
	
	}
}

if(!empty($id)){
	$transfers=new Transfers();
	$where=" where id=$id ";
	$fields="inv_transfers.id, inv_transfers.documentno, inv_transfers.brancheid, inv_transfers.tobrancheid, inv_transfers.remarks, inv_transfers.transferedon, inv_transfers.status, inv_transfers.ipaddress, inv_transfers.createdby, inv_transfers.createdon, inv_transfers.lasteditedby, inv_transfers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transfers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$transfers->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action) and empty($obj->receive)){
	if(empty($_GET['edit']) or $ob->dispatch==1){
		$obj->action="Save";		
		
		$defs=mysql_fetch_object(mysql_query("select max(documentno)+1 documentno from inv_transfers"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;

		$obj->transferedon=date('Y-m-d');
		
		if($ob->dispatch==1){
		  $obj->retrieve=1;
		  $obj->invoiceno=$ob->requisitionno;
		  $requisitions=new Requisitions();
		  $where=" where documentno=$ob->requisitionno ";
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $requisitions->sql;
		  $requisitions=$requisitions->fetchObject;
		  $obj->requisitionno=$ob->requisitionno;
		  $obj->tobrancheid=$requisitions->brancheid;
		  $obj->iterator=count($_SESSION['shptransfers']);
             	 // print_r($_SESSION['shptransfers']);
             	  $_SESSION['obj']=$obj;
             	 // print_r($_SESSION['obj']);
		}else{
		  if(empty($obj->action2))
		    unset($_SESSION['shptransfers']);
		}
		
		$query="select * from sys_branches where id='$obj->tobrancheid'";
		$rw=mysql_fetch_object(mysql_query($query));
		$obj->version = $rw->version;
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action) and empty($obj->receive)){
	$obj->action="Receive";
}

if($obj->receive==1){
  $obj->action="Receive";
}

// 	print_r($_SESSION['shptransfers']);
$page_title="Transfers ";
include "addtransfers.php";
?>