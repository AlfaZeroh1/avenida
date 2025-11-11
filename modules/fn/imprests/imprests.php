<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Imprests_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addimprests_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Imprests";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8132";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$imprests=new Imprests();
if(!empty($delid)){
	$imprests->id=$delid;
	$imprests->delete($imprests);
	redirect("imprests.php");
}
//Authorization.
$auth->roleid="8131";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addimprests_proc.php'>New Imprests</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Imprest No </th>
			<th>Payment Voucher No </th>
			<th>Imprest Account </th>
			<th>Owned By </th>
			<th>Issued On </th>
			<th>Payment Mode </th>
			<th>Bank </th>
			<th>Cheque No </th>
			<th>Amount </th>
			<th>Memo </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8133";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8134";//View
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
		$fields="fn_imprests.id, fn_imprests.documentno, fn_imprests.paymentvoucherno, fn_imprestaccounts.name as imprestaccountid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, fn_imprests.issuedon, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, fn_imprests.chequeno, fn_imprests.amount, fn_imprests.memo, fn_imprests.remarks, fn_imprests.ipaddress, fn_imprests.createdby, fn_imprests.createdon, fn_imprests.lasteditedby, fn_imprests.lasteditedon";
		$join=" left join fn_imprestaccounts on fn_imprests.imprestaccountid=fn_imprestaccounts.id  left join hrm_employees on fn_imprests.employeeid=hrm_employees.id  left join sys_paymentmodes on fn_imprests.paymentmodeid=sys_paymentmodes.id  left join fn_banks on fn_imprests.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$imprests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$imprests->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->paymentvoucherno; ?></td>
			<td><?php echo $row->imprestaccountid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatDate($row->issuedon); ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8133";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addimprests_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8134";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='imprests.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
