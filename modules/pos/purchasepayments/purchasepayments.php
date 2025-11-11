<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchasepayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Purchasepayments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2181";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$purchasepayments=new Purchasepayments();
if(!empty($delid)){
	$purchasepayments->id=$delid;
	$purchasepayments->delete($purchasepayments);
	redirect("purchasepayments.php");
}
//Authorization.
$auth->roleid="2180";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addpurchasepayments_proc.php',600,430);" value="Add Purchasepayments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document No. </th>
			<th>Invoive No. </th>
			<th>Supplier </th>
			<th>Amount </th>
			<th>Payment Mode </th>
			<th>Bank </th>
			<th>Cheque No. </th>
			<th>Paid On </th>
			<th>Offset </th>
<?php
//Authorization.
$auth->roleid="2182";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2183";//View
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
		$fields="pos_purchasepayments.id, pos_purchasepayments.documentno, pos_purchasepayments.invoiceno, pos_suppliers.name as supplierid, pos_purchasepayments.amount, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, pos_purchasepayments.chequeno, pos_purchasepayments.paidon, pos_purchasepayments.offsetid, pos_purchasepayments.createdby, pos_purchasepayments.createdon, pos_purchasepayments.lasteditedby, pos_purchasepayments.lasteditedon, pos_purchasepayments.ipaddress";
		$join=" left join pos_suppliers on pos_purchasepayments.supplierid=pos_suppliers.id  left join sys_paymentmodes on pos_purchasepayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on pos_purchasepayments.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$purchasepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$purchasepayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->invoiceno; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
			<td><?php echo $row->offsetid; ?></td>
<?php
//Authorization.
$auth->roleid="2182";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpurchasepayments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2183";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='purchasepayments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
