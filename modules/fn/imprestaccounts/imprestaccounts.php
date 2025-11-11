<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Imprestaccounts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Imprestaccounts";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8128";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$imprestaccounts=new Imprestaccounts();
if(!empty($delid)){
	$imprestaccounts->id=$delid;
	$imprestaccounts->delete($imprestaccounts);
	redirect("imprestaccounts.php");
}
//Authorization.
$auth->roleid="8127";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addimprestaccounts_proc.php',600,430);" value="Add Imprestaccounts " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Account Name </th>
			<th>Owned By </th>
			<th>Balance</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8129";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8130";//View
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
		$fields="fn_imprestaccounts.id, fn_imprestaccounts.name, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, fn_imprestaccounts.remarks, fn_imprestaccounts.ipaddress, fn_imprestaccounts.createdby, fn_imprestaccounts.createdon, fn_imprestaccounts.lasteditedby, fn_imprestaccounts.lasteditedon";
		$join=" left join hrm_employees on fn_imprestaccounts.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$imprestaccounts->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		$bal = mysql_fetch_object(mysql_query("select fn_generaljournalaccounts.id, sum(fn_generaljournals.debit-fn_generaljournals.credit) amount from fn_generaljournals left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid where fn_generaljournalaccounts.refid='$row->id' and fn_generaljournalaccounts.acctypeid=24"));
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="../../../reports/fn/generaljournals/account.php?id=<?php echo $bal->id; ?>"><?php echo $row->name; ?></a></td>
			<td><?php echo $row->employeeid; ?></td>
			<td align="right"><?php echo formatNumber($bal->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8129";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addimprestaccounts_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8130";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='imprestaccounts.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
