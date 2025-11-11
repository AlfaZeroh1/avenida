<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once '../../sys/config/Config_class.php';
require_once("../../auth/rules/Rules_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../inwarddetails/Inwarddetails_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../requisitions/Requisitions_class.php");
require_once("../../proc/inwards/Inwards_class.php");
require_once("../../../ToWords.php");
require_once("../../sys/currencys/Currencys_class.php");


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

$orders = new Inwards();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where documentno='$obj->documentno'";
$orders->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$orders=$orders->fetchObject;

$currencys = new Currencys();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where id='$orders->currencyid'";
$currencys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$currencys=$currencys->fetchObject;

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Goods Received Note</title>
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
 
 <span style="display:block; padding:3px 10px; font-size:16px; text-align:center; font-weight:bold; color:#fff; background-color:#999"><?php if($orders->type=="in"){?>GOODS RECEIVED<?php }else{?>RETURN<?php } ?> NOTE</span></div>
 
<!-- <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">-->
 <hr/>
  <table width="100%">
<td><strong><?php if($orders->type=="in"){?>GRN<?php }else{ ?>RETURN<?php } ?> No: <?php echo $orders->documentno; ?></strong></td><td><strong><?php if($orders->type=="in"){?>GRN<?php }else{ ?>RETURN<?php } ?> Date: <?php echo formatDate($orders->inwarddate); ?></strong></td>
<td><strong>LPO No: <?php echo $orders->lpono; ?></strong></td>
 
  </table>
  <hr/>
 <table width="100%">
 
 <tr>
 <td colspan="5">

  <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">
 <strong><?php if($orders->type=="in"){?>Received From<?php }else{ ?>Returned To<?php } ?></strong>:<br/> <?php echo initialCap($suppliers->name); ?><br/>
 Tel: <?php  echo $suppliers->tel; ?><br />
 Email: <?php echo $suppliers->email; ?><br />
 </div>
 </td>
  <td colspan="5" valign="top"> <p><strong>Your Reference:</strong> <?php echo $orders->deliverynoteno; ?> </td>
  </tr>
 </table>
 <hr>
<!-- </div>-->
   
   <table width="100%" class="table table-stripped table-bordered">
   	<tr>
		<th>#</th>
   		<th>Description</th>
   		<th>U.O.M</th>
   		<th>Quantity</th>
   		<th>Rate</th>
  		<th>Amount</th>
   		
   	</tr>
   	<tbody>
   	
	<?php
	$inwards = new Inwards();
		$fields="proc_inwards.id, con_projects.name as projectid, proc_inwards.documentno, inv_unitofmeasures.name uom, inv_items.id as itemid,inv_items.name itemname,  proc_inwarddetails.quantity, proc_inwarddetails.costprice, proc_inwarddetails.total, proc_inwarddetails.memo, proc_inwards.deliverynoteno, proc_suppliers.id as supplierid, proc_inwards.remarks, proc_inwards.inwarddate, proc_inwards.file, proc_inwards.createdby, proc_inwards.createdon, proc_inwards.lasteditedby, proc_inwards.lasteditedon, proc_inwards.ipaddress";
		$join=" left join proc_inwarddetails on proc_inwarddetails.inwardid=proc_inwards.id left join inv_items on inv_items.id=proc_inwarddetails.itemid left join con_projects on proc_inwards.projectid=con_projects.id  left join proc_suppliers on proc_inwards.supplierid=proc_suppliers.id left join inv_unitofmeasures on inv_unitofmeasures.id=inv_items.unitofmeasureid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where proc_inwards.documentno='$documentno'";
		$inwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo mysql_error();
		$res=$inwards->result;
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
			<td align="center"><?php echo $row->uom; ?></td>
			<td align="center"><?php echo $row->quantity; ?></td>
			<td align="right"><?php echo formatNumber($row->costprice); ?></td>
			<td align="right"><?php echo formatNumber($row->total); ?></td>
			
		</tr>	
			<?
			
			
			
		}
	?>
		
	</tbody>
         <tr style="border:0px !important;">
	  <td colspan="4"><p>Amount in Words:-(<strong><?php $to = new toWords($total,$currencys->name); echo initialCap($to->words); ?></strong>) </p></td>
	   <td align="right"><strong>Total(<?php echo $currencys->name; ?>):</strong></td>
	  <td align="right" style="border-bottom: 1px solid black; border-top: 1px solid black;"><strong><?php echo formatNumber($total);?></strong></td>
         </tr> 
        </table>
        
       <table width="100%">
       <tr><td><hr /></td></tr>
  <tr height="80" style="font-weight:bold;">
  <td>Authorized By: __________________________________</td>
  </tr>
  <tr height="80" style="font-weight:bold;">
  <td>Date:  ______________________________________________</td>
  
  </tr>
   <tr><td><hr /></td></tr>
     </table>

         
        
</div>
</body>
</html>
