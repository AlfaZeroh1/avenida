<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Orders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../orderdetails/Orderdetails_class.php");
require_once("../../pos/orders/Orders_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../crm/customerconsignees/Customerconsignees_class.php");
require_once("../../inv/categorys/Categorys_class.php");
require_once("../../sys/branches/Branches_class.php");

//connect to db
$db=new DB();
$obj=(object)$_GET;

$title="";

if($obj->copys==1){
  $title="ORDER";
}elseif($obj->copys==2){
  $title="CUSTOMER COPY";
}elseif($obj->copys==3){
  $title="CAPTAIN ORDER";
}

$title="IGNORE THIS!!!!";

if($ob->reprint==1)
  $title.=" -- copy";

$pop=1;
// include "../../../head.php";


if($obj->combined){
  $i=0;
  $ordernos="";
  $shop = $_SESSION['shpordernos'];
  while($i<count($shop)){
    $ordernos.=$shop[$i].",";
    $i++;
  }
}

$ordernos=substr($ordernos,0,-1);

$orders = new Orders();
$fields="pos_orders.*, sys_branchess.name branchename, sys_branchess.printer, sys_branchess.printer2, group_concat(pos_orders.id) id, group_concat(pos_orders.orderno) orderno, sys_branchess.printer2name ";
$join=" left join sys_branches on sys_branches.id=pos_orders.brancheid left join sys_branches sys_branchess on sys_branchess.id=pos_orders.brancheid2 ";
$having="";
$groupby=" ";
$orderby=" ";
if(empty($obj->combined))
  $where=" where orderno='$obj->doc' ";
else
  $where=" where orderno in($ordernos) ";
$orders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$orders = $orders->fetchObject;

if($obj->copys==1){
  
  
  $orders->printer = str_replace("\\","\\\\",$orders->printer2);
  
  
}
else
  $orders->printer = str_replace("\\","\\\\",$orders->printer);
  
$query="select concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeename from hrm_employees left join auth_users on hrm_employees.id=auth_users.employeeid where auth_users.id='$orders->createdby'";
$employee = mysql_fetch_object(mysql_query($query));

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
  		var printerss = jsPrintSetup.getPrintersList().split(',');
		// Suppress print dialog
		jsPrintSetup.setSilentPrint(true);/** Set silent printing */

		var bool = true;
		var i;
		for(i=0; i<printers.length;i++)
		{
			printers[i]=printers[i].toLowerCase();
			if(printers[i].indexOf('<?php echo strtolower($orders->printer); ?>')>-1)
			{	//alert('>><?php echo strtolower($orders->printer); ?>===='+printers[i].toLowerCase());
				bool=false;
				jsPrintSetup.setPrinter(printers[i]);
			}			
		}
		//alert(bool);
		if(bool){
		  var j;
		  for(j=0; j<printerss.length;j++)
		  {
		  
			  if(printerss[j].indexOf('<?php echo $orders->printer2name; ?>')>-1)
			  {	//alert('<?php echo $orders->printer2name;?>===='+printerss[j]);
				  bool=false;
				  jsPrintSetup.setPrinter(printerss[j]);
			  }			
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
		try{
		if(jsPrintSetup.print()){
		  alert("PRINT");
		}
		else
		  alert("NO PRINT");
		}catch(e){alert(e);}
// 		window.opener.setHidden('<?php echo $obj->copys; ?>');
		
		window.close();
		
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
  <td align="left">Served By:&nbsp;<?php echo strtoupper($employee->employeename); ?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td align="left">Table No:&nbsp;<?php echo $orders->tableno;?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td align="left">Location:&nbsp;<?php echo $orders->branchename;?></td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td align="left">ORDER No:&nbsp;<?php echo $orders->orderno;?></td>
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
      $join=" left join inv_items on pos_orderdetails.itemid=inv_items.id ";
      $having="";
      $groupby=" group by itemid, price, pos_orderdetails.warmth ";
      $orderby=" ";
      $where=" where orderid in($orders->id) ";
      $orderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      $total=0;
      while($row=mysql_fetch_object($orderdetails->result)){
      $total+=($row->price*$row->quantity);
      
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
      ?>
      </tbody>
      
      <tfoot>
	<tr>
	  <th>&nbsp;</th>
	  <th>&nbsp;</th>
	  <th>&nbsp;</th>
	  <th align='right' style="border-right:1px solid #ddd;"><?php echo formatNumber($total); ?></th>
	</tr>
      </tfoot>
       
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