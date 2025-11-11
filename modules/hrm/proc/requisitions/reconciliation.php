<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../proc/requisitiondetails/Requisitiondetails_class.php");
require_once("../../proc/requisitions/Requisitions_class.php");
require_once("../../proc/purchaseorderdetails/Purchaseorderdetails_class.php");
require_once("../../proc/deliverynotedetails/Deliverynotedetails_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Procurement Reconciliation";

include"../../../head.php";

$db = new DB();

$obj=(object)$_POST;
$title="";
if($obj->action=="Submit")
{
	
}

if($obj->action=="Reconcile Now")
{
	$bankreconciliations = new Bankreconciliations();
	if($obj->bankbal>0)
		$obj->debit=$obj->bankbal;
	else
		$obj->credit=(-1*$obj->bankbal);
		
	$obj->balance=$obj->bankbal;
	$obj->bankid=$obj->bank;
	$bankreconciliations = $bankreconciliations->setObject($obj);
	if($bankreconciliations->add($bankreconciliations))
	{
		redirect("printrecon.php?bankid=".$obj->bankid."&todate=".$obj->todate);
	}
	else
		$error="Could not perform Reconciliation";
}
else
	$obj->balcheck=0;
?>
<script language="javascript" type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../../js/cal.js"></script>
<script type="text/javascript">   
jQuery(document).ready(function () {
	$('input.date_input').simpleDatepicker();
});
</script>
<script type="text/javascript" language="javascript">
 
$(document).ready(function() {
   	$('.check_row input:checkbox').click(function(){
		var curTrId = $(this).closest('tr').attr('id');
		var debitVal = $('#' +curTrId+ '.check_row').find('td.debit').html();
		var creditVal = $('#' +curTrId+ '.check_row').find('td.credit').html();
		var dbVal = parseFloat(debitVal);
		var crVal = parseFloat(creditVal);
		var viewBal = parseFloat($('input#bankbal').val());
		var balcheck = parseFloat($('input#balcheck').val());
		if(isNaN(balcheck))
			balcheck=0;
			
		var balance;
		if($(this).attr('checked') == 1){	
			viewBal = viewBal+dbVal-crVal;
			balance=viewBal-balcheck;
			$('input#bankbal').val(viewBal);
			$('input#balance').val(balance);
			$('input#balanceval').val(balance);
			$('#' +curTrId+ '.check_row').css('background-color','#f0f000');
			//alert('is checked ' + viewBal);
		}	
		else{
		 	//var viewBal = parseFloat($('input#balCheck').val());
			viewBal = viewBal-dbVal+crVal;
			balance=viewBal-balcheck;
			$('input#bankbal').val(viewBal);
			$('input#balance').val(balance);
			$('input#balanceval').val(balance);
			$('#' +curTrId+ '.check_row').css('background-color','#fff');
			//alert('is not checked ' + viewBal);
	  }
	});
	
});
 </script>
<script language="javascript" type="text/javascript">
function setStatus(str)
{
if(str.checked)
{
	var status="checked";
	var recondate = document.getElementById("todate").value;
}
else
{
	var status="unchecked";
	var recondate="0000-00-00";
}
	
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  var url="status.php?id="+str.value+"&status="+status+"&date="+recondate;
xmlhttp.open("GET",url,true);
xmlhttp.send();
}
</script>
<script type="text/javascript" language="javascript">
function loadBalance()
{
	var bn = document.recon.bankval.value;	
	var bl = document.recon.balcheck.value;
	var balance = bn-bl;
	document.recon.balance.value=balance;
	document.recon.balanceval.value=balance;
}
</script>
 

<script type="text/javascript" language="javascript">
function loadBalance()
{
	var bn = document.recon.bankval.value;	
	var bl = document.recon.balcheck.value;
	var balance = bn-bl;
	document.recon.balance.value=balance;
	document.recon.balanceval.value=balance;
}
</script>
<!-- InstanceEndEditable -->
<style media="all" type="text/css">
#navamenu
{
visibility:hidden;
}
</style>

</head>
<?php
if (get_magic_quotes_gpc()){
 $_GET = array_map('stripslashes', $_GET);
 $_POST = array_map('stripslashes', $_POST);
 $_COOKIE = array_map('stripslashes', $_COOKIE);
}
?>
<body>

          <form action="reconciliation.php" method="post" name="recon">
            <div style="float:left;"><strong>Requisition No:</strong>
                   <input name="documentno" type="text" id="documentno" value="<?php echo $obj->documentno; ?>" size="10" />
		  &nbsp;&nbsp;<input name="reqs" type='checkbox'/>Show Requsition Details
		  &nbsp;&nbsp;<input name="lpos" type='checkbox'/>Show LPOs
		  &nbsp;&nbsp;<input name="dlvrs" type='checkbox'/>Show Deliverys
		  &nbsp;&nbsp;<input name="invoices" type='checkbox'/>Show Invoices
                   &nbsp; <input type="submit" class="btn" name="action" id="action" value="Submit" />
               		&nbsp;&nbsp;&nbsp;                  </strong><?php showError($error); ?></div>
 
 <table border="0" align="center" class="tgrid gridd display" id="example">
  <?php
  $requisitions = new Requisitions();
  $fields="proc_requisitions.documentno, proc_requisitions.requisitiondate, con_projects.name projectid";
  $join=" left join con_projects on con_projects.id=proc_requisitions.projectid ";
  $orderby="";
  $groupby="";
  $where=" where proc_requisitions.documentno='$obj->documentno' ";
  $requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $requisitions = $requisitions->fetchObject;
  ?>
 <thead>
 <tr>
    <td colspan="9" bgcolor="#BCCBDE"><strong>Reconciliation Report</strong>( <?php echo "Requisition No: $requisitions->documentno Project: $requisitions->projectid Requisitioned On: ".formatDate($requisitions->requisitiondate); ?>)</td>
    </tr> 
  <tr>
   <th  class="lines" align="center">&nbsp;</th>
    <th class="lines">#</th>
    <th class="lines"><div align="center"><strong>Item</strong></div></th>
    <th class="lines"><div align="center"><strong>Rate</strong></div></th>
    <th class="lines"><div align="center"><strong>Quantity</strong></div></th>
    <th class="lines"><div align="center"><strong>Required On</strong></div></th>
   <th align="right" width="2%" class="lines">&nbsp;</th>
    </tr></thead>
    <tbody>
    <?php
    if(empty($obj->reqs) and !empty($obj->lpos)){
    ?>
    <tr>
  <td colspan='7'>
  <table style="margin-left:10px;">
  <tr>
    <th>&nbsp;</th>
    <th>#</th>    
    <th>LPO No</th>
    <th>Item</th>
    <th>Rate</th>
    <th>Quantity</th>
    <th>Date Ordered</th>
    <th>&nbsp;</th>
  </tr>
    <?
  }
	$i=0;
	$requisitiondetails = new Requisitiondetails();
	$fields="proc_requisitiondetails.costprice rate, proc_requisitions.documentno, sum(proc_requisitiondetails.quantity) quantity, proc_requisitiondetails.requiredon, inv_items.id item, inv_items.name itemid";
	$orderby="";
	$groupby=" group by documentno, itemid";
	$join=" left join proc_requisitions on proc_requisitions.id=proc_requisitiondetails.requisitionid left join inv_items on inv_items.id=proc_requisitiondetails.itemid ";
	$where=" where proc_requisitions.documentno='$obj->documentno' ";
	$requisitiondetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo mysql_error();echo $requisitions->sql;
	while($row=mysql_fetch_object($requisitiondetails->result))
	{$i++;
	if(!empty($obj->reqs)){
	?>
  <tr id = "<?php echo 'trRow'.$i; ?>" class="check_row" style="background-color:<?php if($row->reconstatus=='checked'){echo'#f0f000';}else{echo'#fff';}?>">
  <td class="lines" align="center"><input name="<?php echo $row->id; ?>" type="checkbox" value="<?php echo $row->id; ?>" onchange="setStatus(this)" <?php if($row->reconstatus=='checked'){echo"checked";}?> /></td>
    <td class="lines"><?php echo $i; ?></td>
    <td class="lines"><?php echo $row->itemid; ?></td>
    <td class="lines"><?php echo $row->rate; ?></td>
    <td class="lines debit"><?php echo $row->quantity; ?></td>
    <td class="lines credit"><?php echo formatDate($row->requiredon); ?></td>
     <td align="right" class="lines">&nbsp;</td>
  </tr>
  <?php
  }
  
  //show lpos under each requisition itemid
  $purchaseorderdetails = new Purchaseorderdetails();
  $fields="proc_purchaseorderdetails.id, proc_purchaseorders.documentno, proc_purchaseorders.orderedon, inv_items.id item, inv_items.name as itemid, sum(proc_purchaseorderdetails.quantity) quantity, proc_purchaseorderdetails.costprice, proc_purchaseorderdetails.tradeprice, proc_purchaseorderdetails.tax, proc_purchaseorderdetails.total, proc_purchaseorderdetails.memo, proc_purchaseorderdetails.ipaddress, proc_purchaseorderdetails.createdby, proc_purchaseorderdetails.createdon, proc_purchaseorderdetails.lasteditedby, proc_purchaseorderdetails.lasteditedon";
  $join=" left join proc_purchaseorders on proc_purchaseorderdetails.purchaseorderid=proc_purchaseorders.id  left join inv_items on proc_purchaseorderdetails.itemid=inv_items.id ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where $obj->documentno in (proc_purchaseorders.requisitionno) and inv_items.id=$row->item ";
  $purchaseorderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $rs=$purchaseorderdetails->result;
  if($purchaseorderdetails->affectedRows>0){
    if(!empty($obj->lpos)){ $j=0;
  ?>
  <tr>
  <td colspan='7'>
  <table style="margin-left:10px;">
  <tr>
    <th>&nbsp;</th>
    <th>#</th>    
    <th>LPO No</th>
    <th>Item</th>
    <th>Rate</th>
    <th>Quantity</th>
    <th>Date Ordered</th>
    <th>&nbsp;</th>
  </tr>
  <?php
  }
  while($rw=mysql_fetch_object($rs)){
    $j++;
    if(!empty($obj->lpos)){
    ?>
  <tr id = "<?php echo 'trRow'.$i; ?>" class="check_rw" style="background-color:<?php if($rw->reconstatus=='checked'){echo'#f0f000';}else{echo'#fff';}?>">
  <td class="lines" align="center"><input name="<?php echo $rw->id; ?>" type="checkbox" value="<?php echo $rw->id; ?>" onchange="setStatus(this)" <?php if($rw->reconstatus=='checked'){echo"checked";}?> /></td>
    <td class="lines"><?php echo ($j); ?></td>
    <td class="lines"><?php echo $rw->documentno; ?></td>
    <td class="lines"><?php echo $rw->itemid; ?></td>
    <td class="lines"><?php echo $rw->rate; ?></td>
    <td class="lines debit"><?php echo $rw->quantity; ?></td>
    <td class="lines credit"><?php echo formatDate($rw->orderedon); ?></td>
     <td align="right" class="lines">&nbsp;</td>
  </tr>
  <?php
  }  
  
  $deliverynotedetails = new Deliverynotedetails();
  $fields="proc_deliverynotedetails.id, proc_deliverynotes.documentno, proc_deliverynotes.deliveredon, inv_items.name as itemid, sum(proc_deliverynotedetails.quantity) quantity";
  $join=" left join proc_deliverynotes on proc_deliverynotedetails.deliverynoteid=proc_deliverynotes.id  left join inv_items on proc_deliverynotedetails.itemid=inv_items.id ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where $rw->documentno in (proc_deliverynotes.lpono) and inv_items.id=$rw->item ";
  $deliverynotedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $rss=$deliverynotedetails->result;
  if($deliverynotedetails->affectedRows>0){
  if(!empty($obj->dlvrs)){
    ?>
    <tr>
  <td colspan='8'>
  <table style="margin-left:10px;">
  <tr>
    <th>&nbsp;</th>
    <th>#</th>    
    <th>Delivery No</th>
    <th>Item</th>
    <th>Quantity</th>
    <th>Date Delivered</th>
    <th>&nbsp;</th>
  </tr>
    <?php
  while($rw1=mysql_fetch_object($deliverynotedetails->result)){
  ?>
    <tr id = "<?php echo 'trRow'.$i; ?>" class="check_rw1" style="background-color:<?php if($rw1->reconstatus=='checked'){echo'#f0f000';}else{echo'#fff';}?>">
  <td class="lines" align="center"><input name="<?php echo $rw1->id; ?>" type="checkbox" value="<?php echo $rw1->id; ?>" onchange="setStatus(this)" <?php if($rw1->reconstatus=='checked'){echo"checked";}?> /></td>
    <td class="lines"><?php echo ($j); ?></td>
    <td class="lines"><?php echo $rw1->documentno; ?></td>
    <td class="lines"><?php echo $rw1->itemid; ?></td>
    <td class="lines debit"><?php echo $rw1->quantity; ?></td>
    <td class="lines credit"><?php echo formatDate($rw1->deliveredon); ?></td>
     <td align="right" class="lines">&nbsp;</td>
  </tr>
  <?php
  }
  }
  }
  }
  ?>
  </table>
  </td>
  </tr>
  <?php
  
  }
}    
  ?>
 </tbody>
 <tfoot>
 <tr>
  <td colspan='7' align="center"><input type="submit" name="action" class="btn btn-warning" value="Reconcile"/>
  </td>
  </tr>
  </tfoot>
</table>
</form>
			
  <?php
include"../../../foot.php";
?>
