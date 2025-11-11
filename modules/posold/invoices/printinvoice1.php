<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once("../../crm/customers/Customers_class.php");
require_once("../../crm/agents/Agents_class.php");
require_once("../invoicedetails/Invoicedetails_class.php");
require_once("../../pos/invoices/Invoices_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../pos/config/Config_class.php");
require_once("../../pos/configaccounts/Configaccounts_class.php");
require_once("../../pos/packinglists/Packinglists_class.php");
require_once("../../pos/invoiceconsumables/Invoiceconsumables_class.php");

//$tenant = $_GET['tenant'];
$doc=$_GET['doc'];
$packingno=$_GET['packingno'];
$invoicedon=$_GET['invoicedon'];
$shippedon=$_GET['shippedon'];
$customerid = $_GET['customerid'];
$id=$_GET['id'];

$ob = (object)$_GET;

$customers = new Customers();
$fields="crm_customers.name, crm_customers.address, case when crm_customers.customerid is not null then customers.name else crm_customers.name end parent, case when crm_customers.customerid is not null then customers.address else crm_customers.address end parentaddress, crm_customers.code,pos_freights.name freightid, crm_agents.name agentid, crm_agents.address agentaddress, sys_currencys.name currencyid, sys_currencys.id currency";
$where=" where crm_customers.id='$customerid'";	
$join=" left join crm_agents on crm_agents.id=crm_customers.agentid left join sys_currencys on sys_currencys.id=crm_customers.currencyid left join pos_freights on pos_freights.id=crm_customers.freightid left join crm_customers customers on customers.id=crm_customers.customerid ";
$having="";
$groupby="";
$orderby="";
$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$customers = $customers->fetchObject;

$invoices = new Invoices();
$fields="pos_invoicedetails.boxno, count(*) boxes, pos_invoices.vat, pos_invoices.vatable, crm_customerconsignees.name customerconsigneeid";
$join=" left join pos_invoicedetails on pos_invoicedetails.invoiceid=pos_invoices.id left join crm_customers on crm_customers.id=pos_invoices.customerid left join crm_customerconsignees on crm_customerconsignees.customerid=crm_customers.id ";
//
if(!empty($ob->parent))
  $where=" where pos_invoices.customerid in(select id from crm_customers where customerid='$customerid' and soldon='$invoicedon')";
else
  $where=" where pos_invoices.documentno='$doc'";
$having="";
$groupby=" group by boxno ";
$orderby="";
$invoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$inv = $invoices->fetchObject;

$invoices = new Invoices();
$fields="pos_invoices.id, sum(quantity) quantity, remarks, shippedon, packingno, invoiceno,actualweight,volweight,awbno,dropoffpoint, consignee";
$join=" left join pos_invoicedetails on pos_invoicedetails.invoiceid=pos_invoices.id";
if(!empty($ob->parent))
  $where=" where pos_invoices.customerid in(select id from crm_customers where customerid='$customerid' and soldon='$invoicedon')";
else
  $where=" where pos_invoices.documentno='$doc'";
$having="";
$groupby=" ";
$orderby="";
$invoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$invs = $invoices->fetchObject;

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
		jsPrintSetup.setOption('marginTop','4.8');
		jsPrintSetup.setOption('marginBottom','0');
		jsPrintSetup.setOption('marginLeft','4');
		jsPrintSetup.setOption('marginRight','');
		
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
<!--    <link href="../../../css/bootstrap.css" rel="stylesheet"> -->
<!-- <link href="../../../css/bootstrap.min.css" rel="stylesheet"> -->
<style type="text/css" media="all">
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
</style>



</head>

<body onload="print_doc();">
<!--<div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div>-->
<!-- headder -->
<table class="table table-bordered">
<table width="100%">
<tr>
<td colspan="8">
<div style="text-align:center"> 
            <div style="text-align:center;text-transform:uppercase;"><strong><?php echo $_SESSION['companyname']; ?></strong>
            <div><span><?php echo $_SESSION['companydesc']; ?></span>
            <span><?php echo $_SESSION['companActual/V.weight Ratioyaddr']; ?>,<?php echo $_SESSION['companytown']; ?></span> <br />
            <span><strong>Tel:</strong> <?php echo $_SESSION['companytel']; ?> </span>  <br/>
            <strong>Website:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyweb']; ?></span>
            <strong>Email:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyemail']; ?></span><br />
<p><span class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <span class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span></p>
</td>
</tr>
<tr><td colspan="8"><hr></td></tr>
<tr>
<td colspan="7" align="center">
<strong>
<span style="text-align:center;">
       <h2>  <?php if($id==1){?>INVOICE<?php }else{ ?>EXPORT INVOICE<?php }?>
            <?php
            if($_GET['retrieved']==1){
				?>
				- Copy
				<?php 
			}
		?>
		</h2>
</span>	     
            </strong>   
      </span>
 </div>
</td>
</tr>
<tr><td colspan="8"><hr></td></tr>
<tr>

<td width="50%" colspan="3">
<h4>Shipped To:</h4>
		      <div style="font-size:12px !important;font-family:'arial narrow';"><strong> </strong><?php echo strtoupper($customers->name); ?><br><?php echo $customers->address; ?></div>
		     <!-- <div style="font-size:10px !important;"><strong>Invoice No: </strong> <?php echo $doc; ?></div>-->
</td>
<td width="50%" colspan="4">
<h4>Sold To:</h4>
<div style="font-size:12px !important;"><strong>Client Name: </strong><?php echo strtoupper($customers->parent); ?><br/><?php echo $customers->parentaddress; ?></div><br/>
             <div style="font-size:12px !important;"><strong>Invoice Date:</strong> <?php echo formatDate($invoicedon);?></div>
            
</td>
</tr>
<tr>

<td width="50%" colspan="7">
	<div style="font-size:12px !important;"><strong>Invoice No: </strong> <?php echo $customers->code; ?><?php echo $invs->invoiceno; ?></div>
	<div style="font-size:12px !important;"><strong>Shipping No: </strong> <?php echo $doc; ?></div>
	<div style="font-size:12px !important;"><strong>Delivery No: </strong><?php echo $invs->packingno; ?></div>
	<div style="font-size:12px !important;"><strong>PO Number: </strong><?php echo $invs->remarks; ?></div>
	<!--<div style="font-size:12px !important;"><strong>Magana Flowers FLO ID:</strong><?php echo "3797"; ?></div>-->
</td>

</tr>
<tr>

<td width="50%" colspan="4">
	<div style="font-size:12px !important;">Currency: <?php echo initialCap($customers->currencyid); ?></div>
<!-- 	<div style="font-size:12px !important;">No Of Boxes:<?php echo $inv->boxes; ?></div> -->
</td>
<td width="50%" colspan="3">
	  <div style="font-size:12px !important;">Date Shipped:  <?php echo formatDate($invs->shippedon); ?></div>
	<div style="font-size:12px !important;">No Of Stems:<?php echo $invs->quantity; ?></div>
            
</td>
</tr>

<tr>

<td width="30%" colspan="2">
      <div style="font-size:12px !important;">Actual Weight: <?php echo $invs->actualweight; ?></div>
</td>
<td width="30%" colspan="2">
    <div style="font-size:12px !important;">Volume weight: <?php echo $invs->volweight; ?></div>
</td>
<td width="40%" colspan="3">	
	<div style="font-size:12px !important;">Actual/V.weight Ratio: <?php echo ($invs->actualweight/$invs->volweight); ?></div>
	<div style="font-size:12px !important;">AWB No:  <?php echo $invs->awbno; ?></div>
	<div style="font-size:12px !important;">Drop Off Point:  <?php echo $invs->dropoffpoint; ?></div>
</td>

</tr>


<!-- headerend -->

<!-- bodyyy -->
<table width="100%" class="">
<tr><td colspan="8"><hr></td></tr>
   	<tr>
			      <th>TYPE</th>
			      <th>VARIETY</th>
			      <th>LENGTH</th>
			      <th>NO OF BOXES</th>
			      <th>TOTAL STEMS</th>
			      <th>PRICE</th>
			      <th>DISCOUNT(%)</th>
			      <?php if($inv->vatable=="Yes"){?>
			      <th>VAT(%)</th>
			      <?php }?>			       
			      <th><?php echo $customers->freightid; ?></th>
	</tr>
	<?php
	$i=0;
		$stotal=0;
		$btotal=0;
		$invoicess = new Invoices();
		$fields=" distinct pos_invoicedetails.boxno, pos_invoices.id ";
		$join="left join pos_invoicedetails on pos_invoicedetails.invoiceid=pos_invoices.id";
		$having="";
		$groupby=" ";
		$orderby=" ";
		if(!empty($ob->parent))
		  $where=" where pos_invoices.customerid in(select id from crm_customers where customerid='$customerid' and soldon='$invoicedon')";
		else
		  $where=" where pos_invoices.documentno='$doc'";
		$invoicess->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $invoicess->sql;
		$res=$invoicess->result;
		
		
		$pack=array();
		$j=0;
		
		while($row=mysql_fetch_object($res)){
		  
		  //echo " DOCUMENT NO ".$row->id."<br/>";
		  
		  $invoicedetails = new Invoicedetails();
		  $fields=" distinct(pos_invoicedetails.itemid) itemid, pos_invoicedetails.sizeid, sum(pos_invoicedetails.quantity) quantity, pos_invoicedetails.discount, pos_items.name itemname, pos_sizes.name sizename, pos_categorys.name categoryid ";
		  $join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid left join pos_sizes on pos_sizes.id=pos_invoicedetails.sizeid left join pos_categorys on pos_categorys.id=pos_items.categoryid ";
		  $having="";
		  $groupby=" group by itemid, sizeid ";
		  $where="where boxno='$row->boxno' and invoiceid='$row->id'";
		  $invoicedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo mysql_error()."<br/>";
		  $i=0;
		  $bool=false;
		  $check=0;
		  
		  $pac=array();
		  
		 // echo "</br><br/>"; print_r($packings);
		  while($rw=mysql_fetch_object($invoicedetails->result)){		    
		   // echo $rw->packinglistid."======".$rw->itemid." = ".$rw->sizeid." = ".$rw->quantity."<br/>";
		    $k=0;
		    $check=0;
		    $bool=false;		    
		    
		    $pac[$i]['itemid']=$rw->itemid;
		    $pac[$i]['itemname']=$rw->itemname;
		    $pac[$i]['sizeid']=$rw->sizeid;
		    $pac[$i]['sizename']=$rw->sizename;
		    $pac[$i]['categoryname']=$rw->categoryid;
		    $pac[$i]['quantity']=$rw->quantity;
		    $pac[$i]['discount']=$rw->discount;
		    
		    $i++;
		  }
		  //echo "<br/>PACK <br/>";
		//print_r($pac);
		  //$rw=mysql_fetch_array($packinglistdetails->result);
		  $pk = new Packinglists();
		  $check = $pk->checkArray($pac,$pack);//echo " THIS CHECK ".$check;
		  		
		  if($check=="NOT FOUND"){ //$check=$check-1;  
		  
		    //$packings[$i]['boxes']+=1;
		    $bool=false;
		  }
		  else{
		    $check = $check-1;
		    $bool=true;
		  }
		  
		  if($bool){
		    
		    //echo "<br/>".$check."TRUE<br/>";
		  }else{
		    //echo "<br/>".$check." HERE FALSE<BR/>";
		  }
		  
		  //if($bool){echo" TRUE ";}else{echo " FALSE ";}echo $row->id."<br/>";
		  //if bool is true it means the specific box details exist
		  if($bool){
		    $pack[$check]['boxes']+=1;
		    //break;
		  }
		  else{//echo "WE ARE HERE";
		    $invoicedetailss = new Invoicedetails();
		    $fields=" distinct(pos_invoicedetails.itemid) itemid, pos_invoicedetails.sizeid, pos_invoicedetails.discount, pos_invoicedetails.price, pos_invoicedetails.exportprice, sum(pos_invoicedetails.quantity) quantity, pos_items.name itemname, pos_sizes.name sizename, pos_categorys.name categoryid ";
		    $join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid left join pos_sizes on pos_sizes.id=pos_invoicedetails.sizeid left join pos_categorys on pos_categorys.id=pos_items.categoryid ";
		    $having="";
		    $groupby=" group by itemid, sizeid ";
		    $orderby=" ";
		    $where="where boxno='$row->boxno' and invoiceid='$row->id'";
		    $invoicedetailss->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $invoicedetailss->sql;
		    $i=0;
		    while($rw=mysql_fetch_object($invoicedetailss->result)){
		      $pack[$j][$i]['itemid']=$rw->itemid;
		      $pack[$j][$i]['itemname']=$rw->itemname;
		      $pack[$j][$i]['sizeid']=$rw->sizeid;
		      $pack[$j][$i]['sizename']=$rw->sizename;
		      $pack[$j][$i]['categoryname']=$rw->categoryid;
		      $pack[$j][$i]['quantity']=$rw->quantity;
		      $pack[$j][$i]['discount']=$rw->discount;
		      if($id==1)
			$pack[$j][$i]['price']=$rw->price;
		      else
			$pack[$j][$i]['price']=$rw->exportprice;
		      $pack[$j][$i]['vat']=$inv->vat;
		      $pack[$j][$i]['exportprice']=$rw->exportprice;
		      $pack[$j]['boxes']=1;
		      
		     // echo $packings[$row->id][$i]['itemid']."==".$rw->itemid." and ".$packings[$row->id][$i]['sizeid']."==".$rw->sizeid." and ".$packings[$row->id][$i]['quantity']."==".$rw->quantity."<br/>";
		      
		      $i++;
		    }		    
		    
		    $j++;
		  }
		 // echo "<br/>PACKINGS <br/>";
		//print_r($pack);
		  //else create a new box in the array
		}
		?>
        <?php
        $i=0;
		$stotal=0;
		$tbox=0;
		$total=0;
		$totalvat=0;
		$totaldisc=0;//print_r($pack);
		while($i<count($pack)){
		  $s=0;
		  $k=0;
		  $st=0;
		  while($k<count($pack[$i])){
		    $st+=$pack[$i][$k]['quantity'];
		    $k++;
		  }
		  $tbox+=$pack[$i]['boxes'];
		  $vat=$pack[$i][0]['price']*$pack[$i][0]['quantity']*$pack[$i]['boxes']*$pack[$i][0]['vat']/100;
		  $totalvat+=$vat;
		  
		  ?>
		  <tr><td colspan="9"><hr></td></tr>
	    <tr>
		  <td align="left"><?php echo strtoupper($pack[$i][0]['categoryname']); ?></td>
		  <td align="left"><?php echo strtoupper($pack[$i][0]['itemname']); ?></td>		  
		  <td align="left"><?php echo strtoupper($pack[$i][0]['sizename']); ?></td>	
		  <td align="center" valign='bottom' rowspan="<?php echo count($pack[$i]);?>"><?php echo $pack[$i]['boxes']; ?></td>
		  <td align="center" valign='bottom' rowspan="<?php echo count($pack[$i]);?>"><?php echo ($st*$pack[$i]['boxes']); ?></td>		  		  
		  <td align="center"><?php echo formatNumberto4($pack[$i][0]['price']); ?></td>
		  <td align="right"><?php echo $pack[$i][0]['discount']; ?></td>
		  <?php if($inv->vatable=="Yes"){?>
		  <td align="right"><?php echo $vat; ?></td>
		  <?php }?>
		  <td align="right"><?php echo formatNumberto4($pack[$i][0]['price']*$pack[$i][0]['quantity']*$pack[$i]['boxes']*((100+$pack[$i][0]['vat'])/100)*((100-$pack[$i][0]['discount'])/100)); ?></td>
	</tr>
	<tr>
	<?php
		  $stems=0;
		  $stems+=$pack[$i][0]['quantity'];
		  $s=1;
		  $total+=$pack[$i][0]['price']*$pack[$i][0]['quantity']*$pack[$i]['boxes']*((100-$pack[$i][0]['discount'])/100)*((100+$pack[$i][0]['vat'])/100);
		  $totaldisc+=$total*$pack[$i]['discount'];
		  
		  while($s<(count($pack[$i])-1)){
		    $stems+=$pack[$i][$s]['quantity'];
		    $total+=$pack[$i][$s]['price']*$pack[$i][$s]['quantity']*$pack[$i]['boxes']*((100-$pack[$i][$s]['discount'])/100)*((100+$pack[$i][$s]['vat'])/100);
		    $totaldisc+=$total*$pack[$i]['discount'];
		    $vat=$pack[$i][$s]['price']*$pack[$i][$s]['quantity']*$pack[$i]['boxes']*$pack[$i][$s]['vat']/100;
		    $totalvat+=$vat;
		  ?>
		  <tr>
		  <td align="left"><?php echo strtoupper($pack[$i][$s]['categoryname']); ?></td>
		  <td align="left"><?php echo strtoupper($pack[$i][$s]['itemname']); ?></td>		  
		  <td align="left"><?php echo strtoupper($pack[$i][$s]['sizename']); ?></td>	
		  <td align="center"><?php echo formatNumberto4($pack[$i][$s]['price']); ?></td>
		  <td align="right"><?php echo $pack[$i][$s]['discount']; ?></td>
		  <?php if($inv->vatable=="Yes"){?>
		  <td align="right"><?php echo $vat; ?></td>
		  <?php }?>
		  <td align="right"><?php echo formatNumberto4($pack[$i][$s]['price']*$pack[$i][$s]['quantity']*$pack[$i]['boxes']*((100+$pack[$i][$s]['vat'])/100)*((100-$pack[$i][$s]['discount'])/100)); ?></td>
		</tr>
<!--  	    <tr><td colspan="8"><hr></td></tr>  -->
	<?
	$s++;
	}
	$stotal+=$stems*$pack[$i]['boxes'];
	?>
	</tr>
	<?php
	$i++;
	}
        ?>
        <tr><td colspan="<?php if($inv->vatable=="Yes"){ echo "7";}else{echo "8";} ?>"><hr></td></tr>
        <tr>        
	  <td align="right"><strong>Total</strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;<!--</td><?php $s=$tbox; ?>-->
	  <td align="center"><strong><?php echo $tbox; ?></strong></td>
	  <td align="center"><strong><?php echo $stotal; ?></strong></td>
	  <td style="font-size:11px;" align="right">&nbsp;</td>
	  <td>&nbsp;</td>
	  <?php if($inv->vatable=="Yes"){?>
	  <td style="font-size:11px;" align="right"><strong><?php echo formatNumber($totalvat); ?></strong></td>
	  <?php }?>
	  <td style="font-size:11px;" align="right"><strong><?php echo formatNumber($total); ?> (<?php echo $customers->currencyid; ?>)</strong></td>
	  
        </tr>
  </table>
  
  
  <?php
  $tts=0;
  $invoiceconsumables = new Invoiceconsumables();
  $fields=" inv_items.name itemid, inv_unitofmeasures.name unitofmeasureid, pos_invoiceconsumables.quantity, pos_invoiceconsumables.price, pos_invoiceconsumables.total";
  $join=" left join inv_items on inv_items.id=pos_invoiceconsumables.itemid left join inv_unitofmeasures on inv_unitofmeasures.id=pos_invoiceconsumables.unitofmeasureid ";
  $where=" where pos_invoiceconsumables.invoiceid='$invs->id' ";
  $having="";
  $groupby=" ";
  $orderby="";
  $invoiceconsumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  if($invoiceconsumables->affectedRows>0){
    ?>
    <table width="100%">
    <tr><td colspan="5"><hr></td></tr>
    <tr>
	<td colspan="5" align="left"><h3>Non-Flower Items</h3></td>
    </tr>
    <tr>
      <th>ITEM</th>
      <th>UoM</th>
      <th>QTY</th>
      <th>RATE</th>
      <th>AMT</th>
    </tr>
    
   <tr><td colspan="5"><hr></td></tr>
    <?
  while($row=mysql_fetch_object($invoiceconsumables->result)){
  $tts+=$row->total;
   ?>
   <tr>
    <td><?php echo $row->itemid; ?></td>
    <td><?php echo $row->unitofmeasureid; ?></td>
    <td><?php echo $row->quantity; ?></td>
    <td><?php echo $row->price; ?></td>
    <td><?php echo $row->total; ?></td>
   </tr>
   <?php
  }
  ?>
  
   <tr><td colspan="5"><hr></td></tr>
  <tr>
    <td colspan="4">Non-Flower Items Total</td>
    <td><?php echo formatNumber($tts); ?></td>
  </tr>
  <tr>
    <td colspan="4">Total (Non-Flower + Flower Items)</td>
    <td><?php echo formatNumber ($tts+$total); ?></td>
  </tr>
   <tr><td colspan="5"><hr></td></tr>
  </table>
  
<!-- bodyend -->
<?php
}
$config = new Config();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" ";
$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);
while($configs=mysql_fetch_object($config->result)){
  if($configs->name=="TERMSANDCONDITIONS")
    $termsandconditions=$configs->value;
  if($configs->name=="DECLARATION"){
    $declaration=$configs->value;
  }
  if($configs->name=="PAYMENTTERMS"){
    $paymentterms=$configs->value;
  }
}

$configaccounts = new Configaccounts();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where currencyid='$customers->currency' ";
$configaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$configaccounts = $configaccounts->fetchObject;
?>
<!-- foooter -->
<table class="table table-codensed">
<tr>
<div style="font-size:10px !important;"><strong>Payment Details:</strong> All Payments are to be borne by: <?php echo strtoupper($customers->name); ?></div>
<div style="font-size:10px !important;"><strong>Payment Terms:<?php echo $paymentterms; ?>&nbsp;<?php echo $configaccounts->name; ?>&nbsp;<?php echo $configaccounts->accno; ?></div>
</tr>
<tr>

<div style="font-size:10px !important;text-align:center;"><?php echo $declaration; ?></div>
<div style="font-size:10px !important;">Signed:....................................</div>
<div style="font-size:10px !important;">Dated:.....................................</div>

</tr>
<tr>
<div style="font-size:10px !important;text-align:center;">
           <ul>
           <h6>TERMS AND CONDITIONS</h6>
           <li><?php echo $termsandconditions; ?></li>
           </ul>
           
</div>
         </tr>



</table>
<!-- footerend -->
<script type="text/javascript" language="javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.tablePagination.0.2.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery_003.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.easing.min.js"></script>
<script type="text/javascript" language="javascript">
$('tbody tr', $('#menuTable2')).addClass('hideTr'); //hiding rows for test
            var options = {
              currPage : 1, 
              ignoreRows : $('', $('#menuTable2')),
              optionsForRows : [2,3,4,5],
              firstArrow : (new Image()).src="../../media/inv-images/firstBlue.gif",
              prevArrow : (new Image()).src="../../media/inv-images/prevBlue.gif",
              lastArrow : (new Image()).src="../../media/inv-images/lastBlue.gif",
              nextArrow : (new Image()).src="../../media/inv-images/nextBlue.gif"
            }
            $('#menuTable2').tablePagination(options);
			$('a.review').toggle(function(){
				$('tbody tr', $('#menuTable2')).show();
				$('div#tablePagination').hide();
				subTotal();
				},function(){
				$('tbody tr', $('#menuTable2')).addClass('hideTr');
				$('div#tablePagination').show();
				 $('#menuTable2').tablePagination(options);
				 subTotal();
				}
			
			);

</script>
<script type="text/javascript" language="javascript">
function subTotal()
{	
	var subTot = 0;
			var subrow =$('#menuTable2 tr[style*=table-row]');
			subrow.children('td.t2').each(function() {
					subTot += parseFloat($(this).html().replace("$","")); 
				});
			$('#subTot').html(subTot);
}
$(document).ready(function(){
	subTotal(); 
	var fTot = 0;
			var nrow =$('#menuTable2 tr');
			nrow.children('td.t2').each(function() {
					fTot += parseFloat($(this).html().replace("$","")); 
				});
			$('#fTot').html(fTot);
	$('span#tablePagination_paginater img').click(function(){
		subTotal();
	});
	$('#tablePagination_currPage').change(function(){
		subTotal();
	});
	
});		
</script>
</body>
</html>
