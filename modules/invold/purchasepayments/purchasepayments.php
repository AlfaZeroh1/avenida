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
$auth->roleid="712";//View
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
$auth->roleid="711";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpurchasepayments_proc.php',600,430);" value="Add Purchasepayments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Supplier </th>
			<th>Amount </th>
			<th>Mode Of Payment </th>
			<th>Bank </th>
			<th>Cheque No. </th>
			<th>Payment Date </th>
			<th>Offset </th>
			<th>Document No. </th>
<?php
//Authorization.
$auth->roleid="713";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="714";//View
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
		$fields="inv_purchasepayments.id, inv_purchasepayments.supplierid, inv_purchasepayments.amount, inv_purchasepayments.paymentmodeid, inv_purchasepayments.bank, inv_purchasepayments.chequeno, inv_purchasepayments.paymentdate, inv_purchasepayments.offsetid, inv_purchasepayments.createdby, inv_purchasepayments.createdon, inv_purchasepayments.lasteditedby, inv_purchasepayments.lasteditedon, inv_purchasepayments.documentno, inv_purchasepayments.ipaddress";
		$join="";
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
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bank; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo formatDate($row->paymentdate); ?></td>
			<td><?php echo $row->offsetid; ?></td>
			<td><?php echo $row->documentno; ?></td>
<?php
//Authorization.
$auth->roleid="713";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpurchasepayments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="714";//View
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
