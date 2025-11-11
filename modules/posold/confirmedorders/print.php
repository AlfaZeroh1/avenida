<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once("../../crm/customers/Customers_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../assets/fleets/Fleets_class.php");
require_once("../confirmedorderdetails/Confirmedorderdetails_class.php");
require_once("../../pos/confirmedorders/Confirmedorders_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../prod/sizes/Sizes_class.php");


$doc=$_GET['doc'];
$customerid=$_GET['customerid'];
$packedon = $_GET['packedon'];

		$customers = New Customers();
		$fields="crm_customers.id, crm_customers.name, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="where crm_customers.id='$customerid'";
		$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $customers->sql;
		$customers=$customers->fetchObject;		
	

$confirmedorders = new Confirmedorders();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where orderno='$doc'";
$confirmedorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $customers->sql;
$confirmedorders=$confirmedorders->fetchObject;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../../fs-css/printable.css" media="all" type="text/css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>

<script type="text/javascript">
  function print_doc()
  {
  		var printers = jsPrintSetup.getPrintersList().split(',');
		// Suppress print dialog
		jsPrintSetup.setSilentPrint(false);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{//alert(i+": "+printers[i]);
		//alert(printers[i]+"="+'<?php echo $_SESSION["smallprinter"];?>');
			if(printers[i].indexOf('<?php echo $_SESSION["smallprinter"];?>')>-1)
			{	//alert(i+": "+printers[i]);
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
		jsPrintSetup.setOption('marginTop','3.2');
		jsPrintSetup.setOption('marginBottom','0');
		jsPrintSetup.setOption('marginLeft','4.8');
		jsPrintSetup.setOption('marginRight','');
		
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
 
  }
 </script>
  <link href="../../../css/bootstrap.css" rel="stylesheet">
<link href="../../../css/bootstrap.min.css" rel="stylesheet">
<style media="all" type="text/css">
body{margin:0px;padding:0px;}
table{width:100%;overflow-y:visible; overflow-x:hidden;border:1px solid #ccc;margin:0px;padding:0px;}
td{border:1px dotted #ccc;}pos
table{overflow-y:visible; overflow-x:hidden;}
tbody{overflow-y:visible; overflow-x:visible; height:auto;}
div{overflow-y:visible; overflow-x:visible; height:auto;}
hideTr{ display:table-row;}
table tr.hideTr[style] {
   display: table-row !important;
}
.fnt{font-family:tahoma;font-size:9px;}
.fntt{font-family: tahoma ;font-size:10px;}
div#tablePagination, div.print{display:none;}
div#tablePagination[style]{display:none !important; }
tr.brk{
page-break-after: always;
}
.noprint{ display:none;}
</style>
<style media="screen">
#testTable2 {width:100%; height:1160px !important;}
</style>
</head>

<body onload="print_doc();">
<!--<div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div>-->
<!-- headder -->

<table class="table table-stripped">
<tr>
<td colspan="7">
<div style="text-align:center"> 
 <div style="text-align:center;text-transform:uppercase;"><strong><?php echo $_SESSION['companyname']; ?></strong>
            <div class="fntt"><span class="desc"><?php echo $_SESSION['companydesc']; ?></span>
            <span class="addr"><?php echo $_SESSION['companActual/V.weight Ratioyaddr']; ?>,<?php echo $_SESSION['companytown']; ?></span><br />
            <span class="tel"><strong>Tel:</strong> <?php echo $_SESSION['companytel']; ?> </span>  <br/>
            <strong>Website:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyweb']; ?></span> &nbsp;&nbsp;
            <strong>Email:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyemail']; ?></span><br />
<p><span class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <span class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span></p>
</td>
</tr>
<tr>
<td colspan="7" align="center" style="text-align:center;">
<strong>
          CONFIRMED ORDERS
            <?php
            if($_GET['retrieved']==1){
				?>
				- Copy
				<?php 
			}
			?>
            </h2>
            </strong>   
            </span>
            </div>
</td>
</tr>


<tr>
	
<td width="50%" colspan="3">
<div style="font-size:11px !important;">&nbsp;CUSTOMER:<?php echo initialCap($customers->name); ?></div>
<div style="font-size:11px !important;">LOCATION:<?php echo $customers->address; ?></div>
</td>

<td width="50%" colspan="4">
<div style="font-size:11px !important;"><STRONG>ORDER PREPARATIONS DATE: <?php echo $packedon; ?></STRONG></div>
<div style="font-size:11px !important;">ORDER NO:  <?php echo $doc; ?></div>

<div style="font-size:10px !important;"><?php echo $confirmedorders->remarks; ?></div>

</td>
</tr>





</table>
<table width="100%" class="table table-stripped table-bordered">
   	<tr>
			      <th>#</th>
			      <th>ITEM</th>
			      <th>LENGTH</th>
			      <th>PACK RATE</th>
			      <th>NO OF BOXES</th>
			      <th>TOTAL STEMS</th>
			      <th>MEMO</th>
	</tr>
	
	<?php
		$i=0;
		$confirmedorderdetails = New Confirmedorderdetails();
		$fields=" pos_confirmedorderdetails.itemid,pos_confirmedorderdetails.memo,pos_confirmedorderdetails.quantity quantity,pos_confirmedorderdetails.packrate packrate,pos_confirmedorders.id,pos_items.name,pos_sizes.name sizeid ";
		$join="left join pos_confirmedorders on pos_confirmedorderdetails.confirmedorderid = pos_confirmedorders.id left join pos_items on pos_confirmedorderdetails.itemid=pos_items.id left join pos_sizes on pos_sizes.id=pos_confirmedorderdetails.sizeid";
		$having="";
		$orderby=" ";
		$where="where pos_confirmedorders.orderno='$doc'";
		$confirmedorderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $confirmedorderdetails->sql;//echo mysql_error();
		$res=$confirmedorderdetails->result;
		while($row=mysql_fetch_object($res)){
		$qty = $row->quantity;
		$pack =$row->packrate ;
		$boxes= ($qty*$pack);
		
		$stotal+=$qty;
		$btotal+=$boxes;
		
		
		
	?>
	    <tr>
		  <td align="center"><?php echo ($i+1); ?></td>
		  <td><?php echo $row->name; ?></td>
		  <td><?php echo $row->sizeid; ?></td>
		  <td><?php echo $row->packrate; ?></td>
		   <td><?php echo $row->quantity; ?></td>
		  <td><?php echo $boxes; ?></td>
		 
		  <td><?php echo $row->memo; ?></td>
	    </tr>		
	<?
	$i++;
	}
	?>
	
	<tr>
	<td colspan="4"><strong>Total:</strong></td>
	
	<td><?php echo $stotal; ?></td>
	<td><?php echo $btotal; ?></td>
	</tr>
	
 <!--<tr height="80" style="font-weight:bold;">
  <td>Authorized By: __________________________________</td>
  </tr>
  <tr height="80" style="font-weight:bold;">
  <td>Date:  ______________________________________________</td>
  
  </tr>-->
  </table>




<!-- bodyend -->

<!-- foooter -->


<!-- footerend -->
<script type="text/javascript" language="javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.tablePagination.0.2.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery_003.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.easing.min.js"></script>


</body>
</html>
