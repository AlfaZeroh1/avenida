<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Salepayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Salepayments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2201";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$salepayments=new Salepayments();
if(!empty($delid)){
	$salepayments->id=$delid;
	$salepayments->delete($salepayments);
	redirect("salepayments.php");
}
//Authorization.
$auth->roleid="2200";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addsalepayments_proc.php',600,430);" value="Add Salepayments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document No. </th>
			<th>Invoice No </th>
			<th>Customer </th>
			<th>Amount </th>
			<th>Payment Mode </th>
			<th>Bank </th>
			<th>Cheque No. </th>
			<th>Paid On </th>
			<th>Offset </th>
<?php
//Authorization.
$auth->roleid="2202";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2203";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="pos_salepayments.id, pos_salepayments.documentno, pos_salepayments.invoiceno, motor_customers.name as customerid, pos_salepayments.amount, sys_paymentmodes.name as paymentmodeid, pos_salepayments.bankid, pos_salepayments.chequeno, pos_salepayments.paidon, pos_salepayments.offsetid, pos_salepayments.createdby, pos_salepayments.createdon, pos_salepayments.lasteditedby, pos_salepayments.lasteditedon, pos_salepayments.ipaddress";
		$join=" left join motor_customers on pos_salepayments.customerid=motor_customers.id  left join sys_paymentmodes on pos_salepayments.paymentmodeid=sys_paymentmodes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$salepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$salepayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->invoiceno; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
			<td><?php echo $row->offsetid; ?></td>
<?php
//Authorization.
$auth->roleid="2202";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsalepayments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2203";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='salepayments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
