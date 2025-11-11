<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Landlordpayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addlandlordpayments_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Landlordpayments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4342";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$landlordpayments=new Landlordpayments();
if(!empty($delid)){
	$landlordpayments->id=$delid;
	$landlordpayments->delete($landlordpayments);
	redirect("landlordpayments.php");
}
//Authorization.
$auth->roleid="4341";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addlandlordpayments_proc.php'>New Landlordpayments</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document No </th>
			<th>Landlord </th>
			<th>Plot </th>
			<th>Payment Term </th>
			<th>Payment Mode </th>
			<th>Bank </th>
			<th>Cheque No </th>
			<th>Amount </th>
			<th>Paid On </th>
			<th>Month </th>
			<th>Year </th>
			<th>Received By </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4343";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4344";//View
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
		$fields="em_landlordpayments.id, em_landlordpayments.documentno, em_landlords.name as landlordid, em_plots.name as plotid, em_paymentterms.name as paymenttermid, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, em_landlordpayments.chequeno, em_landlordpayments.amount, em_landlordpayments.paidon, em_landlordpayments.month, em_landlordpayments.year, em_landlordpayments.receivedby, em_landlordpayments.remarks";
		$join=" left join em_landlords on em_landlordpayments.landlordid=em_landlords.id  left join em_plots on em_landlordpayments.plotid=em_plots.id  left join em_paymentterms on em_landlordpayments.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_landlordpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_landlordpayments.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$landlordpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$landlordpayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->landlordid; ?></td>
			<td><?php echo $row->plotid; ?></td>
			<td><?php echo $row->paymenttermid; ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->receivedby; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4343";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addlandlordpayments_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4344";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='landlordpayments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
