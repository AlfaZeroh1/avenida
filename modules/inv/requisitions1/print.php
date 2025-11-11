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
require_once("../../inv/requisitions/Requisitions_class.php");
require_once("../../inv/requisitiondetails/Requisitiondetails_class.php");
require_once("../../../ToWords.php");


$obj = (object)$_GET;

$requisitions=New Requisitions();
$fields="inv_requisitions.id, sys_branches.name brancheid, inv_requisitions.employeeid, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeename, inv_requisitions.documentno, inv_requisitions.itemid, inv_items.name itemname, inv_requisitions.quantity, inv_requisitions.aquantity, inv_requisitions.memo, inv_requisitions.requisitiondate, inv_requisitions.remarks, inv_requisitions.status, inv_requisitions.ipaddress, inv_requisitions.createdby, inv_requisitions.createdon, inv_requisitions.lasteditedby, inv_requisitions.lasteditedon";
$join="left join inv_items on inv_items.id=inv_requisitions.itemid left join hrm_employees on hrm_employees.id=inv_requisitions.employeeid left join sys_branches on inv_requisitions.brancheid=sys_branches.id";
$having="";
$groupby="";
$orderby="";
$where=" where inv_requisitions.documentno='$obj->doc'";
$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $requisitions->sql;
$requisitions = $requisitions->fetchObject;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REQUISITION FORM</title>
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
 
 <span style="display:block; padding:3px 10px; font-size:16px; text-align:center; font-weight:bold; color:#fff; background-color:#999">REQUISITION </span></div>
 
<!-- <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">-->
 <hr/>
  <table width="100%">
<td><strong>Requisition No: <?php echo $obj->doc; ?></strong></td><td><strong></strong></td><td><strong>
 
  </table>
  <hr/>
 <table width="100%">
 
 <td colspan="5">

  <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">
 
 <strong>Solar Center: </strong><?php echo $requisitions->brancheid; ?></br>
 <strong>Requested By: </strong><?php echo $requisitions->employeename; ?></br>
 <strong>Requested On: </strong><?php echo formatDate($requisitions->requisitiondate); ?>
 </div>
 </td>

 </table>
 <hr>
<!-- </div>-->
   
   <table width="100%" class="table-stripped table-bordered table" style="line-height:none;font-size:8px;">
   	<tr>
		<th>#</th>
   		<th>Item</th>
   		<th>Quantity</th>
   		<th>Approved Quantity</th>
   		<th>Dispatch Quantity</th>
  		<th>Memo</th>
  		
   		
   	</tr>
   	<tbody>
   	
	<?php
	
		$requisition= new Requisitions();
		$fields="inv_requisitions.id, sys_branches.name brancheid, inv_requisitions.employeeid, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeename, inv_requisitions.documentno, inv_requisitions.itemid, inv_items.name itemname, inv_requisitions.quantity, inv_requisitions.aquantity, inv_requisitions.memo, inv_requisitions.requisitiondate, inv_requisitions.remarks, inv_requisitions.status, inv_requisitions.ipaddress, inv_requisitions.createdby, inv_requisitions.createdon, inv_requisitions.lasteditedby, inv_requisitions.lasteditedon";
		$join="left join inv_items on inv_items.id=inv_requisitions.itemid left join hrm_employees on hrm_employees.id=inv_requisitions.employeeid left join sys_branches on inv_requisitions.brancheid=sys_branches.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="where inv_requisitions.documentno='$obj->doc'";
		$requisition->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $requisition->sql;//echo mysql_error();
		//echo $requisitiondetails->sql;
		$res=$requisition->result;
		$it=0;
		$total=0;
		$totaltax=0;
		$aquantity=0;
		while($row=mysql_fetch_object($res)){
				$it++;
		
			
			$total+=($row->quantity);
			
		?>
		<tr>
			<td align="center"><?php echo $it; ?></td>
			<td><?php echo $row->itemname; ?> </td>
			<td><?php echo $row->quantity; ?> </td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo $row->quantity; ?> </td>
			<td><?php echo $row->memo; ?>
			
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
  <tr height="80" style="font-weight:bold;">
 <!-- <td>Requested By: <u><?php echo initialCap($requisitions->employeeid);?></u></td>-->
  </tr>
  <tr height="80" style="font-weight:bold;">
  <td>Approved By:  ________________ Date: ______________________________</td>
   </tr> <tr   height="80" style="font-weight:bold;">
  <td>Signed By:  __________________ Date: ______________________________</td>
  
  </tr>
  
   <tr><td><hr /></td></tr>
     </table>

         
        
</div>
</body>
</html>
