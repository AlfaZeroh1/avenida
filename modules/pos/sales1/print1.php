<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once '../../sys/config/Config_class.php';
require_once("../../hos/patients/Patients_class.php");
require_once("../../pos/sales/Sales_class.php");

$obj = (object)$_GET;

$config = new Config();
$fields="*";
$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$arr = array();
while($rw=mysql_fetch_object($config->result)){
	$arr[$rw->name]=$rw->value;
}

$patients = new Patients();
$fields=" * ";
$where=" where id=(select patientid from pos_sales where documentno='$obj->doc') ";
$join="";
$having="";
$groupby="";
$orderby="";
$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby); //echo $patients->sql;
$patients=$patients->fetchObject;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
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
<style media="print" type="text/css">
.noprint{ display:none;}
</style>

</head>
<body onload="print_doc();">
<div align="center" id="print_content" style="width:98%; margin:0px auto;">
   <div>
   <div class="hfields" align="left">
 <div align="center" style="font-weight:bold;page-break-inside:avoid; page-break-after:avoid; page-break-before:avoid; display:block;">

 <span style="display:block; padding:0px 0px 2px;"><?php echo $arr['companyname']; ?> </span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $arr['companytitle']; ?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $arr['companyaddr'];?>,<br/><?php echo $arr['companytown']; ?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $arr['companydesc'];?></span>
<span style="display:block; padding:0px 0px 1px;">Tel: <?php echo $arr['companytel'];?></span> </div>
 
 <span style="display:block; padding:3px 10px; font-size:16px; text-align:center; font-weight:bold; color:#fff; background-color:#999">Receipt</span></div>
 <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">
 <hr/>
 Patient: <?php echo initialCap($patients->surname." ".$patients->othernames); ?><br/>
 Receipt No: <?php  echo $obj->doc; ?><br />
 Served By: <?php echo $_SESSION['username']; ?><br /><hr/></div>
 
   </div>
   
   <table width="100%">
   <tr>
   <th>#</th>
   <th>Item</th>
   <th>Price</th>
   <th>Quantity</th>
   <th>Total</th>
   </tr>
   <tbody>
			<?php 
			
			$i=0;
			$balance=0;
			$sales = new Sales();
			  $fields=" inv_items.name itemid, pos_sales.retailprice, pos_sales.quantity, pos_sales.total ";
			  $join=" left join inv_items on pos_sales.itemid=inv_items.id ";
			  $having="";
			  $groupby="";
			  $orderby="";					
			  $where=" where pos_sales.documentno='$obj->doc' ";
			  $sales->retrieve($fields,$join,$where,$having,$groupby,$orderby);/*echo $payables->sql;*/
			  $res=$sales->result;
			
			  while($row=mysql_fetch_object($res)){$i++;
			  $total+=($row->quantity*$row->retailprice);
				  ?>
				  <tr <?php if($row->paid=="No" or empty($row->paid)){?>bgcolor=""<?php }else{?>bgcolor="green"<?php }?>>
					  <td style="border-bottom:1px solid white; " ><?php echo $i; ?></td>
					  <td style="border-bottom:1px solid white; ">&nbsp;<?php echo $row->itemid; ?></td>
					  <td style="border-bottom:1px solid white; ">&nbsp;<?php echo $row->retailprice; ?></td>
					  <td style="border-bottom:1px solid white; ">&nbsp;<?php echo $row->quantity; ?></td>
					  <td style="border-bottom:1px solid white; " align="right">&nbsp;<?php echo formatNumber($row->quantity*$row->retailprice); ?></td>
					  
				  </tr>
				  <?php 
				  }
			?>
			</tbody>
			<tfoot>
			<tr>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
			      <th style="border-bottom:1px solid white; ">Total:</th>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
			      <th style="border-bottom:1px solid white;text-decoration:underline; " align="right" bgcolor=""><?php echo formatNumber($total); ?></th>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
		      </tr>
		      </tfoot>
   
   </table>
  
</div>
</body>
</html>
