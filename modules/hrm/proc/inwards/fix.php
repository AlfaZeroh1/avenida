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
require_once("../../hrm/departments/Departments_class.php");
require_once("../../inv/purchasedetails/Purchasedetails_class.php");
require_once("../../fn/supplierpayments/Supplierpayments_class.php");
// require_once '../../ProgressBar/Manager.php';
// require_once '../../ProgressBar/Registry.php';

// echo "GRN's\n";
$inwardss = new Inwards();
$fields=" distinct documentno ";
$where=" where journals='Yes' ";
$join=" ";
$having="";
$groupby="";
$orderby="   ";
$inwardss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($rows=mysql_fetch_object($inwardss->result)){
      $obj->type="in";
      $inwards = new Inwards();
      $fields="proc_inwards.id,proc_inwards.currencyid,proc_inwards.lpono,proc_inwards.rate,proc_inwards.eurorate,  proc_inwards.documentno, inv_items.id as itemid,inv_items.name itemname, assets_categorys.id assetid, assets_categorys.name assetname,  proc_inwarddetails.quantity, proc_inwarddetails.costprice, proc_inwarddetails.total, proc_inwarddetails.memo, proc_inwards.documentno, proc_suppliers.id as supplierid, proc_inwards.remarks, proc_inwards.journals, inv_items.categoryid, proc_inwards.inwarddate, proc_inwards.file, proc_inwards.createdby, proc_inwards.createdon, proc_inwards.lasteditedby, proc_inwards.lasteditedon, proc_inwards.ipaddress, inv_categorys.name categoryname, proc_inwarddetails.vatclasseid, proc_inwarddetails.tax, proc_inwarddetails.discount, proc_inwarddetails.discountamount ";
      $join=" left join proc_inwarddetails on proc_inwarddetails.inwardid=proc_inwards.id left join inv_items on inv_items.id=proc_inwarddetails.itemid left join proc_suppliers on proc_inwards.supplierid=proc_suppliers.id left join inv_categorys on inv_categorys.id=inv_items.categoryid left join assets_categorys on assets_categorys.id=proc_inwarddetails.categoryid ";
      $having="";
      $groupby="";
      $orderby="";
      $where=" where proc_inwards.documentno='$rows->documentno' and (proc_inwarddetails.itemid>0)";
      if($obj->return==1){
      }else{
	$where.="  and proc_inwards.type='$obj->type'  ";
      }
      $inwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      $res=$inwards->result;
      $it=0;
      $shpinwards=array();
      
      $docss="";
      while($row=mysql_fetch_object($res)){

	      $ob=$row;
	      $row->vatamount=(($row->quantity*$row->costprice)-($row->quantity*$row->costprice*$row->discount/100))*($row->tax/100);
	      $shpinwards[$it]=array('id'=>"true",'quantity'=>"$row->quantity", 'itemid'=>"$row->itemid", 'itemname'=>"$ob->itemname", 'assetid'=>"$row->assetid", 'assetname'=>"$ob->assetname", 'code'=>"$row->code", 'discount'=>"$row->discount", 'discountamount'=>"$row->discountamount", 'vatclasseid'=>"$row->vatclasseid", 'tax'=>"$row->tax", 'vatamount'=>"$row->vatamount", 'costprice'=>"$row->costprice", 'tradeprice'=>"$row->tradeprice", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon",'categoryid'=>"$row->categoryid", 'categoryname'=>"$row->categoryname");

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
      
      //get jvno
      $query="select distinct jvno from fn_generaljournals where documentno='$obj->documentno' and transactionid=11";
      $jvs = mysql_fetch_object(mysql_query($query));
      $obj->jvno = $jvs->jvno;
      
      if(!empty($obj->jvno)){
	mysql_query("delete from fn_generaljournals where jvno='$obj->jvno'");
      }      

      $inv = new Inwards();
      // $ob->id=$ob->inwardid;
      $obj->effectjournals=1;
      if($inv->add($obj,$shpinwards)){
	echo "GRN #".$rows->documentno."\n";
      }
}
?>