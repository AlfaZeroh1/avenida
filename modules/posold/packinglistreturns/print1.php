<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once("../../crm/customers/Customers_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../assets/fleets/Fleets_class.php");
require_once("../packinglistdetails/Packinglistdetails_class.php");
require_once("../../pos/packinglists/Packinglists_class.php");
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
	

$packinglists = new Packinglists();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where documentno='$doc'";
$packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $customers->sql;
$packinglists=$packinglists->fetchObject;

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

<style media="all" type="text/css">
body{font-family:'arial';font-size:10px;}
ul{list-style:none !important;}
.table-bordered {
border: 1px solid #ddd;
border-collapse: separate;
/*border-left: 1px;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;*/
}
hr {
display: block;
-webkit-margin-before: 0.2em;
-webkit-margin-after: 0.2em;
-webkit-margin-start: auto;
-webkit-margin-end: auto;
border-style: inset;
border-width: 1px;
}
table{width:100%;overflow-y:visible; overflow-x:hidden;margin:0px;padding:0px;}
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
            <div><span class="desc"><?php echo $_SESSION['companydesc']; ?></span>
            <span><?php echo $_SESSION['companActual/V.weight Ratioyaddr']; ?>,<?php echo $_SESSION['companytown']; ?></span><br />
            <span><strong>Tel:</strong> <?php echo $_SESSION['companytel']; ?> </span>  <br/>
            <strong>Website:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyweb']; ?></span> &nbsp;&nbsp;
            <strong>Email:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyemail']; ?></span><br />
<p><span class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <span class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span></p>
</td>
</tr>
<tr>
<td colspan="7" align="center" style="text-align:center;">
<strong>
         <h2> PACKING LIST / DELIVERY NOTE
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
<tr><td>SHIPPED TO:</td></tr>

<tr>
	
<td width="50%" colspan="3">
<div style="font-size:11px !important;">CUSTOMER:&nbsp;<strong><?php echo initialCap($customers->name); ?></strong></div>
<div style="font-size:11px !important;">LOCATION:&nbsp;<strong><?php echo $customers->address; ?></strong></div>
<div style="font-size:11px !important;">TEL:&nbsp;<strong><?php echo $customers->tel; ?></strong></div>
<div style="font-size:11px !important;">FAX:&nbsp;<strong><?php echo $customers->fax; ?></strong></div>
</td>

<td width="50%" colspan="4">
<div style="font-size:11px !important;">DATE: &nbsp;<strong><?php echo $packedon; ?></strong></div>
<div style="font-size:11px !important;">DELIVERY NO: &nbsp;<strong> <?php echo $doc; ?></strong></div>
<div style="font-size:11px !important;">SHIPMENT NO: &nbsp;<strong><?php echo $_SESSION['username']; ?></strong></div>
<div style="font-size:11px !important;">DRIVER NAME:&nbsp;<strong> </strong></div>
<div style="font-size:11px !important;">VEHICLE REG: &nbsp;<strong> </strong></div>            
</td>
</tr>





</table>
<table width="100%" class="">
<tr><td colspan="8"><hr></td></tr>
   	<tr>
			      <th>#</th>
			      <th>TYPE</th>
			      <th>VARIERTY</th>
			      <th>LENGTH</span></th>
			      <th>BOXES</th>
			     
			      <th>PACK RATE</th>
			       <th>STEMS</th>
			      <th>MEMO</span></th>
	</tr>
	
	<?php
		$i=0;
		$stotal=0;
		$btotal=0;
		$packinglistdetails = New Packinglistdetails();
		$fields=" pos_packinglistdetails.itemid, count(pos_packinglists.boxno) boxno,pos_packinglistdetails.memo,pos_sizes.name sizeid,sum(pos_packinglistdetails.quantity) quantity,pos_packinglists.id,pos_items.name,pos_categorys.name category ";
		$join="left join pos_packinglists on pos_packinglistdetails.packinglistid = pos_packinglists.id left join pos_items on pos_packinglistdetails.itemid=pos_items.id left join pos_sizes on pos_sizes.id=pos_packinglistdetails.sizeid left join pos_categorys on pos_items.categoryid=pos_categorys.id";
		$having="";
		$groupby=" group by pos_packinglistdetails.itemid, pos_packinglists.boxno, pos_packinglistdetails.sizeid";
		$orderby=" ";
		$where="where pos_packinglists.documentno='$doc'";
		$packinglistdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $packinglistdetails->sql;
		$res=$packinglistdetails->result;
		while($row=mysql_fetch_object($res)){
		
		$stems=($row->quantity)*($row->boxno);
		$stotal=+($row->quantity);
		$btotal=+($row->boxno);
		
	?>
	<tr><td colspan="8"><hr></td></tr>
	    <tr>
		  <td align="center"><?php echo ($i+1); ?></td>
		  <td align="center"><?php echo $row->category; ?></td>
		  <td align="center"><?php echo $row->name; ?></td>
		  <td align="center"><?php echo $row->sizeid; ?></td>
		  <td align="center"><?php echo $row->boxno; ?></td>
		  <td align="center"><?php echo $row->quantity; ?></td>
		  <td align="center"><?php echo $stems; ?></td>
		  <td align="center"><?php echo $row->memo; ?></td>
	    </tr>	
	    <tr><td colspan="8"><hr></td></tr>
	<?
	$i++;
	}
	?>
	<tr>
	<td colspan="4" align="left">TOTAL</td>
		  <td colspan="1" align="center"><?php echo $btotal; ?></td>
		  <td colspan="2" align="right"><?php echo $stotal; ?></td>
	    </tr>
	
	
 <tr height="80" style="font-weight:bold;">
  <td>Farm Incharge: __________________________________</td>  <td>Date:  ______________________________________________</td>
  </tr>
  <tr height="80" style="font-weight:bold;">
  
  <td>Security Magana: __________________________________</td>  <td>Date:  ______________________________________________</td>
  </tr>
    <tr height="80" style="font-weight:bold;">
  
  <td>Airport Official: __________________________________</td>  <td>Date:  ______________________________________________</td>
  </tr>
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
