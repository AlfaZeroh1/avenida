<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Confirmedorders_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../pos/packinglists/Packinglists_class.php");
require_once("../../pos/packinglistreturns/Packinglistreturns_class.php");
require_once("../../pos/invoices/Invoices_class.php");
require_once("../../pos/packinglistdetails/Packinglistdetails_class.php");

require_once("../../pos/confirmedorderdetails/Confirmedorderdetails_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
//redirect("addconfirmedorders_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Confirmedorders";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8704";//View
$auth->levelid=$_SESSION['level'];

$obj = (object)$_POST;
$ob = (object)$_GET;

if(empty($obj->orderedon)){
  $obj->orderedon=date("Y-m-d");
  $obj->toorderedon=date("Y-m-d");
}

if(!empty($ob->report)){
  $obj->report=$ob->report;
}

auth($auth);
if(!empty($obj->report)){
  include"../../../rptheader.php";
  
}else{
  include"../../../head.php";
}


$delid=$_GET['delid'];
$confirmedorders=new Confirmedorders();
if(!empty($delid)){
	$confirmedorders->id=$delid;
	$confirmedorders->delete($confirmedorders);
	redirect("confirmedorders.php");
}
//Authorization.
$auth->roleid="8703";//View
$auth->levelid=$_SESSION['level'];

?>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {

	
	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
		"sScrollY": 500,
		"bJQueryUI": true,
		"iDisplayLength":20,
		"sPaginationType": "full_numbers"
	} );
} );
</script>

<form action="" method="post">
<?php
if(empty($obj->report)){
  if(existsRule($auth)){
  ?>
  <div style="float:left;" class="buttons"> <a  class="btn btn-info" href='addconfirmedorders_proc.php'>New Confirmedorders</a></div>
  <?php }?>

  <div>
    <input name="orderedon" type="text" size="12" value="<?php echo $obj->orderedon; ?>" class="date_input" readonly/>
<?php
}else{
  ?>
  <div>
  From: <input name="orderedon" type="text" size="12" value="<?php echo $obj->orderedon; ?>" class="date_input" readonly/>
  To: <input name="toorderedon" type="text" size="12" value="<?php echo $obj->toorderedon; ?>" class="date_input" readonly/>
  
  <?php
}
?>
    <input type="hidden" name="report" value="<?php echo $obj->report; ?>"/>
    <input type="submit" class="btn btn-info" name="action" value="Filter"/>
  </div>
</form>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Order No </th>
			<th>Customer </th>
			<th>Remarks </th>
			<th>Packing No</th>
			<th>Invoice</th>
			<th>Total Boxes</th>
			<th>Stems</th>
			<th>Packed Boxes</th>
			<th>Stems</th>
			<th>Returned Boxes</th>
			<th>Stems</th>
			<th>Total  Boxes Packed</th>
			<th>Stems</th>


			<!--<th>Pack Rate</th>-->
<?php
if(empty($obj->report)){
//Authorization.
$auth->roleid="8705";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8671";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php 
}
}
?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="pos_confirmedorders.id, pos_confirmedorders.orderno, crm_customers.id customer, crm_customers.name as customerid, pos_confirmedorders.orderedon, pos_confirmedorders.remarks, pos_confirmedorders.ipaddress, pos_confirmedorders.createdby, pos_confirmedorders.createdon, pos_confirmedorders.lasteditedby, pos_confirmedorders.lasteditedon";
		$join=" left join crm_customers on pos_confirmedorders.customerid=crm_customers.id ";
		$having="";
		$groupby=" group by orderno ";
		$orderby="";
		if(!empty($obj->orderedon) and empty($obj->report)){
		  $where=" where pos_confirmedorders.orderedon='$obj->orderedon' ";
		}else{
		  if(!empty($obj->report)){
		    $where=" where pos_confirmedorders.orderedon>='$obj->orderedon' and pos_confirmedorders.orderedon<='$obj->toorderedon' ";
		  }
		}
		$confirmedorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$confirmedorders->result;
		$totalboxes=0;
		$totalpacked=0;
		while($row=mysql_fetch_object($res)){
		$i++;
		$packinglists =new Packinglists();
		$fields=" distinct pos_packinglists.boxno, group_concat(distinct pos_packinglists.documentno) documentno ,pos_packinglists.id,  count(*) boxes ";
		$join=" ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pos_packinglists.orderno='$row->orderno'";
		$packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $packinglists->sql;
		$packinglists = $packinglists->fetchObject;
		
		$packinglistdetails = new Packinglistdetails();
		$fields=" sum(quantity) quantity ";
		$join=" ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where packinglistid in(select id from pos_packinglists where orderno='$row->orderno') and quantity>0 ";
		$packinglistdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $packinglists->sql;
		$packinglistdetails = $packinglistdetails->fetchObject;
		if($packinglistdetails->quantity=="")
		  $packinglistdetails->quantity=0;

		$confirmedorderdetails = new Confirmedorderdetails();
		$fields="sum(pos_confirmedorderdetails.quantity) quantity, sum(pos_confirmedorderdetails.quantity*pos_confirmedorderdetails.packrate) total, pos_confirmedorderdetails.packrate";
		$join=" left join pos_confirmedorders on pos_confirmedorders.id=pos_confirmedorderdetails.confirmedorderid ";
		$where=" where pos_confirmedorders.orderno='$row->orderno' and DATE(pos_confirmedorders.orderedon)='$obj->orderedon'";
		$having="";
		$groupby="";
		$orderby="";
		$confirmedorderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$confirmedorderdetails = $confirmedorderdetails->fetchObject;
		if($packinglists->boxes==0)
		  $packinglists->boxes="";
		  
		$packinglistss =new Packinglists();
		$fields=" distinct pos_packinglists.boxno, pos_packinglists.documentno ,pos_packinglists.id,  count(*) boxreturns ";
		$join=" ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pos_packinglists.documentno='$packinglists->documentno' and returns=1 ";
		$packinglistss->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $packinglists->sql;
		$packinglistss = $packinglistss->fetchObject;
		
		
		$packinglistdetailss = new Packinglistdetails();
		$fields=" sum(quantity) quantity ";
		$join=" ";
		$having="";
		$groupby="";
		$orderby="";
		//$where=" where packinglistid in(select id from pos_packinglists where orderno='$row->orderno' and DATE(pos_packinglists.createdon)='$obj->orderedon' and returns=1) ";
		$where=" where packinglistid in(select id from pos_packinglists where orderno='$row->orderno' and returns=1) and quantity<1 ";
		$packinglistdetailss->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $packinglists->sql;
		$packinglistdetailss = $packinglistdetailss->fetchObject;
		if($packinglistdetailss->quantity=="")
		  $packinglistdetailss->quantity=0;
		
		
		$invoices = new Invoices();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where packingno='$packinglists->documentno' ";
		$invoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$invoices = $invoices->fetchObject;
		
		$totalboxes+=$confirmedorderdetails->quantity;
		$totalpacked+=$packinglists->boxes;
		$packinglistdetails1+=$packinglistdetails->quantity;
		$packinglistss1+=$packinglistss->boxreturns;
		$packinglistdetailss1+=$packinglistdetailss->quantity;
		$confirmedorderdetails1+=$confirmedorderdetails->total;
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->orderno; ?></td>
			<td><?php echo strtoupper($row->customerid); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $packinglists->documentno; ?></td>
			<td><a href="../invoices/addinvoices_proc.php?retrieve=1&documentno=<?php echo $invoices->documentno; ?>"><?php echo $invoices->documentno; ?></td>
			<td><?php echo $confirmedorderdetails->quantity; ?></td>
			<td><?php echo $confirmedorderdetails->total; ?></td>
			<td><a href="../packinglists/packinglists.php?packingno=<?php echo $packinglists->documentno; ?>"><?php echo $packinglists->boxes; ?></td>
			<td><?php echo $packinglistdetails->quantity; ?></td>
			<td><? echo $packinglistss->boxreturns; ?></td>			
			<td><?php echo $packinglistdetailss->quantity; ?></td>
			<td><? echo ($packinglists->boxes-$packinglistss->boxreturns); ?></td>
			<td><?php echo ($packinglistdetails->quantity+$packinglistdetailss->quantity); ?></td>

<!-- 			<td><?php //echo $confirmedorderdetails->packrate; ?></td> -->
<?php
if(empty($obj->report)){
//Authorization.
$auth->roleid="8705";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addconfirmedorders_proc.php?orderno=<?php echo $row->orderno; ?>">View</a></td>
			<td><a href='../packinglists/addpackinglists_proc.php?packingno=<?php echo $packinglists->documentno; ?>&customerid=<?php echo $row->customer; ?>&boxno=<?php echo $packinglists->boxes+1; ?>'>Packing</a></td>
<?php
}
//Authorization.

$auth->roleid="8671";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
//   if($packinglists->boxes!=$confirmedorderdetails->quantity){
  ?>
			<td><a href='../packinglists/addpackinglists_proc.php?orderno=<? echo $row->orderno; ?>&boxing=1&packingno=<?php echo $packinglists->documentno; ?>&boxno=<?php echo $packinglists->boxes+1; ?>&customerid=<?php echo $row->customer; ?>'>Boxing</a></td>
			<?php if(!empty($packinglists->documentno)){?>
			<td>
			<?php //if($invoices->documentno==''){ ?>
			<a href='../packinglists/addpackinglists_proc.php?returns=1&packingno=<?php echo $packinglists->documentno; ?>&customerid=<?php echo $row->customer; ?>&box=1'>Returns</a>
			<?php //} ?>
			</td>
			<?php }else{?>
			<td>&nbsp;</td>
			<?php }?>
<?php //}
//else{?>
<!-- 			<td>Complete</td> -->
<?php //}
}
}?>
		</tr>
	<?php 
	}
	?>
	</tbody>
	<tfoot>
	<tr>
	  <th>&nbsp;</th>
	  <th>&nbsp;</th>
	  <th>&nbsp;</th>
	  <th>&nbsp;</th>
	  <th>&nbsp;</th>
	  <th>&nbsp;</th>
	  <th>Total Boxes:<br/><B><?php echo $totalboxes; ?></B></th>
	  <th>Total Stems:<br/><B><?php echo $confirmedorderdetails1;  ?></B></th>
	  <th>Total Packed Boxes:<br/><B><?php echo $totalpacked; ?></B></th>
	  <th>Total Packed Stems:<br/><B><?php echo $packinglistdetails1; ?></B></th>
	  <th>Total Returned Boxes:<br/><B><?php echo $packinglistss1; ?></B></th>  
	  <th>Total Returned Stems:<br/><B><?php echo $packinglistdetailss1; ?></B></th>
	  <th>Total Packed Boxes(Less returns):<br/><B><?php echo ($totalpacked-$packinglistss1); ?></B></th>
	  <th>Total Packed stems (Less returns):<br/><B><?php echo ($packinglistdetails1-$packinglistdetailss1); ?></B></th>
	  <?php
	  if(empty($obj->report)){
//Authorization.
$auth->roleid="8705";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8706";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php }
}?>
	</tr>
	</tfoot>
</table>
<?php
include"../../../foot.php";
?>
