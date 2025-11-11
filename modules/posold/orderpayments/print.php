<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../orderdetails/Orderdetails_class.php");
require_once("../../pos/orders/Orders_class.php");
require_once("../../pos/orderpayments/Orderpayments_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../crm/customerconsignees/Customerconsignees_class.php");
require_once("../../inv/categorys/Categorys_class.php");
require_once("../../sys/branches/Branches_class.php");

//connect to db
$db=new DB();
$obj=(object)$_GET;

// $pop=1;
// include "../../../head.php";

$orderpayments = new Orderpayments();
$fields="*";
$join=" ";
$having="";
$groupby=" ";
$orderby=" ";
$where=" where documentno='$obj->doc' ";
$orderpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $orderpayments->sql;
$orderpayments = $orderpayments->fetchObject;

$orders = new Orders();
$fields="pos_orders.*, sys_branches.name branchename";
$join=" left join sys_branches on sys_branches.id=pos_orders.brancheid ";
$having="";
$groupby=" ";
$orderby=" ";
$where=" where pos_orders.billno='$orderpayments->billno' ";
$orders->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $orders->sql;
$orders = $orders->fetchObject;

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">

    <title></title>
    
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
		jsPrintSetup.setOption('marginLeft','0');
		jsPrintSetup.setOption('marginRight','0');
		jsPrintSetup.setOption('marginTop','-2');
		jsPrintSetup.setOption('marginBottom','0');
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
	
	<style type="text/css" media="all">
	body{font-family:'sans-serif';font-size:12px;}
	
	table {border:0px solid;width:100%;margin:1px;padding:0px;border-spacing:0px}
	
table thead th {
text-align: left;
vertical-align: bottom;
border-right: 1px solid #ddd;
border-bottom: 1px solid #ddd;
border-top: 1px solid #ddd;
padding:8px;
line-height:none !important;
font-family:'sans-serif';font-size:12px;
}

	
	/*td{border:1px solid #ccc;}
	tr{border:1px solid;}*/
	
	</style>
  </head>
 <body onload="print_doc();">
<table align="center" width="98%" class="table">
<tr>
  <td colspan='2'>
    <div align="center" style="font-weight:bold;page-break-inside:avoid; page-break-after:avoid; page-break-before:avoid; display:block;">
      <div style="text-align:center;text-transform:uppercase; font-size:12px;"><strong><?php echo $_SESSION['companyname']; ?></strong></div>
       <div style="text-align:center;text-transform:uppercase; font-size:12px;"><strong><?php echo $_SESSION['companytel']; ?></strong></div>
       <div style="text-align:center;text-transform:uppercase; font-size:12px;"><strong><?php echo $_SESSION['companypin']; ?></strong></div>
       <div><strong> <img src="../../../images/barcode.png" width="120" height="40"/></strong></div>

      
      <div style="text-align:center;text-transform:uppercase; font-size:12px;"><strong>CUSTOMER COPY</strong></div>
    </div>
  </td>
</tr>

<tr>
  <td align="left">Served By:&nbsp;<?php echo strtoupper($_SESSION['username']);?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td align="left">Table No:&nbsp;<?php echo $orders->tableno;?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td align="left">Location:&nbsp;<?php echo strtoupper($orders->branchename);?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td align="left">ORDER No:&nbsp;<?php echo $orders->orderno;?></td>
  <td align="left">RECEIPT No:&nbsp;<?php echo $orderpayments->documentno;?></td>
</tr>

<tr>
  <td align="left">Time:&nbsp;<?php echo date("d/m/Y H:i:s");?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td colspan='2'>
       <table width="100%">
      <thead>
	<tr>
	  <th>ITEM</th>
	  <th>Qty</th>
	  <th>Price</th>
	  <th>Total</th>
	</tr>
      </thead>
      <tbody>
      <?php
      $orderdetails = new Orderdetails();
      $fields="sum(pos_orderdetails.quantity) quantity, inv_items.name itemname, pos_orderdetails.price, sum(pos_orderdetails.quantity*pos_orderdetails.price) total";
      $join=" left join inv_items on pos_orderdetails.itemid=inv_items.id left join pos_orders on pos_orders.id=pos_orderdetails.orderid ";
      $having="";
      $groupby=" group by pos_orderdetails.itemid, pos_orderdetails.price ";
      $orderby=" ";
      $where=" where pos_orders.billno='$orderpayments->billno' ";
      $orderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $orderdetails->sql;
      $total=0;
      while($row=mysql_fetch_object($orderdetails->result)){
      $total+=($row->price*$row->quantity);
      ?>
	<tr style='border-bottom:1px solid gray;'>
	  <td style='border-bottom:1px solid #ddd;'><?php echo $row->itemname; ?></td>
	  <td style='border-bottom:1px solid #ddd;' align='center'><?php echo $row->quantity; ?>X</td>
	  <td style='border-bottom:1px solid #ddd;' align='right'><?php echo formatNumber($row->price); ?>=</td>
	  <td style='border-bottom:1px solid #ddd;border-right:1px solid #ddd;' align='right'><?php echo formatNumber($row->price*$row->quantity); ?></td>
	</tr>
      <?
      }
      ?>
      </tbody>
      
      
    </table>
  </td>

</tr>
<tr>
  <td colspan='2'>
    <table width="50%" align='center'>
       <thead>
           <tr>
	      <th style='text-align:right;border-top:0px solid #ddd;'>TOTAL</th>
	      <th style='text-align:right;border-top:0px solid #ddd;'><?php echo formatNumber($total); ?></th>
           </tr>
           <tr>
	      <th style='text-align:right;'>CASH</th>
	      <th style='text-align:right;'><?php echo formatNumber($orderpayments->amountgiven); ?></th>
           </tr>
           <tr>
	      <th style='text-align:right;'>CHANGE</th>
	      <th style='text-align:right;'><?php echo formatNumber($orderpayments->amountgiven-$total); ?></th>
           </tr>
           <tr>            
            <th style='text-align:center;' colspan='2'><strong><?php echo $_SESSION['receiptfootnote'];?></strong></th>	  
	   </tr>
	</thead>
    </table>
  </td>
</tr>