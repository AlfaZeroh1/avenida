<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payablehouserents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Payablehouserents";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4250";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$payablehouserents=new Payablehouserents();
if(!empty($delid)){
	$payablehouserents->id=$delid;
	$payablehouserents->delete($payablehouserents);
	redirect("payablehouserents.php");
}
//Authorization.
$auth->roleid="4249";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addpayablehouserents_proc.php',600,430);"><span>ADD PAYABLE HOUSE RENTS</span></a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Invoice No </th>
			<th>House </th>
			<th>Tenant </th>
			<th>Month </th>
			<th>Year </th>
			<th>Invoiced On </th>
			<th>Amount </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4251";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4252";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_payablehouserents.id, em_payablehouserents.documentno, em_houses.name as houseid, em_tenants.name as tenantid, em_payablehouserents.month, em_payablehouserents.year, em_payablehouserents.invoicedon, em_payablehouserents.amount, em_payablehouserents.remarks";
		$join=" left join em_houses on em_payablehouserents.houseid=em_houses.id  left join em_tenants on em_payablehouserents.tenantid=em_tenants.id ";
		$having="";
		$groupby="";
		$orderby="";
		$payablehouserents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$payablehouserents->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->tenantid; ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo formatDate($row->invoicedon); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4251";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpayablehouserents_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4252";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='payablehouserents.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
