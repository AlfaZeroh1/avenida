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
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../proc/inwarddetails/Inwarddetails_class.php");
require_once("../../inv/issuance/Issuance_class.php");
require_once("../../inv/issuancedetails/Issuancedetails_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../inv/purchases/Purchases_class.php");
require_once("../../inv/purchasedetails/Purchasedetails_class.php");
require_once("../../fn/supplierpayments/Supplierpayments_class.php");

echo "PURCHACES\n";
$purchase = new Purchases();
$fields=" distinct documentno ";
$where="  ";
$join=" ";
$having="";
$groupby="";
$orderby="   ";
$purchase->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($rows=mysql_fetch_object($purchase->result)){
  
  $purchases=new Purchases();
	  $where=" where documentno='$rows->documentno' and (inv_purchasedetails.itemid>0 or inv_purchasedetails.assetid>0) ";
	  $fields="inv_purchasedetails.id,inv_purchases.supplierid, inv_purchasedetails.quantity,inv_purchasedetails.itemid, inv_items.name itemname, inv_assets.id as assetid, inv_assets.name assetname, inv_items.code, inv_purchasedetails.vatclasseid, inv_purchasedetails.tax, inv_purchasedetails.costprice,  inv_purchasedetails.discount, inv_purchasedetails.memo,inv_purchases.receiptno,inv_purchases.lpono,  inv_purchasedetails.vatamount, inv_purchasedetails.total, inv_purchasedetails.discount, inv_purchasedetails.discountamount, inv_purchases.documentno, inv_purchases.remarks, inv_purchases.purchasemodeid, inv_purchases.boughton, inv_purchases.currencyid, inv_purchases.exchangerate, inv_purchases.exchangerate2, inv_purchases.createdby, inv_purchases.createdon, inv_purchases.lasteditedby, inv_purchases.lasteditedon, inv_purchases.ipaddress ";
	  $join=" left join inv_purchasedetails on inv_purchasedetails.purchaseid=inv_purchases.id left join inv_items on inv_items.id=inv_purchasedetails.itemid left join inv_assets on inv_assets.id=inv_purchasedetails.assetid ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $purchases->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $purchases->sql;
	  $it=0;
	  $shppurchases=array();
	  while($row = mysql_fetch_object($purchases->result)){
	      	  
	      $ob=$row;
	      
	      $ob->exctotal=$ob->total-$ob->vatamount;
	      
// 	      $quantity=$ob->quantity-$returnoutwarddetails->quantity;echo $quantity;
// 	      $vatamount=$ob->vatamount-$returnoutwarddetails->vatamount;
// 	      $total=$ob->total-$returnoutwarddetails->total;
              if(!empty($obj->itemid) and $obj->itemid!=NULL and $obj->itemid!='NULL'){
              $items = new Items();
	      $fields="*";
	      $where=" where id='$obj->itemid'";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $items=$items->fetchObject;
				
              $generaljournalaccounts2 = new Generaljournalaccounts();
	      $fields="*";
	      $where=" where refid = '$items->categoryid' and acctypeid='34' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
	      }elseif(!empty($obj->assetid) and $obj->assetid!=NULL and $obj->assetid!='NULL'){
	      $assets = new Assets();
	      $fields="*";
	      $where=" where id='$obj->assetid' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $assets->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $assets=$assets->fetchObject;
				  
	      $generaljournalaccounts2 = new Generaljournalaccounts();
	      $fields="*";
	      $where=" where refid='$assets->categoryid' and acctypeid='7' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
	      }		
	      
	      $shppurchases[$it]=array('id'=>"$ob->id",'quantity'=>"$ob->quantity",'accountid'=>"$generaljournalaccounts2->id", 'itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname",'assetid'=>"$ob->assetid", 'assetname'=>"$ob->assetname", 'code'=>"$ob->code", 'vatclasseid'=>"$ob->vatclasseid", 'tax'=>"$ob->tax", 'costprice'=>"$ob->costprice", 'discount'=>"$ob->discount", 'discountamount'=>"$ob->discountamount", 'tradeprice'=>"$ob->tradeprice", 'discount'=>"$ob->discount", 'remarks'=>"$ob->remarks",'vatamount'=>"$ob->vatamount", 'total'=>"$ob->exctotal",'ttotal'=>"$ob->total");
	      
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
	  $suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $suppliers->sql;
	  $auto=$suppliers->fetchObject;
	  $ob->suppliername=$auto->name;
	  
	  $obj = (object) array_merge((array) $obj, (array) $ob);
// 	  $obj = (object) array_merge((array) $obj, (array) $auto);
	  
	  //get jvno
	  $query="select distinct jvno from fn_generaljournals where documentno='$obj->documentno' and transactionid=23";
	  $jvs = mysql_fetch_object(mysql_query($query));
	  $obj->jvno = $jvs->jvno;
	  
	  if(!empty($obj->jvno)){
	    mysql_query("delete from fn_generaljournals where jvno='$obj->jvno'");
	  }  

  $inv = new Purchases();
  $obj->effectjournals=1;
  $obj->balance=0;
  if($inv->add($obj,$shppurchases)){
    echo "PURCHASE #".$rows->documentno."\n";
  }
}

// echo "SUPPLIER PAYMENTS\n";
// $supplierpayments = new Supplierpayments();
// $fields="*";
// $where="";
// $join="";
// $having="";
// $groupby="";
// $orderby="";
// $supplierpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// while($row=mysql_fetch_object($supplierpayments->result)){
//   $inv = new Supplierpayments();
//   $row->amount1=$row->amount;
//   if($inv->edit($row,$shop)){
//     echo "SUPPLIER PAYMENTS #".$row->documentno."\n";
//   }
// }

?>