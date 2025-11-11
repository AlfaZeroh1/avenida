<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../pos/orders/Orders_class.php");
require_once("../../auth/rules/Rules_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../../pos/orderdetails/Orderdetails_class.php");
require_once("../../pos/orders/Orders_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../crm/customerconsignees/Customerconsignees_class.php");
require_once("../../inv/categorys/Categorys_class.php");
require_once("../../sys/branches/Branches_class.php");

//connect to db
$db=new DB();
$obj=(object)$_GET;

$title="WAITER CLEARANCE";

$query = "select  pos_shifts.name shiftname, pos_shifts.id shiftid, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeename, pos_teamdetails.employeeid, sum(pos_teamdetailclearances.submitted) submitted from pos_teamdetailclearances left join pos_teamdetails on pos_teamdetails.id=pos_teamdetailclearances.teamdetailid left join pos_teams on pos_teamdetails.teamid=pos_teams.id left join pos_shifts on pos_shifts.id=pos_teams.shiftid left join hrm_employees on hrm_employees.id=pos_teamdetails.employeeid where pos_teamdetails.id='$obj->itemdetailid'";
$res = mysql_query($query);
$clearance = mysql_fetch_object($res);

//get employee and location
$query="select * from sys_branches where id='$obj->brancheid'";
$rw = mysql_fetch_object(mysql_query($query));
$clearance->branchename=$rw->name;

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
		jsPrintSetup.setSilentPrint(true);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{
		
			if(printers[i].indexOf('<?php echo $rw->printer2name; ?>')>-1)
			{	//alert('<?php echo $orders->printer;?>===='+printers[i]);
				bool=false;
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
		jsPrintSetup.print();
		
// 		window.close();
		
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
      <div style="text-align:center;text-transform:uppercase; font-size:20px;"><strong><?php echo $_SESSION['companyname']; ?></strong></div>
       <div style="text-align:center;text-transform:uppercase; font-size:12px;"><strong><?php echo $_SESSION['companytel']; ?></strong></div>
       <div style="text-align:center;text-transform:uppercase; font-size:12px;">PIN: <strong><?php echo $_SESSION['companypin']; ?></strong></div>
       <div style="text-align:center;text-transform:uppercase; font-size:12px;"><strong> <img src="../../../images/barcode.png" width="120" height="40"/></strong></div>
      
      <div id="ordertitle" style="text-align:center;text-transform:uppercase; font-size:20px;"><strong><?php echo $title; ?></strong></div>
    </div>
  </td>
</tr>

<tr>
  <td align="left">WAITER:&nbsp;<?php echo strtoupper($clearance->employeename); ?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td align="left">LOCATION:&nbsp;<?php echo strtoupper($clearance->branchename);?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td align="left">SHIFT:&nbsp;<?php echo strtoupper($clearance->shiftname);?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td align="left">Time:&nbsp;<?php echo date("d M Y H:i:s");?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td colspan='2'>
    <table class="table">
      <thead>
	<tr>
	  <th>ITEM</th>
	  <th>&nbsp;</th>
	  <th>Qty</th>
	  <th style="text-align:right;">Price</th>
	  <th style="text-align:right;">Total</th>
	</tr>
      </thead>
      <tbody>
      <?php
      $orderdetails = new Orderdetails();
      $fields="sum(pos_orderdetails.quantity) quantity, inv_items.name itemname, pos_orderdetails.price, sum(pos_orderdetails.quantity*pos_orderdetails.price) total, inv_items.warmth war, case when inv_items.warmth=1 then case when pos_orderdetails.warmth=1 then 'Warm' else 'Cold' end else '' end warm";
      $join=" left join inv_items on pos_orderdetails.itemid=inv_items.id left join auth_users on auth_users.id=pos_orderdetails.createdby left join pos_orders on pos_orders.id=pos_orderdetails.orderid ";
      $having="";
      $groupby=" group by pos_orderdetails.itemid, price, pos_orderdetails.warmth ";
      $orderby=" ";
      $where=" where auth_users.employeeid='$clearance->employeeid' and pos_orders.brancheid2='$obj->brancheid' and pos_orders.shiftid in($obj->teamid)  ";
      $orderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      $total=0;
      while($row=mysql_fetch_object($orderdetails->result)){
      $total+=($row->price*$row->quantity);
      
      if($ob->type==1){
      ?>
	<tr style='border-bottom:1px solid gray;'>
	  <td style='border-bottom:1px solid #ddd;'><?php echo $row->itemname; ?></td>
	  <td style='border-bottom:1px solid #ddd;'><?php echo $row->warm; ?></td>
	  <td style='border-bottom:1px solid #ddd;'><?php echo $row->quantity; ?>X</td>
	  <td style='border-bottom:1px solid #ddd;' align='right'><?php echo formatNumber($row->price); ?>=</td>
	  <td style='border-bottom:1px solid #ddd;border-right:1px solid #ddd;' align='right'><?php echo formatNumber($row->price*$row->quantity); ?></td>
	</tr>
      <?
      }
      }
      
      
      
      $query="select sum(pos_teamdetailclearances.submitted) submitted from pos_teamdetailclearances left join pos_teamdetails on pos_teamdetails.id=pos_teamdetailclearances.teamdetailid where pos_teamdetailclearances.brancheid='$obj->brancheid' and pos_teamdetails.employeeid='$clearance->employeeid' and pos_teamdetails.teamid='$obj->teamid' ";
      $cld = mysql_fetch_object(mysql_query($query));
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
           <?php
	  $query="select sys_paymentmodes.name paymentmodeid, fn_banks.name bankid, fn_imprestaccounts.name imprestaccountid, sum(pos_teampayments.amount) amount, pos_teampayments.remarks from pos_teampayments left join sys_paymentmodes on pos_teampayments.paymentmodeid=sys_paymentmodes.id left join fn_banks on fn_banks.id=pos_teampayments.bankid left join fn_imprestaccounts on fn_imprestaccounts.id=pos_teampayments.imprestaccountid where pos_teampayments.teamdetailid='$obj->itemdetailid' and pos_teampayments.brancheid='$obj->brancheid' group by sys_paymentmodes.id, fn_imprestaccounts.id ";
	  $rs=mysql_query($query);
	  $totals=0;
	  while($row=mysql_fetch_object($rs)){
	  
	  $totals+=$row->amount;
	  ?>
           <tr>
	      <th style='text-align:right;'><?php echo $row->paymentmodeid; ?></th>
	      <th style='text-align:right;'><?php echo formatNumber($row->amount); ?></th>
           </tr>
           <?php
           }
           ?>
           <tr>
	      <th style='text-align:right;'>SHORT</th>
	      <th style='text-align:right;'><?php echo formatNumber($total-$totals); ?></th>
           </tr>
           <tr>            
            <th style='text-align:center;' colspan='2'><strong><?php echo $_SESSION['receiptfootnote'];?></strong></th>	  
	   </tr>
	</thead>
    </table>
  </td>
</tr>

<tr>
  <td colspan='2'>
    <table width="50%" align='center'>
       <thead>
           <tr>            
            <th align='center' style='text-align:center;'><strong><?php echo $_SESSION['billfootnote'];?></strong></th>	  
	   </tr>
	</thead>
    </table>
  </td>
</tr>
