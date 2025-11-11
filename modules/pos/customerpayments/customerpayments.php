<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerpayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Customerpayments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4859";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$customerpayments=new Customerpayments();
if(!empty($delid)){
	$customerpayments->id=$delid;
	$customerpayments->delete($customerpayments);
	redirect("customerpayments.php");
}
//Authorization.
$auth->roleid="4858";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addcustomerpayments_proc.php',600,430);" value="Add Customerpayments " type="button"/></div>
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
$auth->roleid="4860";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4861";//View
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
		$fields="pos_customerpayments.id, pos_customerpayments.documentno, pos_customerpayments.invoiceno, crm_customers.name as customerid, pos_customerpayments.amount, sys_paymentmodes.name as paymentmodeid, pos_customerpayments.bankid, pos_customerpayments.chequeno, pos_customerpayments.paidon, pos_customerpayments.offsetid, pos_customerpayments.createdby, pos_customerpayments.createdon, pos_customerpayments.lasteditedby, pos_customerpayments.lasteditedon, pos_customerpayments.ipaddress";
		$join=" left join crm_customers on pos_customerpayments.customerid=crm_customers.id  left join sys_paymentmodes on pos_customerpayments.paymentmodeid=sys_paymentmodes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$customerpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$customerpayments->result;
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
$auth->roleid="4860";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcustomerpayments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4861";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='customerpayments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
