<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once '../../sys/config/Config_class.php';
require_once("../../auth/rules/Rules_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../inv/issuance/Issuance_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../inv/issuancedetails/Issuancedetails_class.php");
require_once("../../../ToWords.php");


$obj = (object)$_GET;

$issuance=new Issuance();
$where=" where documentno='$obj->documentno' ";
$fields="inv_issuance.id, inv_departments.name as departmentname, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, inv_issuance.issuedon, inv_issuance.documentno, inv_issuance.remarks, inv_issuance.memo, inv_issuance.received, inv_issuance.receivedon,inv_issuance.requisitionno,inv_issuance.rate, inv_issuance.createdby, inv_issuance.createdon, inv_issuance.lasteditedby, inv_issuance.lasteditedon, inv_issuance.ipaddress";
$join=" left join hrm_employees on hrm_employees.id=inv_issuance.employeeid left join inv_departments on inv_departments.departmentid=inv_issuance.departmentid ";
$having="";
$groupby="";
$orderby="";
$issuance->retrieve($fields,$join,$where,$having,$groupby,$orderby);
//echo $issuance->sql;
$issuance=$issuance->fetchObject;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ISSUANCE FORM</title>
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
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
padding:1px;
}
</style>
</head>
<body onload="print_doc();">
<div align="center" id="print_content" style="width:80%; border:1px gray solid; align:center; margin-left:10%;">
   <div>
   <div class="hfields" align="left">
 <div align="center" style="page-break-inside:avoid; page-break-after:avoid; page-break-before:avoid; display:block;">
<!--<img src="../../../images/logo.png" height="150" width="360"/>-->
 <span style="display:block; padding:0px 0px 2px;"><?php echo $_SESSION['companyname']; ?> </span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $_SESSION['companytitle']; ?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $_SESSION['companyaddr'];?>,<br/><?php echo $_SESSION['companytown']; ?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $_SESSION['companydesc'];?></span>
<span style="display:block; padding:0px 0px 1px;">Tel: <?php echo $_SESSION['companytel'];?></span> </div>
 
 <span style="display:block; padding:3px 10px; font-size:16px; text-align:center; font-weight:bold; color:#fff; background-color:#999">ISSUANCE FORM</span></div>
 
<!-- <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">-->
 <hr/>
  <table width="100%">
<td><strong>Issuance No: <?php echo $obj->documentno; ?></strong></td><td><strong>Issued On: <?php echo formatDate($issuance->issuedon); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Requisition  No: <?php echo $issuance->requisitionno; ?></strong></td></td>
 
  </table>
  <hr/>
 <table width="100%">
 
 <td colspan="5">

  <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">
 Requested By: <?php echo initialCap($issuance->employeeid); ?><br/>
 Department: <?php  echo $issuance->departmentname; ?><br />
 <p> <?php echo $issuance->memo; ?></p><br />
 </div>
 </td>

 </table>
 <hr>
<!-- </div>-->
   
   <table width="100%" class="table-stripped table-bordered table" style="line-height:none;font-size:8px;">
   	<tr>
		<th>#</th>
   		<th>Description</th>
   		<th>U.O.M</th>
   		<th>Quantity</th>
   		<th>Rate</th>
  		<th>Amount</th>
  		<th>Purpose</th>
  		<th>Block</th>
  		<th>Name & Signature</th>
   		
   	</tr>
   	<tbody>
   	
	<?php
	$issuancedetails = new Issuancedetails();
		$fields="inv_items.name itemname, inv_unitofmeasures.name unitofmeasureid, inv_issuancedetails.quantity, inv_issuancedetails.costprice, inv_issuancedetails.purpose, inv_issuancedetails.total, prod_blocks.name blockid, prod_sections.name sectionid, prod_greenhouses.name greenhouseid, assets_fleets.assetid fleetid";
		$join=" left join inv_items on inv_items.id=inv_issuancedetails.itemid left join inv_unitofmeasures on inv_unitofmeasures.id=inv_items.unitofmeasureid left join prod_blocks on prod_blocks.id=inv_issuancedetails.blockid left join prod_sections on prod_sections.id=inv_issuancedetails.sectionid left join prod_greenhouses on prod_greenhouses.id=inv_issuancedetails.greenhouseid left join assets_fleets on assets_fleets.id=inv_issuancedetails.fleetid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where inv_issuancedetails.issuanceid='$issuance->id'";
		$issuancedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		//echo $issuancedetails->sql;
		$res=$issuancedetails->result;
		$it=0;
		$total=0;
		$totaltax=0;
		while($row=mysql_fetch_object($res)){
				$it++;
			
			$total+=$row->total;
		?>
		<tr>
			<td align="center"><?php echo $it; ?></td>
			<td align="center"><?php echo $row->itemname; ?></td>
			<td align="center"><?php echo $row->unitofmeasureid; ?></td>
			<td align="center"><?php echo $row->quantity; ?></td>			
			<td align="right"><?php echo formatNumber($row->costprice); ?></td>
			<td align="right"><?php echo formatNumber($row->total); ?></td>
			<td align="center"><?php echo $row->purpose; ?></td>
			<td align="center"><?php echo $row->blockid; ?>&nbsp;<?php echo $row->sectionid; ?>&nbsp;<?php echo $row->greenhouseid; ?></td>
			<td align="center"><?php  ?></td>
			
		</tr>	
			<?
			
			
			
		}
	?>
		
	</tbody>
         <tr style="border:0px !important;">
	  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> 
	   <td align="right"><strong>Total:</strong></td>
	  <td align="right" style="border-bottom: 1px solid black; border-top: 1px solid black;"><strong><?php echo formatNumber($total);?></strong></td>
         </tr> 
        </table>
        
       <table width="100%">
       <tr><td><hr /></td></tr>
  <tr style="font-weight:bold;">
  <td>Issued By: </td>
  </tr>
  <tr style="font-weight:bold;">
  <td>Sign:  ________________ Date: ______________________________</td>
  
  </tr>
  
  <tr><td><hr /></td></tr>
  <tr style="font-weight:bold;">
  <td>Received By: </td>
  </tr>
  <tr style="font-weight:bold;">
  <td>Sign:  ___________________ Date: ___________________________</td>
  
  </tr>
  
   <tr><td><hr /></td></tr>
     </table>

         
        
</div>
</body>
</html>
