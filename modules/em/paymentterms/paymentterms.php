<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentterms_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Paymentterms";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4306";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$paymentterms=new Paymentterms();
if(!empty($delid)){
	$paymentterms->id=$delid;
	$paymentterms->delete($paymentterms);
	redirect("paymentterms.php");
}
//Authorization.
$auth->roleid="4305";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpaymentterms_proc.php',600,430);" value="Add Paymentterms " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Payment Term </th>
			<th> </th>
			<th>Payable To Landlord </th>
			<th>Journal Account </th>
			<th>Charge Mgt Fee </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4307";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4308";//View
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
		$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, fn_generaljournalaccounts.name as generaljournalaccountid, em_paymentterms.chargemgtfee, em_paymentterms.remarks, em_paymentterms.ipaddress, em_paymentterms.createdby, em_paymentterms.createdon, em_paymentterms.lasteditedby, em_paymentterms.lasteditedon";
		$join=" left join fn_generaljournalaccounts on em_paymentterms.generaljournalaccountid=fn_generaljournalaccounts.id ";
		$having="";
		$groupby="";
		$orderby="";
		$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$paymentterms->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo $row->payabletolandlord; ?></td>
			<td><?php echo $row->generaljournalaccountid; ?></td>
			<td><?php echo $row->chargemgtfee; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4307";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpaymentterms_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4308";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='paymentterms.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
