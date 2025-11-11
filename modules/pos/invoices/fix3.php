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
require_once("../../pos/items/Items_class.php");
// require_once("../../inv/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../proc/inwards/Inwards_class.php");
require_once("../../proc/inwarddetails/Inwarddetails_class.php");
require_once("../../inv/issuance/Issuance_class.php");
require_once("../../inv/issuancedetails/Issuancedetails_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../inv/purchases/Purchases_class.php");
require_once("../../inv/purchasedetails/Purchasedetails_class.php");
// require_once '../../ProgressBar/Manager.php';
// require_once '../../ProgressBar/Registry.php';

echo "INVOICES\n";
$invoices = new Invoices();
$fields=" distinct documentno ";
$where=" ";
$join=" ";
$having="";
$groupby="";
$orderby="   ";
$invoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($row=mysql_fetch_object($invoices->result)){
  $invoicedetails = new Invoicedetails();
  $fields=" pos_invoices.*, pos_invoices.id invoiceid, pos_invoicedetails.*, pos_invoicedetails.id invoicedetailid ";
  $join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where pos_invoices.documentno='$row->documentno'";
  $invoicedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $invoicedetails->sql;
  $res=$invoicedetails->result;
  
  $obj->action="Update";
  
  $it=0;
  $shpinvoices=array();
  while($rows=mysql_fetch_object($res)){
		  
      $items = new Items();
      $fields="pos_items.name name,pos_categorys.name as variety,pos_categorys.id as varietyid";
      $join=" left join pos_categorys on pos_items.categoryid=pos_categorys.id ";
      $groupby="";
      $having="";
      $where=" where pos_items.id='$rows->itemid'";
      $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $items->sql;
      $items=$items->fetchObject;
      
      $item->name="";
      
      if($rows->mixedbox=="Yes"){
	$item = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$rows->itemid'";
	$item->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$item=$item->fetchObject;
      }
	  
	  $sizes = new Sizes();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where=" where id='$rows->sizeid'";
	  $sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $sizes=$sizes->fetchObject;
	  
	  $rows->total=$rows->quantity*$rows->price*(100+$rows->vat)/100;
	  $ob=$rows;
	  $shpinvoices[$it]=array('id'=>"$ob->invoicedetailid",'itemid'=>"$ob->itemid", 'itemname'=>"$items->name",'itemnam'=>"$item->name",'item'=>"$item->id", 'sizeid'=>"$ob->sizeid" , 'sizename'=>"$sizes->name", 'quantity'=>"$ob->quantity", 'price'=>"$ob->price",'vat'=>"$obj->vat", 'exportprice'=>"$ob->exportprice", 'discount'=>"$ob->discount", 'bonus'=>"$ob->bonus", 'total'=>"$ob->total",'exporttotal'=>"$ob->exportprice*$ob->quantity",'boxno'=>"$ob->boxno",'varietyid'=>"$items->varietyid",'variety'=>"$items->variety");

	  $it++;
  }
  
  $shpconsumables = array();
  $invoiceconsumables=new Invoiceconsumables();
  $where=" where pos_invoiceconsumables.invoiceid=$ob->invoiceid ";
  $fields="pos_invoiceconsumables.id, pos_invoiceconsumables.itemid, inv_items.name itemname, inv_unitofmeasures.name unitofmeasurename, pos_invoiceconsumables.unitofmeasureid, pos_invoiceconsumables.quantity, pos_invoiceconsumables.price, pos_invoiceconsumables.total, pos_invoiceconsumables.remarks, pos_invoiceconsumables.ipaddress, pos_invoiceconsumables.createdby, pos_invoiceconsumables.createdon, pos_invoiceconsumables.lasteditedby, pos_invoiceconsumables.lasteditedon";
  $join=" left join inv_items on inv_items.id=pos_invoiceconsumables.itemid left join inv_unitofmeasures on inv_unitofmeasures.id=pos_invoiceconsumables.unitofmeasureid";
  $having="";
  $groupby="";
  $orderby="";
  $invoiceconsumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $its=0;
  
  while($consumables = mysql_fetch_object($invoiceconsumables->result)){
    $shpconsumables[$its]=array('id'=>"$ob->id",'itemid'=>"$consumables->itemid", 'itemname'=>"$consumables->itemname",'unitofmeasureid'=>"$consumables->unitofmeasureid",'unitofmeasurename'=>"$consumables->unitofmeasurename", 'quantity'=>"$consumables->quantity", 'price'=>"$consumables->price", 'total'=>"$consumables->total",'boxno'=>"$consumables->boxno");
    $its++;
  }
  
  $inv = new Invoices();
  $ob->id=$ob->invoiceid;
  if($inv->edit($ob,$shpinvoices,$shpconsumables)){
    echo "Invoice #".$row->documentno."\n";
  }
}
?>