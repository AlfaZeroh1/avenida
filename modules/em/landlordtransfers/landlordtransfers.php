<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Landlordtransfers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Redirect to horizontal layout
redirect("addlandlordtransfers_proc.php");

$page_title="Landlordtransfers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8464";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$landlordtransfers=new Landlordtransfers();
if(!empty($delid)){
	$landlordtransfers->id=$delid;
	$landlordtransfers->delete($landlordtransfers);
	redirect("landlordtransfers.php");
}
//Authorization.
$auth->roleid="8463";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addlandlordtransfers_proc.php',600,430);" value="Add Landlordtransfers " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Voucher No </th>
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
$auth->roleid="8465";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8466";//Add
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
		$fields="em_landlordtransfers.id, em_landlordtransfers.documentno, em_landlords.name as landlordid, em_plots.name as plotid, em_paymentterms.name as paymenttermid, em_sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, em_landlordtransfers.chequeno, em_landlordtransfers.amount, em_landlordtransfers.paidon, em_landlordtransfers.month, em_landlordtransfers.year, em_landlordtransfers.receivedby, em_landlordtransfers.remarks, em_landlordtransfers.ipaddress, em_landlordtransfers.createdby, em_landlordtransfers.createdon, em_landlordtransfers.lasteditedby, em_landlordtransfers.lasteditedon";
		$join=" left join em_landlords on em_landlordtransfers.landlordid=em_landlords.id  left join em_plots on em_landlordtransfers.plotid=em_plots.id  left join em_paymentterms on em_landlordtransfers.paymenttermid=em_paymentterms.id  left join em_sys_paymentmodes on em_landlordtransfers.paymentmodeid=em_sys_paymentmodes.id  left join fn_banks on em_landlordtransfers.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$landlordtransfers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$landlordtransfers->result;
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
$auth->roleid="8465";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addlandlordtransfers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8466";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='landlordtransfers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
