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

//$tenant = $_GET['tenant'];
$doc=$_GET['doc'];
$packingno=$_GET['packingno'];
$invoicedon=$_GET['invoicedon'];
$shippedon=$_GET['shippedon'];
$customerid = $_GET['customerid'];
$id=$_GET['id'];

$customers = new Customers();
$fields="crm_customers.name, crm_customers.address, crm_customers.code, crm_agents.name agentid, crm_agents.address agentaddress, sys_currencys.name currencyid, sys_currencys.id currency";
$where=" where crm_customers.id='$customerid'";	
$join=" left join crm_agents on crm_agents.id=crm_customers.agentid left join sys_currencys on sys_currencys.id=crm_customers.currencyid ";
$having="";
$groupby="";
$orderby="";
$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$customers = $customers->fetchObject;

$invoices = new Invoices();
$fields="pos_invoicedetails.boxno, count(*) boxes, pos_invoicedetails.vat, pos_invoicedetails.vatable, crm_customerconsignees.name customerconsigneeid";
$join=" left join pos_invoicedetails on pos_invoicedetails.invoiceid=pos_invoices.id";
$where=" where pos_invoices.documentno='$doc'";
$having="";
$groupby=" group by boxno ";
$orderby="";
$invoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$inv = $invoices->fetchObject;

$invoices = new Invoices();
$fields="sum(quantity) quantity, shippedon, packingno, invoiceno,actualweight,volweight,awbno,dropoffpoint, consignee";
$join=" left join pos_invoicedetails on pos_invoicedetails.invoiceid=pos_invoices.id";
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




</tr>
<tr>

<td width="50%" colspan="3">
<h4>Shipped To:</h4>
		      <div style="font-size:12px !important;font-family:'arial narrow';"><strong> </strong><?php echo strtoupper($invs->customerconsigneeid); ?><br/><?php echo $customers->agentaddress; ?></div>
		     <!-- <div style="font-size:10px !important;"><strong>Invoice No: </strong> <?php echo $doc; ?></div>-->
</td>
<td width="50%" colspan="4">
<h4>Sold To:</h4>
<div style="font-size:12px !important;"><strong>Client Name: </strong><?php echo strtoupper($customers->name); ?><br><?php echo $customers->address; ?></div>
             <div style="font-size:12px !important;"><strong>Invoice Date:</strong> <?php echo formatDate($invoicedon);?></div>
            
</td>
</tr>
<tr>

<td width="50%" colspan="7">
	<div style="font-size:12px !important;"><strong>Invoice No: </strong> <?php echo $customers->code; ?><?php echo $invs->invoiceno; ?></div>
	<div style="font-size:12px !important;"><strong>Shipping No: </strong> <?php echo $doc; ?></div>
	<div style="font-size:12px !important;"><strong>Delivery No: </strong><?php echo $invs->packingno; ?></div>
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
		$where="where pos_invoices.documentno='$doc'";
		$invoicess->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$invoicess->result;
		
		
		$pack=array();
		$j=0;
		
		while($row=mysql_fetch_object($res)){
		  
		  //echo " DOCUMENT NO ".$row->id."<br/>";
		  
		  $invoicedetails = new Invoicedetails();
		  $fields=" distinct pos_invoicedetails.itemid, pos_invoicedetails.sizeid, sum(pos_invoicedetails.quantity) quantity, pos_items.name itemname, pos_sizes.name sizename, pos_categorys.name categoryid ";
		  $join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid left join pos_sizes on pos_sizes.id=pos_invoicedetails.sizeid left join pos_categorys on pos_categorys.id=pos_items.categoryid";
		  $having="";
		  $groupby=" group by itemid, sizeid ";
		  $where="where boxno='$row->boxno' and invoiceid='$row->id'";
		  $invoicedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
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
		    $fields=" distinct pos_invoicedetails.itemid, pos_invoicedetails.sizeid, pos_invoicedetails.price, pos_invoicedetails.exportprice, sum(pos_invoicedetails.quantity) quantity, pos_items.name itemname, pos_sizes.name sizename, pos_categorys.name categoryid ";
		    $join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid left join pos_sizes on pos_sizes.id=pos_invoicedetails.sizeid left join pos_categorys on pos_categorys.id=pos_items.categoryid";
		    $having="";
		    $groupby=" group by itemid, sizeid ";
		    $orderby=" ";
		    $where="where boxno='$row->boxno' and invoiceid='$row->id'";
		    $invoicedetailss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    $i=0;
		    while($rw=mysql_fetch_object($invoicedetailss->result)){
		      $pack[$j][$i]['itemid']=$rw->itemid;
		    $testname =  $pack[$j][$i]['itemname']=$rw->itemname;
		      $sizee =  $pack[$j][$i]['sizeid']=$rw->sizeid;
// 		      $pack[$j][$i]['sizename']=;
		     $testy =   $pack[$j][$i]['categoryname']=$rw->categoryid;
		      $pack[$j][$i]['quantity']=$rw->quantity;
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
		while($i<count($pack)){
		  $s=0;
		  $k=0;
		  $st=0;
		  while($k<count($pack[$i])){
		    $st+=$pack[$i][$k]['quantity'];
		    $k++;
		  }
		  $tbox+=$pack[$i]['boxes'];
		  ?>
		  <tr><td colspan="9"><hr></td></tr>
	    <tr>
		  <td align="left"><?php echo strtoupper($pack[$i][0]['categoryname']); ?></td>
		  <td align="left"><?php echo strtoupper($pack[$i][0]['itemname']); ?></td>		  
		  <td align="left"><?php echo strtoupper($pack[$i][0]['sizename']); ?></td>	
		  <td align="center" valign='bottom' rowspan="<?php echo count($pack[$i]);?>"><?php echo $pack[$i]['boxes']; ?></td>
		  <td align="center" valign='bottom' rowspan="<?php echo count($pack[$i]);?>"><?php echo ($st*$pack[$i]['boxes']); ?></td>		  		  
		  <td align="left"><?php echo formatNumber($pack[$i][0]['price']); ?></td>
		  <?php if($inv->vatable=="Yes"){?>
		  <td align="left"><?php echo formatNumber($pack[$i][0]['vat']); ?></td>
		  <?php }?>
		  <td align="right"><?php echo formatNumber($pack[$i][0]['price']*$pack[$i][0]['quantity']*(100+$pack[$i][0]['vat'])/100); ?></td>
	</tr>
	<tr>
	<?php
		  $stems=0;
		  $stems+=$pack[$i][0]['quantity'];
		  $s=1;
		  $total+=$pack[$i][0]['price']*$pack[$i][0]['quantity'];
		  $totalvat+=$pack[$i][0]['price']*$pack[$i][0]['quantity']*$pack[$i][0]['vat']/100;
		  while($s<(count($pack[$i])-1)){
		    $stems+=$pack[$i][$s]['quantity'];
		    $total+=$pack[$i][$s]['price']*$pack[$i][$s]['quantity'];
		    $totalvat+=$pack[$i][$s]['price']*$pack[$i][$s]['quantity']*$pack[$i][$s]['vat']/100;
		  ?>
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
        <table class="table table-bordered">
<tr>
<table width="100%">
<tr>
<td>
<p>Exporter</p>
<p style="font-weight:bold;">MAGANA</p>
</td>
<td>
<p>FLO ID</p>
<p style="font-weight:bold;">3797</p>
</td>
<td>
<p>Country</p>
<p style="font-weight:bold;">KENYA</p>
</td>
</tr>
<tr>
<td>
<p>VARIETY</p>
<p style="font-weight:bold;"><?php echo strtoupper($testy); ?></p>
</td>
<td>
<p>COLOUR</p>
<p style="font-weight:bold;">KENYA</p>
</td>
<td>
<p>LENGTH</p>
<p style="font-weight:bold;"><?php echo $sizee;?></p>
</td>

</tr>
<tr>
<td>
<p>DATE</p>
<p style="font-weight:bold;"><?php echo formatDate($invoicedon);?></p>
</td>
<td>
<p>PACKER</p>
<p style="font-weight:bold;">KENYA</p>
</td>
<td>
<p>WEIGHT</p>
<p style="font-weight:bold;"><?php echo ($invs->actualweight/$invs->volweight); ?></p>
</td>

</tr>

<tr>
<td>
<p>TOTAL STEMS</p>
<p style="font-weight:bold;"><?php echo $invs->quantity; ?></p>
</td>
<td>
<p>TOTAL BUNCHES</p>
<p style="font-weight:bold;">KENYA</p>
</td>
<td>
<p>BUNCHING</p>
<p style="font-weight:bold;">KENYA</p>
</td>

</tr>

</table>
        
        
        <tr><td colspan="7"><hr></td></tr>
        <tr>        
	  <td align="right"><strong>Total</strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;<!--</td><?php $s=$tbox; ?>-->
	  <td align="center"><strong><?php echo $tbox; ?></strong></td>
	  <td align="center"><strong><?php echo $stotal; ?></strong></td>
	  <td>&nbsp;</td>
	  
        </tr>
  </table>
<!-- bodyend -->

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
