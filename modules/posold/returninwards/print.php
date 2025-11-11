<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once("../../crm/customers/Customers_class.php");
require_once("../../crm/agents/Agents_class.php");
require_once("../../pos/returninwarddetails/Returninwarddetails_class.php");
require_once("../../pos/returninwardconsumables/Returninwardconsumables_class.php");
require_once("../../pos/returninwards/Returninwards_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../pos/config/Config_class.php");
require_once("../../pos/configaccounts/Configaccounts_class.php");
require_once("../../pos/packinglists/Packinglists_class.php");
require_once("../../pos/invoices/Invoices_class.php");

//$tenant = $_GET['tenant'];
$doc=$_GET['doc'];
$packingno=$_GET['packingno'];
$shippedon=$_GET['shippedon'];
$customerid = $_GET['customerid'];
$id=$_GET['id'];
$ob = (object)$_GET;

$customers = new Customers();
$fields="crm_customers.name, crm_customers.address,crm_customers.vatable, case when crm_customers.customerid is not null then customers.name else crm_customers.name end parent, case when crm_customers.customerid is not null then customers.address else crm_customers.address end parentaddress, crm_customers.code,pos_freights.name freightid, crm_agents.name agentid, crm_agents.address agentaddress, sys_currencys.name currencyid, sys_currencys.id currency";
$where=" where crm_customers.id='$customerid'";	
$join=" left join crm_agents on crm_agents.id=crm_customers.agentid left join sys_currencys on sys_currencys.id=crm_customers.currencyid left join pos_freights on pos_freights.id=crm_customers.freightid left join crm_customers customers on customers.id=crm_customers.customerid ";
$having="";
$groupby="";
$orderby="";
$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$customers = $customers->fetchObject;

$returninwards = new Returninwards();
$fields="*";
$join=" ";
$where=" where pos_returninwards.documentno='$doc' and types='$ob->types'";
$having="";
$groupby=" ";
$orderby="";
$returninwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$invs = $returninwards->fetchObject;

$invoices = new Invoices();
$fields="*";
$join=" ";
$where=" where pos_invoices.documentno='$invs->invoiceno'";
$having="";
$groupby=" ";
$orderby="";
$invoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$invoices = $invoices->fetchObject;


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

table{overflow-y:visible; overflow-x:hidden;}
table td {
text-align: left;
vertical-align: top;
border-right: 1px solid #ddd;
padding:8px;
line-height:none !important;
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
td{padding-left:0px !important;margin:0px !important;line-height:none !important;}
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
<!--<div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div>-->
<!-- headder -->
<div align="center" id="print_content" style="width:80%; border:1px gray solid; align:center; margin-left:10%;">
<div class="hfields" align="left">
<div align="center" style="page-break-inside:avoid; page-break-after:avoid; page-break-before:avoid; display:block;">
<span style="display:block; padding:3px 10px; font-size:14px; text-align:center; font-weight:bold;"><?php echo $_SESSION['companyname']; ?> </span>
<span style="display:block; padding:0px 0px 1px; font-size:11px;"><?php echo $_SESSION['companytitle']; ?></span>
<span style="display:block; padding:0px 0px 1px; font-size:11px;"><?php echo $_SESSION['companyaddr'];?>,<br/>
<span style="display:block; padding:0px 0px 1px; font-size:11px;"><?php echo $_SESSION['companydesc'];?></span>
<span style="display:block; padding:0px 0px 1px; font-size:11px;">Tel: <?php echo $_SESSION['companytel'];?></span>
<span class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <span class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span>
</div>
<hr/>
<span style="display:block; padding:3px 10px; font-size:12px; text-align:center; font-weight:bold;"> 
       <?php if($ob->types=="credit"){?>
       CREDIT NOTE
       <?php }else{ ?>
       DEBIT NOTE
       <?php } ?>
            <?php
            if($_GET['retrieved']==1){
				?>
				- Copy
				<?php 
			}
		?>
</span></div>
<hr/>
<table width="100%" style="font-size:10px;">
<tr style="height:auto;">
<td width="50%" colspan="3" cellspacing="0">
<h4>To:</h4>
		      <div style="font-size:11px !important;font-family:'arial narrow';"><strong> </strong><?php echo strtoupper($customers->name); ?><br><?php echo $customers->address; ?></div>
		     <!-- <div style="font-size:10px !important;"><strong>returninward No: </strong> <?php echo $doc; ?></div>-->
</td>
<td width="50%" colspan="4" cellspacing="0">
<h4>Sold To:</h4>
<div style="font-size:11px !important;"><strong>Client Name: </strong><?php echo strtoupper($customers->parent); ?><br/><?php echo $customers->parentaddress; ?></div><br/>
             <div style="font-size:11px !important;"><strong>Date:</strong> <?php echo formatDate($invs->returnedon);?></div>
            
</td>
</tr>
<tr style="height:auto;">
<td width="50%" colspan="7" cellspacing="0">
	<div style="font-size:11px !important;"><strong>Credit Note No: </strong><?php echo $invs->creditnotenos; ?></div>
	  <div style="font-size:11px !important;"><strong>Type: </strong><?php echo $invs->type; ?></div>
	<div style="font-size:11px !important;"><strong>Invoice No: </strong><?php echo $customers->code; ?><?php echo $invoices->invoiceno; ?></div>
	
</td>

</tr>
<tr style="height:auto;">

<td width="50%" colspan="4" cellspacing="0">
	<div style="font-size:11px !important;">Currency: <?php echo initialCap($customers->currencyid); ?></div>
<!-- 	<div style="font-size:12px !important;">No Of Boxes:<?php echo $inv->boxes; ?></div> -->
</td>
<td width="50%" colspan="3" cellspacing="0">
	  <div style="font-size:11px !important;">&nbsp;</div>
	<div style="font-size:11px !important;">&nbsp;</div>
            
</td>
</tr>
</table>

<!-- headerend -->

<!-- bodyyy -->
  
  <?php
  $tts=0;
  $returninwards = new returninwards();
  $fields=" pos_returninwarddetails.itemid, pos_returninwarddetails.sizeid, sum(pos_returninwarddetails.quantity) quantity, pos_returninwarddetails.price,sum(pos_returninwarddetails.quantity*pos_returninwarddetails.price*(100+pos_returninwards.vat)/100) total,sum(pos_returninwarddetails.quantity*pos_returninwarddetails.price*pos_returninwards.vat/100) vat ";
  $join=" left join pos_returninwarddetails on pos_returninwarddetails.returninwardid=pos_returninwards.id ";
  $where=" where pos_returninwards.documentno='$doc' ";
  $having="";
  $groupby=" group by itemid, sizeid ";
  $orderby="";
  $returninwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $returninwards->sql;
  if($returninwards->affectedRows>0){
    ?>
    <table width="100%" class="table-stripped table-bordered table" style="line-height:none;font-size:8px;">
   <thead>
   <tr>
	<td colspan="5" align="left"><h3>Flowering Items</h3></td>
    </tr>
    <tr>
      <th>#</th>
      <th>VARIETY</th>
      <th>SIZE</th>
      <th>QTY</th>
      <th>RATE</th>
      <th>VAT</th>
      <th>AMT</th>
    </tr>
   </thead>
<tbody style=" vertical-align: top;">
    <?
    $tquantity=0;
    $vat=0;
    $i=0;
    $ttss=0;
  while($row=mysql_fetch_object($returninwards->result)){
  if($customers->vatable=="Yes"){
//   $vat=(($row->total)*0.16);
  }
  $total=($row->total);
  $ttss+=$total;
  $tquantity+=$row->quantity;
  
  $items = new Items();
  $fields=" * ";
  $join="";
  $groupby="";
  $having="";
  $where=" where id='$row->itemid'";
  $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $items=$items->fetchObject;
  
  $sizes = new Sizes();
  $fields=" * ";
  $join="";
  $groupby="";
  $having="";
  $where=" where id='$row->sizeid'";
  $sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $sizes=$sizes->fetchObject;
  
  $i++;
   ?>
   <tr style="height:auto;">
    <td  cellspacing="0"><?php echo $i; ?></td>
    <td  cellspacing="0"><?php echo $items->name; ?></td>
    <td  cellspacing="0"><?php echo $sizes->name; ?></td>
    <td align="center" cellspacing="0"><?php echo $row->quantity; ?></td>
    <td align="right"  cellspacing="0"><?php echo $row->price; ?></td>
    <td align="right"  cellspacing="0"><?php echo $row->vat; ?></td>
    <td align="right"  cellspacing="0"><?php echo formatNumberD($total,2); ?></td>
   </tr>
   <?php
  }
  ?>
</tbody>
<tfoot>
  <tr>
    <td>&nbsp;</td>
    <td>Total</td>
    <td>&nbsp;</td>
    <td align="right"><?php echo $tquantity; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><?php echo formatNumberD($ttss,2); ?></td>
  </tr>
</tfoot>
  </table>
  
<!-- bodyend -->
<?php
} ?>

  <?php
  $tts=0;
  $returninwardconsumables = new Returninwardconsumables();
  $fields=" inv_items.name itemid, inv_unitofmeasures.name unitofmeasureid, pos_returninwardconsumables.quantity, pos_returninwardconsumables.price, pos_returninwardconsumables.total";
  $join=" left join pos_returninwards on pos_returninwardconsumables.returninwardid=pos_returninwards.id  left join inv_items on inv_items.id=pos_returninwardconsumables.itemid left join inv_unitofmeasures on inv_unitofmeasures.id=pos_returninwardconsumables.unitofmeasureid ";
  $where=" where pos_returninwards.documentno='$doc' ";
  $having="";
  $groupby=" ";
  $orderby="";
  $returninwardconsumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $returninwardconsumables->sql;
  if($returninwardconsumables->affectedRows>0){
    ?>
  <table width="100%" style="line-height:none;font-size:8px;">
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
  while($row=mysql_fetch_object($returninwardconsumables->result)){
  $tts+=$row->total;
   ?>
   <tr>
    <td><?php echo $row->itemid; ?></td>
    <td><?php echo $row->unitofmeasureid; ?></td>
    <td><?php echo $row->quantity; ?></td>
    <td><?php echo round($row->price,2); ?></td>
    <td><?php echo round($row->total,2); ?></td>
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
    <td colspan="4"><strong>Total (Non-Flower + Flower Items)</strong></td>
    <td><strong><?php echo formatNumber ($tts+$ttss); ?></strong></td>
  </tr>
   <tr><td colspan="5"><hr></td></tr>
  </table>

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
<table>

<tr>

<div style="font-size:10px !important;text-align:center;"><?php echo $declaration; ?></div>
</tr>

<tr>
<td align="left">
<div style="font-size:10px !important;float:left;">MEMO:<?php echo $invs->memo; ?>
</td>
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
