<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once '../../sys/config/Config_class.php';
require_once("../../auth/rules/Rules_class.php");
require_once("../../con/projects/Projects_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../purchaseorderdetails/Purchaseorderdetails_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../requisitions/Requisitions_class.php");
require_once("../../proc/purchaseorders/Purchaseorders_class.php");
require_once("../../../ToWords.php");


$obj = (object)$_GET;

$supplierid=$_GET['supplierid'];
$projectid=$_GET['projectid'];
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
$fields=" *, sys_currencys.name currency ";
$join=" left join sys_currencys on sys_currencys.id=proc_purchaseorders.currencyid ";
$groupby="";
$having="";
$where=" where documentno='$obj->documentno'";
$orders->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$orders=$orders->fetchObject;

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
		
		//window.close();
		window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
 
 
 <link href="../../../css/bootstrap.css" rel="stylesheet">
<link href="../../../css/bootstrap.min.css" rel="stylesheet">
<style media="print" type="text/css">
.noprint{ display:none;}
</style>
<style media="print" type="text/css">
table{overflow-y:visible; overflow-x:hidden;}
table td {
padding: 8px;
text-align: left;
vertical-align: top;
border-top: 1px solid #ddd;
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
td{padding-left:20px !important;margin:0px !important;line-height:none !important;}
.noprint{ display:none;}
</style>
<style media="screen">
#testTable2 { height:1260px !important;}
</style>
</head>
<body onload="print_doc();">
<div align="center" id="print_content" style="width:98%; margin:0px auto;">
   <div>
   <div class="hfields" align="left">
 <div align="center" style="page-break-inside:avoid; page-break-after:avoid; page-break-before:avoid; display:block;">
<!--<img src="../../../images/logo.png" height="150" width="360"/>-->
 <span style="display:block; padding:0px 0px 2px;"><?php echo $_SESSION['companyname']; ?> </span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $_SESSION['companytitle']; ?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $_SESSION['companyaddr'];?>,<br/><?php echo $_SESSION['companytown']; ?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $_SESSION['companydesc'];?></span>
<span style="display:block; padding:0px 0px 1px;">Tel: <?php echo $_SESSION['companytel'];?></span> </div>
 
 <span style="display:block; padding:3px 10px; font-size:16px; text-align:center; font-weight:bold; color:#fff; background-color:#999">LOCAL PURCHASE  ORDER</span></div>
 
<!-- <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">-->

  <table width="100%">
<td><strong>LPO No: <?php echo $orders->documentno; ?></strong></td><td><strong>LPO Date: <?php echo formatDate($orders->orderedon); ?></strong></td><td><strong>PO Req:<?php echo $orders->requisitionno; ?></strong></td>
 
  </table>
 
 <table width="100%">
 <tr>
 <td colspan="5"><p><strong>Name And Address of the Supplier</strong></p> </td> <td colspan="5"> <p><strong>Your Reference:</strong></p> </td>
 <tr>
 <td colspan="5">

  <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">
 TO: <?php echo initialCap($suppliers->name); ?><br/>
 Tel: <?php  echo $suppliers->tel; ?><br />
 Email: <?php echo $suppliers->email; ?><br />
 </div>
 </td>
 
 
 <tr>
  <td colspan="5">
  <p><strong>Attn : Mr./Ms</strong></p>
 </td>
  <td colspan="5">
   <p><strong>Currency:</strong> <?php echo $orders->currency; ?></p>
 </td>
 </tr>

 </table>

<!-- </div>-->
   
   <table width="100%" class="table table-stripped table-bordered">
   	<tr>
		<th>#</th>
   		<th>Description</th>
   		<th>Quantity</th>
   		<th>U.O.M</th>
   		<th>Rate</th>
  		<th>VAT Applicable %</th>
  		<th>Amount</th>
   		
   	</tr>
   	<tbody>
   	
	<?php
	$purchaseorders = new Purchaseorders();
		$fields="proc_purchaseorders.id, con_projects.name as projectid, proc_purchaseorders.documentno, inv_unitofmeasures.name uom, inv_items.id as itemid,inv_items.name itemname, proc_purchaseorderdetails.tax,  proc_purchaseorderdetails.quantity, proc_purchaseorderdetails.costprice, proc_purchaseorderdetails.total, proc_purchaseorderdetails.memo, proc_purchaseorders.requisitionno, proc_suppliers.id as supplierid, proc_purchaseorders.remarks, proc_purchaseorders.orderedon, proc_purchaseorders.file, proc_purchaseorders.createdby, proc_purchaseorders.createdon, proc_purchaseorders.lasteditedby, proc_purchaseorders.lasteditedon, proc_purchaseorders.ipaddress, inv_items.package";
		$join=" left join proc_purchaseorderdetails on proc_purchaseorderdetails.purchaseorderid=proc_purchaseorders.id left join inv_items on inv_items.id=proc_purchaseorderdetails.itemid left join con_projects on proc_purchaseorders.projectid=con_projects.id  left join proc_suppliers on proc_purchaseorders.supplierid=proc_suppliers.id left join inv_unitofmeasures on inv_unitofmeasures.id=inv_items.unitofmeasureid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where proc_purchaseorders.documentno='$documentno'";
		$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$purchaseorders->result;
		$it=0;
		$total=0;
		$totaltax=0;
		while($row=mysql_fetch_object($res)){
				$it++;
			
			$total+=$row->total;
			$totaltax=$row->total*$row->tax/100;
		?>
		<tr>
			<td align="center"><?php echo $it; ?></td>
			<td align="center"><?php echo $row->itemname; ?></td>
			<td align="center"><?php echo getQntPackage($row->package,$row->quantity); ?></td>			
			<td align="center"><?php echo $row->uom; ?></td>
			<td align="right"><?php echo formatNumber($row->costprice); ?></td>
			<td align="center"><?php echo formatNumber($row->tax); ?></td>
			<td align="right"><?php echo formatNumber($row->total); ?></td>
			
		</tr>	
			<?
			
			
			
		}
	?>
		
	</tbody>
         <tr style="border:0px !important;">
	  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>  <td>&nbsp;</td>
	   <td align="right"><strong>Total Taxable:</strong></td>
	  <td align="right" style="border-bottom: 1px solid black; border-top: 1px solid black;"><strong><?php echo formatNumber($total-$totaltax);?></strong></td>
         </tr>  
         <tr>
	  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>  <td>&nbsp;</td>
	   <td align="right"><strong>VAT Total:</strong></td>
	  <td align="right" style="border-bottom: 1px solid black; border-top: 1px solid black;"><strong><?php echo formatNumber($totaltax);?></strong></td>
         </tr>   
         <tr>
	  <td colspan="5"><p>Amount in Words:-(<strong><?php $to = new toWords($total,$orders->currency); echo initialCap($to->words); ?></strong>) </p></td>
	   <td align="right"><strong>Net Amount:</strong></td>
	  <td align="right" style="border-bottom: 1px solid black; border-top: 1px solid black;"><strong><?php echo formatNumber($total);?></strong></td>
         </tr>   
        </table>
        
       <table width="100%">
       
  <tr height="80" style="font-weight:bold;">
  <td>Authorized By: __________________________________</td>
  </tr>
  <tr height="80" style="font-weight:bold;">
  <td>Date:  ______________________________________________</td>
  
  </tr>
   
     </table>

         
        
</div>
</body>
</html>
