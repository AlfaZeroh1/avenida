<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../auth/rules/Rules_class.php");

$saved="";

require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../sys/transactions/TransactionsDBO.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../fn/exptransactions/Exptransactions_class.php");
require_once("../../fn/incomes/Incomes_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../pos/invoices/Invoices_class.php");
require_once("../../pos/invoicedetails/Invoicedetails_class.php");
require_once("../../pos/invoiceconsumables/Invoiceconsumables_class.php");
require_once("../../proc/config/Config_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../proc/inwards/Inwards_class.php");
require_once("../../proc/inwarddetails/Inwarddetails_class.php");
require_once("../../inv/issuance/Issuance_class.php");
require_once("../../inv/issuancedetails/Issuancedetails_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../inv/purchases/Purchases_class.php");
require_once("../../hrm/departments/Departments_class.php");
require_once("../../inv/purchasedetails/Purchasedetails_class.php");
require_once("../../fn/supplierpayments/Supplierpayments_class.php");
// require_once '../../ProgressBar/Manager.php';
// require_once '../../ProgressBar/Registry.php';

// echo "GRN's\n";
// $inwardss = new Inwards();
// $fields=" distinct documentno ";
// $where=" where inwarddate>='2015-07-01' ";
// $join=" ";
// $having="";
// $groupby="";
// $orderby="   ";
// $inwardss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 
// while($rows=mysql_fetch_object($inwardss->result)){
//   $inwards = new Inwards();
//   $fields="proc_inwards.id inwardid, proc_inwarddetails.id inwarddetailid, con_projects.id as projectid, proc_inwards.documentno, inv_items.id as itemid,inv_items.name itemname,  proc_inwarddetails.quantity, proc_inwarddetails.costprice, proc_inwarddetails.total, proc_inwarddetails.memo, proc_inwards.documentno, proc_suppliers.id as supplierid, proc_inwards.remarks, inv_items.categoryid, proc_inwards.inwarddate, proc_inwards.file, proc_inwards.createdby, proc_inwards.createdon, proc_inwards.lasteditedby, proc_inwards.lasteditedon, proc_inwards.ipaddress, proc_inwards.currencyid,proc_inwards.rate,proc_inwards.eurorate";
//   $join=" left join proc_inwarddetails on proc_inwarddetails.inwardid=proc_inwards.id left join inv_items on inv_items.id=proc_inwarddetails.itemid left join con_projects on proc_inwards.projectid=con_projects.id  left join proc_suppliers on proc_inwards.supplierid=proc_suppliers.id left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
//   $having="";
//   $groupby="";
//   $orderby="";
//   $where=" where proc_inwards.documentno='$rows->documentno'";
//   $inwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
//   $res=$inwards->result;
//   $it=0;
//   $shpinwards=array();
//   while($row=mysql_fetch_object($res)){
// 		  
// 	  $ob=$row;
// 	  $row->total=$row->quantity*$row->costprice;
// 	  $shpinwards[$it]=array('id'=>"1",'inwarddetailid'=>"$row->inwarddetailid",'quantity'=>"$row->quantity", 'itemid'=>"$row->itemid", 'itemname'=>"$ob->itemname", 'code'=>"$row->code", 'tax'=>"$row->tax", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon",'categoryid'=>"$ob->categoryid", 'categoryname'=>"$ob->category");
// 
// 	  $it++;
//   }
// 
// $inv = new Inwards();
// // $ob->id=$ob->inwardid;
//  $ob->effectjournals=1;
// if($inv->add($ob,$shpinwards)){
//   echo "GRN #".$rows->documentno."\n";
// }
// }

echo "Issuances\n";
$issuances = new Issuance();
$fields=" distinct documentno ";
$where=" where issuedon>='2015-07-01'  and journals='Yes' ";
$join=" ";
$having="";
$groupby="";
$orderby=" ";
$issuances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($rows=mysql_fetch_object($issuances->result)){
  $issuance = new Issuance();
  $fields="inv_issuance.id issuanceid,inv_issuance.documentno,inv_issuancedetails.itemid, inv_issuancedetails.id issuancedetailid,inv_items.name itemname,inv_issuancedetails.purpose, inv_categorys.name category, inv_issuancedetails.quantity,inv_issuancedetails.costprice,inv_issuancedetails.total,inv_issuancedetails.purpose,inv_issuancedetails.remarks,prod_blocks.name blockname, prod_sections.name sectionname, prod_greenhouses.name greenhousename, assets_fleets.assetid fleetid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename,hrm_employees.id employeeid,hrm_departments.name as departmentname,inv_issuance.departmentid as departmentid, inv_categorys.id categoryid, inv_issuance.currencyid, inv_issuance.rate, inv_issuance.eurorate, inv_issuance.issuedon ";
  $join=" left join inv_issuancedetails on inv_issuancedetails.issuanceid=inv_issuance.id left join inv_items on inv_issuancedetails.itemid=inv_items.id left join hrm_employees on hrm_employees.id=inv_issuance.employeeid left join inv_unitofmeasures on inv_unitofmeasures.id=inv_items.unitofmeasureid left join prod_blocks on prod_blocks.id=inv_issuancedetails.blockid left join prod_sections on prod_sections.id=inv_issuancedetails.sectionid left join prod_greenhouses on prod_greenhouses.id=inv_issuancedetails.greenhouseid left join assets_fleets on assets_fleets.id=inv_issuancedetails.fleetid left join hrm_departments on hrm_departments.id=inv_issuance.departmentid left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
  $having="";
  $groupby="";
  $orderby=" ";
  $where=" where inv_issuance.documentno='$rows->documentno'";
  $issuance->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();//echo $issuance->sql;
  //echo $issuance->sql;  
  $res=$issuance->result;
  $it=0;
  $shpissuance=array();
  while($row=mysql_fetch_object($res)){			
	  $ob=$row;
	  
	  //check item currency
	  $query="select proc_inwards.currencyid, proc_inwards.rate,inv_items.costprice  from proc_inwards left join proc_inwarddetails on proc_inwards.id=proc_inwarddetails.inwardid left join inv_items on inv_items.id=proc_inwarddetails.itemid where proc_inwarddetails.itemid='$row->itemid' order by proc_inwards.id desc";
	  $its = mysql_fetch_object(mysql_query($query));
	  
	  $ob->costprice=$ob->total/$ob->quantity;
	  
	  if($it->rate=="0" or empty($it->rate))
	    $it->rate=1;
	    
	  $ob->total=$ob->quantity*$its->rate*$ob->costprice;
	  
	  $shpissuance[$it]=array('issuancedetailid'=>"$ob->issuancedetailid",'documentno'=>"$ob->documentno",'costprice'=>"$ob->costprice",'total'=>"$ob->total", 'itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname", 'quantity'=>"$ob->quantity", 'blockname'=>"$ob->blockname", 'remarks'=>"$ob->remarks", 'purpose'=>"$ob->purpose", 'sectionname'=>"$ob->sectionname",'greenhousename'=>"$ob->greenhousename",'employeename'=>"$ob->employeename",'employeeid'=>"$ob->employeeid",'total'=>"$ob->total",'categoryid'=>"$ob->categoryid", 'categoryname'=>"$ob->category");

	  $it++;
  }

  $inv = new Issuance();
//   $ob->id=$ob->issuanceid;
  $ob->effectjournals=1;
  if($inv->add($ob,$shpissuance)){
    
    echo "ISSUANCE #".$rows->documentno."\n";
  }
  
}

// echo "EXPENSES\n";
// $exptransactions = new Exptransactions();
// $fields=" distinct documentno ";
// $where="  ";
// $join=" ";
// $having="";
// $groupby="";
// $orderby=" order by documentno desc ";
// $exptransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $exptransactions->sql;
// $num = $exptransactions->affectedRows;
// 
// $i=0;
// $k=0;
// //$progressBar = new \ProgressBar\Manager(0, $num);
// while($rows=mysql_fetch_object($exptransactions->result)){
//   
//     $k++;
//     $i++;
//     $exptransactions1 = new Exptransactions();
//     $fields="fn_exptransactions.*,assets_assets.name as assetname,fn_liabilitys.name as liabilityname,fn_expenses.name as expensename ";
//     $join=" left join assets_assets on assets_assets.id=fn_exptransactions.assetid left join fn_liabilitys on fn_liabilitys.id=fn_exptransactions.liabilityid left join fn_expenses on fn_expenses.id=fn_exptransactions.expenseid  ";
//     $having="";
//     $groupby="";
//     $orderby="";
//     $where=" where fn_exptransactions.documentno='$rows->documentno' ";
//     $exptransactions1->retrieve($fields,$join,$where,$having,$groupby,$orderby);
//     $res=$exptransactions1->result;
//     $it=0;
//     $shpexptransactions=array();
//     while($row=mysql_fetch_object($res)){
// 		  
// 	    $ob=$row;
// 	    $shpexptransactions[$it]=array('assetid'=>"$ob->assetid",'assetname'=>"$ob->assetname",'liabilityid'=>"$ob->liabilityid",'liabilityname'=>"$ob->liabilityname",'expenseid'=>"$ob->expenseid", 'expensename'=>"$ob->expensename", 'quantity'=>"$ob->quantity", 'tax'=>"$ob->tax", 'discount'=>"$ob->discount", 'amount'=>"$ob->amount", 'memo'=>"$ob->memo", 'total'=>"$ob->total",'month'=>"$ob->month",'year'=>"$ob->year");
// 
// 	    $it++;
// 	    $obj = $ob;
//     }
// 
// // 		$_SESSION['shpexptransactions']=$shpexptransactions;
//     
//     //for autocompletes
//   
//     $obj = (object) array_merge((array) $obj, (array) $ob);
//     
//     $obj->action="Update";
//     $obj->retrieve=1;
//     $obj->iterator=$it;
//     $obj->id="";
//    $_SESSION['shpexptransactions']=$shpexptransactions;
// 
// 
//     $ss = new Exptransactions();
//     $ss->setObject($obj);
//     $ss->effectjournals=1;
//     if($ss->edit($ss,"",$shpexptransactions)){
//     $error=SUCCESS;
//     $saved="Yes";
//     
//     unset($_SESSION['customername']);
//     unset($_SESSION['tel']);
//     unset($_SESSION['remarks']);
//     unset($_SESSION['address']);
// 
//     echo "SUCCESSFULLY Updated #".$rows->voucherno."\n";
// 
// }
// }
?>