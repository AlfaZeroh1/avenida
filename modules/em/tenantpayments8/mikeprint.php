<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenantpayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addtenantpayments_proc.php");

$page_title="Tenantpayments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4258";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tenantpayments=new Tenantpayments();
if(!empty($delid)){
	$tenantpayments->id=$delid;
	$tenantpayments->delete($tenantpayments);
	redirect("tenantpayments.php");
}
//Authorization.
$auth->roleid="4257";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" href='addtenantpayments_proc.php'><span>NEW TENANT PAYMENTS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Tenant </th>
			<th>Receipt No </th>
			<th>Payment Term </th>
			<th>Payment Mode </th>
			<th>Bank </th>
			<th>Cheque No </th>
			<th>Amount </th>
			<th>Paid On </th>
			<th>Month </th>
			<th>Year </th>
			<th>Paid By </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4259";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4260";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_tenantpayments.id, em_tenants.name as tenantid, em_tenantpayments.documentno, em_paymentterms.name as paymenttermid, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, em_tenantpayments.chequeno, em_tenantpayments.amount, em_tenantpayments.paidon, em_tenantpayments.month, em_tenantpayments.year, em_tenantpayments.paidby, em_tenantpayments.remarks";
		$join=" left join em_tenants on em_tenantpayments.tenantid=em_tenants.id  left join em_paymentterms on em_tenantpayments.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_tenantpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_tenantpayments.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$tenantpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tenantpayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->tenantid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->paymenttermid; ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->paidby; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4259";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addtenantpayments_proc.php?id=<?php echo $row->id; ?>"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4260";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='tenantpayments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
