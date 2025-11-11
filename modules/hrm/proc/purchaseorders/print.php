<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once '../../proc/config/Config_class.php';
require_once("../../auth/rules/Rules_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../purchaseorderdetails/Purchaseorderdetails_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../requisitions/Requisitions_class.php");
require_once("../../proc/purchaseorders/Purchaseorders_class.php");
require_once("../../../ToWords.php");


$obj = (object)$_GET;


$supplierid=$_GET['supplierid'];
$documentno=$_GET['documentno'];

$suppliers=New Suppliers();
$fields="*";
$having="";
$groupby="";
$orderby="";
$where=" where proc_suppliers.id='$supplierid' ";
$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $suppliers->sql;
$suppliers = $suppliers->fetchObject;	

$orders = new Purchaseorders();
$fields=" *,proc_purchaseorders.remarks remark, sys_currencys.name currency, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeeid ";
$join=" left join sys_currencys on sys_currencys.id=proc_purchaseorders.currencyid left join auth_users on auth_users.id=proc_purchaseorders.createdby left join hrm_employees on hrm_employees.id=auth_users.employeeid ";
$groupby="";
$having="";
$where=" where documentno='$obj->documentno' and proc_purchaseorders.type='$obj->type' ";
$orders->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $orders->sql;
$orders=$orders->fetchObject;

$config = new Config();
$fields=" * ";
$join="  ";
$where="";
$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);

while($con=mysql_fetch_object($config->result)){
	$_SESSION[$con->name]=$con->value;
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Local Purchase Order</title>
<script type="text/javascript">
  function print_doc()
  {
		
  		var printers = jsPrintSetup.getPrintersList().split(',');
		// Suppress print dialog
		jsPrintSetup.setSilentPrint(false);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{//alert(i+": "+printers[i]);
			if(printers[i].indexOf('<?php echo $arr['smallprinter'];?>')>-1)
			{	
				jsPrintSetup.setPrinter(printers[i]);
			}
			
		}
		 //Set Oriantation Paper
                 jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation); 
		//set number of copies to 2
		jsPrintSetup.setOption('numCopies',1);
		jsPrintSetup.setOption('headerStrCenter','');
		jsPrintSetup.setOption('headerStrRight','');
		jsPrintSetup.setOption('headerStrLeft','');
		jsPrintSetup.setOption('footerStrCenter','');
		jsPrintSetup.setOption('footerStrRight','');
		jsPrintSetup.setOption('footerStrLeft','');
		jsPrintSetup.setOption('marginLeft','1');
		jsPrintSetup.setOption('marginRight','1');
		// Do Print
		jsPrintSetup.printWindow(window);
		
		window.close();
		window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
 
 
<!-- <link href="../../../css/bootstrap.min.css" rel="stylesheet"> -->
 <link href="../../../css/bootstrap.css" rel="stylesheet">
<style media="print" type="text/css">
.noprint{ display:none;}
</style>
<style media="print" type="text/css">
.noprint{ display:none;}
</style>
<style media="print" type="text/css">
table{overflow-y:visible; overflow-x:hidden;}
table td {
text-align: left;
vertical-align: top;
border-top: 1px solid #ddd;
padding:8px;
line-height:none !important;
}
tbody{overflow-y:visible; overflow-x:visible; height:auto;}
div{overflow-y:visible; overflow-x:visible; height:auto;}
hideTr{ display:table-row;}
table tr.hideTr[style] {
   display: table-row !important;
}
div#tablePagination, div.print{display:none;}
div#tablePagination[style]{display:none !important; }
tr.brk{
page-break-after: always;
}
td{padding-left:0px !important;margin:0px !important;line-height:none !important;}
.noprint{ display:none;}
</style>
<style media="screen">
#testTable2 { height:1260px !important;}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
padding:1px;
}
</style>
</head>
<body onload="print_doc();" style="align:center;">
<div align="center" id="print_content" style="width:80%; border:1px gray solid; align:center; margin-left:10%;">
   <div>
   <div class="hfields" align="left">
 <div align="center" style="page-break-inside:avoid; page-break-after:avoid; page-break-before:avoid; display:block;">
<!--<img src="../../../images/logo.png" height="150" width="360"/>-->
 <span style="display:block; padding:3px 10px; font-size:14px; text-align:center; font-weight:bold;"><?php echo $_SESSION['companyname']; ?> </span>
<span style="display:block; padding:0px 0px 1px; font-size:11px;"><?php echo $_SESSION['companytitle']; ?></span>
<span style="display:block; padding:0px 0px 1px; font-size:11px;"><?php echo $_SESSION['companyaddr'];?>,<br/>
<span style="display:block; padding:0px 0px 1px; font-size:11px;"><?php echo $_SESSION['companydesc'];?></span>
<span style="display:block; padding:0px 0px 1px; font-size:11px;">Tel: <?php echo $_SESSION['companytel'];?></span> </div>
 
 <span style="display:block; padding:3px 10px; font-size:12px; text-align:center; font-weight:bold;">LOCAL PURCHASE  ORDER</span></div>
 
<!-- <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">-->

  <table width="100%">
<td><strong>LPO No: <?php echo $orders->documentno; ?></strong></td><td><strong>LPO Date: <?php echo formatDate($orders->orderedon); ?></strong></td><td><strong>PO Req:<?php echo $orders->requisitionno; ?></strong></td>
 
  </table>
 
 <table width="100%" style="font-size:10px;">
 <tr>
 <td colspan="5"><p><strong>Name And Address of the Supplier</strong></p> </td> <td colspan="5"> <p><strong>Your Reference:</strong></p> </td>
 <tr>
 <td colspan="5"  style="font-weight:bold;border-bottom: 0px; border-top: 0px;">

  <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">
 TO: <?php echo initialCap($suppliers->name); ?><br/>
 Tel: <?php  echo $suppliers->tel; ?><br />
 Email: <?php echo $suppliers->email; ?><br />
 </div>
 </td>
 
 
 <tr>
  <td colspan="5"  style="font-weight:bold;border-bottom: 0px; border-top: 0px;">
  <p><strong>Attn : Mr./Ms</strong></p>
 </td>
  <td colspan="1"  style="font-weight:bold;border-bottom: 0px; border-top: 0px;">
   <p><strong>Currency:</strong> <?php echo $orders->currency; ?></p>
 </td>
 </tr>
 <tr>
 <td colspan="10" align="center"><strong>Center: <?php echo $orders->remark; ?></strong></td>
 </tr>
 </table>

<!-- </div>-->
   
 <table width="100%" class="table-stripped table-bordered table"  style="line-height:7px;font-size:7px;  margin: 0px auto;  padding: 0; border-spacing: none;" cellspacing="0" cellpadding="0">

  <thead>
   	<tr>
		<th>#</th>
   		<th>Description</th>
   		<!--<th>&nbsp;</th>-->
   		<th>U.O.M</th>
   		<th>Quantity</th>
   		<th>Rate</th>
  		<th>VAT %</th>
  		<th>Discount %</th>
  		<th>Discount Amt</th>
  		<th>Amount</th>
   		
   	</tr>
   	</thead>
   	<tbody style=" vertical-align: top;">
   	
	<?php
	$purchaseorders = new Purchaseorders();
		$fields="proc_purchaseorders.id,  proc_purchaseorders.documentno, inv_unitofmeasures.name uom, inv_items.id as itemid,inv_items.name itemname, fn_expenses.name expensename, proc_purchaseorderdetails.expenseid, proc_purchaseorderdetails.tax,  proc_purchaseorderdetails.quantity, proc_purchaseorderdetails.costprice, proc_purchaseorderdetails.total,proc_purchaseorderdetails.discount, proc_purchaseorderdetails.discountamount, proc_purchaseorderdetails.memo, proc_purchaseorders.requisitionno, proc_suppliers.id as supplierid, proc_purchaseorders.remarks, proc_purchaseorders.orderedon, proc_purchaseorders.file, proc_purchaseorders.createdby, proc_purchaseorders.createdon, proc_purchaseorders.lasteditedby, proc_purchaseorders.lasteditedon, proc_purchaseorders.ipaddress,assets_categorys.id as categoryid, assets_categorys.name assetname";
		$join=" left join proc_purchaseorderdetails on proc_purchaseorderdetails.purchaseorderid=proc_purchaseorders.id left join inv_items on inv_items.id=proc_purchaseorderdetails.itemid  left join proc_suppliers on proc_purchaseorders.supplierid=proc_suppliers.id left join inv_unitofmeasures on inv_unitofmeasures.id=inv_items.unitofmeasureid left join assets_categorys on assets_categorys.id=proc_purchaseorderdetails.categoryid left join fn_expenses on fn_expenses.id=proc_purchaseorderdetails.expenseid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where proc_purchaseorders.documentno='$documentno'";
		$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $purchaseorders->sql;
		$res=$purchaseorders->result;
		$it=0;
		$total=0;
		$totaltax=0;
		while($row=mysql_fetch_object($res)){
				$it++;
			
			$total+=$row->total;
			$totaltax+=($row->quantity*$row->costprice)*$row->tax/100;
		?>
		<tr style="font-size:7px !important;">
			<td align="center" cellspacing="0"><?php echo $it; ?></td>
			<?php if($row->itemid!=NULL) { ?>
			<td align="left" cellspacing="0"><?php echo $row->itemname; ?></td>
			<?php }else{ ?>
			<td align="left" cellspacing="0"><?php echo $row->assetname.$row->expensename; ?></td>
			<?php } ?>
			<!--<td align="left" cellspacing="0"><?php echo $row->memo; ?></td>-->
			<td align="center" cellspacing="0"><?php echo $row->uom; ?></td>
			<td align="center" cellspacing="0"><div align="center"><?php echo $row->quantity; ?></div></td>
			<td align="right" cellspacing="0"><div align="right"><?php echo formatNumber($row->costprice); ?></div></td>
			<td align="center" cellspacing="0"><div align="center"><?php if(!empty($row->tax)){echo $row->tax;} ?></div></td>
			<td align="right" cellspacing="0"><div align="right"><?php echo $row->discount; ?></div></td>
			<td align="right" cellspacing="0"><div align="right"><?php echo formatNumber($row->discountamount); ?></div></td>
			<td align="right" cellspacing="0"><div align="right"><?php echo formatNumber($row->total); ?></div></td>
			
		</tr>	
			<?
			
			
			
		}
	?>
		
	</tbody>
         <tr style="border:0px 0px 0px !important; line-height:;">
	  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>  <td>&nbsp;</td>
	   <td align="right"><strong>Total Taxable:</strong></td>
	  <td align="right" style="border-bottom: 1px solid black; border-top: 1px solid black;"><strong><div align="right"><?php echo formatNumber($total-$totaltax);?></div></strong></td>
         </tr>  
         <tr>
	  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>  <td>&nbsp;</td>
	   <td align="right"><strong>VAT Total:</strong></td>
	  <td align="right" style="border-bottom: 1px solid black; border-top: 1px solid black;"><strong><div align="right"><?php echo formatNumber($totaltax);?></div></strong></td>
         </tr>   
         <tr>
	  <td colspan="5"><p>Amount in Words:-(<strong><?php $to = new toWords($total,$orders->currency); echo initialCap($to->words); ?></strong>) </p></td>
	   <td align="right"><strong>Net Amount:</strong></td>
	  <td align="right" style="border-bottom: 1px solid black; border-top: 1px solid black;"><strong><div align="right"><?php echo formatNumber($total);?></div></strong></td>
         </tr>   
        </table>
        
       <table width="100%" style="font-size:10px;">
       <tr height="20" style="font-weight:bold;border-bottom: 0px; border-top: 0px;">
  <td style="font-weight:bold;border-bottom: 0px; border-top: 0px;">Prepared  By:_______________________ </td><td style="font-weight:bold;border-bottom: 0px; border-top: 0px;"> Date: ________________________</td>
  </tr>
   <tr height="20" style="font-weight:bold;border-bottom: 0px; border-top: 0px;">
  <td valign="top" style="font-weight:bold;border-bottom: 0px; border-top: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $orders->employeeid; ?> </td><td style="font-weight:bold;border-bottom: 0px; border-top: 0px;">&nbsp;</td>
  </tr>
  <tr height="30" style="font-weight:bold;">
  <td style="font-weight:bold;border-bottom: 0px; border-top: 0px;">Checked By: ________________________</td><td style="font-weight:bold;border-bottom: 0px; border-top: 0px;">Date:  ________________________</td>
  </tr>
  <tr height="30" style="font-weight:bold;">
  <td style="font-weight:bold;border-bottom: 0px; border-top: 0px;">Authorised By: ________________________</td><td style="font-weight:bold;border-bottom: 0px; border-top: 0px;">Date:  ________________________</td>
  
  </tr>
  
  <tr height="80" style="font-weight:bold;">
  <td colspan='2' valign="bottom" style="font-weight:bold;border-bottom: 0px; border-top: 0px;">Official Stamp</td>
  
  </tr>
  
  <tr style="font-weight:italics;">
  <td colspan='2' style="font-weight:bold;border-bottom: 0px; border-top: 0px;"  align="center"><?php echo $_SESSION['DISCLAIMER'];?></td>
  
  </tr>
   
     </table>

         
        
</div>
</body>
</html>
